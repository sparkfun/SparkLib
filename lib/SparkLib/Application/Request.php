<?php
namespace SparkLib\Application;

use \SparkLib\Application;
use \SparkLib\Validator;

/**
 * Model an inbound HTTP request.
 *
 * Children of this class, Get, Post, Head, and Delete, are used by Application
 * and friends as proxies for $_GET, $_POST, and $_REQUEST, or possibly for other
 * values treated as such by things like Environment\CLI.
 *
 * At this point, you might reasonably ask why we're going out of our way to obscure
 * such fundamental features of PHP.
 *
 * 1. It should be impossible to directly rewrite elements of the request.
 * 2. Runtime configuration options like magic quotes have to be dealt with somewhere.
 * 3. I wanted somewhere to hang validation of request parameters.
 * 4. Object-property syntax is prettier than array-element syntax.
 *
 * @author Brennen Bearnes <brennen@sparkfun.com>
 */
abstract class Request {

  protected $_values   = array();
  protected $_final    = false;
  protected $_injected = array();
  protected $_mime     = 'text/html';

  /**
   * Build a new request.
   *
   * @param $values array
   * @param string
   */
  public function __construct (array $values)
  {
    $this->_values = $values;
  }

  /**
   * Set a desired MIME type for this request.
   */
  public function setType ($mime)
  {
    if ($this->isFinal()) {
      throw new \Exception("can't set a new MIME type for a finalized SparkRequest");
    }
    return $this->_mime = $mime;
  }

  /**
   * Get the MIME type of this request.
   */
  public function getType ()
  {
    return $this->_mime;
  }

  /**
   * Set our MIME type based on a file type extension.
   */
  public function setTypeFromExtension ($ext)
  {
    if (isset(Application::$extensionToMime[$ext]))
      return $this->setType(Application::$extensionToMime[$ext]);
    return false;
  }

  /**
   * Map the current MIME type to a default extension.
   */
  public function mapType ()
  {
    return Application::$mimeToExtension[$this->_mime];
    //return $this->_mimeWhitelist[$this->_mime];
  }

  /**
   * Explicitly inject a parameter => value, such as id. (See
   * Application&discernRoute().)
   *
   * @param string $param
   * @param string $value
   * @return string $value
   */
  public function inject ($param, $value)
  {
    if ($this->_final)
      throw new \Exception('Request already finalized, cannot inject a value.');

    $this->_values[$param]   = $value;
    $this->_injected[$param] = true;
    return $value;
  }


  /**
   * Getter magic for accessing a request parameter.
   */
  public function __get ($key)
  {
    if (! isset($this->_values[$key]))
      return null;
    return $this->_values[$key];
  }

  public function expect ()
  {
    $args = func_get_args();

    // DIRTY DIRTY HACK
    if (is_array($args[0]))
      $expectations = $args[0];
    else
      $expectations = $args;

    return (new Validator($this->_values, '\SparkLib\Application\RequestException'))->expect($expectations);
  }

  public function expectFiltered (array $filters)
  {
    return (new Validator($this->_values, '\SparkLib\Application\RequestException'))->expectFiltered($filters);
  }

  public function filter (array $filters)
  {
    return (new Validator($this->_values, '\SparkLib\Application\RequestException'))->filter($filters);
  }

  /**
   * Get a particular HTTP header (or reasonable facsimile)
   *
   * TODO: This should really be handled by the environment, but
   * right now there's no very clean way to just grab all the headers
   * as a nice associative array without doing a bunch of expensive
   * string comparison.
   *
   * Anyway, this should fail gracefully in the CLI environment, so I
   * guess I'm not too worried about it for the moment.
   */
  public function getHeader ($header)
  {
    $key = 'HTTP_' . str_replace('-', '_', strtoupper($header));
    if (isset($_SERVER[$key]))
      return $_SERVER[$key];
    else
      return null;
  }

  /**
   * Did the client send a Do Not Track header?
   *
   * http://www.w3.org/TR/tracking-dnt/
   */
  public function doNotTrack ()
  {
    $value = $this->getHeader('DNT');
    return isset($value) && $value == '1';
  }

  /**
   * If this object is cloned, render it mutable.
   *
   * If you are doing this, it's probably because you're taking the
   * existing request, changing one or more of its properties, and
   * reserializing it in some fashion.
   *
   * There might be problems with this approach.
   */
  public function __clone ()
  {
    $this->unFinalize();
  }

  /**
   * Get an array of all parameters set on this request.
   *
   * @return array of keys
   */
  public function getParameters ()
  {
    return array_keys($this->_values);
  }

  /**
   * Prevent further modifications to the parameters of this request.
   */
  public function finalize () { $this->_final = true; }

  /**
   * Allow modification of request parameters.
   */
  public function unFinalize () { $this->_final = false; }

  /**
   * Is the request finalized and thus theoretically immutable?
   *
   * @return bool
   */
  public function isFinal  () { return $this->_final; }

  /**
   * Set a parameter.
   *
   * @param string parameter
   * @param string value
   * @return string value set
   */
  public function __set ($key, $value)
  {
    if ($this->isFinal())
      throw new Exception("can't change a finalized Request (trying to modify user input? make a copy instead.)");
    return $this->_values[$key] = $value;
  }

  /**
   * Check if a parameter is set.
   *
   * @param string parameter name
   * @return bool set or not?
   */
  public function __isset ($key)
  {
    return isset($this->_values[$key]);
  }

  /**
   * Get a count of parameters.
   */
  public function count ()
  {
    return count($this->_values);
  }

  /**
   * Get array of current values.
   *
   * @return array
   */
  public function getArray ()
  {
    return $this->_values;
  }

  /**
   * Return a query string.
   *
   * @param bool skip_injected skips values that were injected by
   * Application (eg: id from /controller/id?key=value)
   */
  public function compact ($skip_injected = false)
  {
    $compacted = array();
    foreach ($this->_values as $key => $value) {
      if ($skip_injected && isset($this->_injected[$key]))
        continue;
      $compacted[$key] = $value;
    }

    return '?' . http_build_query($compacted);
  }

  /**
   * Indicates whether or not the request is an XMLHttpRequest
   *
   * @returns boolean
   */
  public function isXHR ()
  {
    if ($req_with = $this->getHeader('X-Requested-With')) {
      if ('xmlhttprequest' === strtolower($req_with)) {
        return true;
      }
    }
    return false;
  }

}
