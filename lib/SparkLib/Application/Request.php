<?php
namespace SparkLib\Application;

use \SparkLib\Application;

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
   * Require request parameters to be non-empty, and then check
   * them against provided filters.  A convenience wrapper around
   * expect() and filter().
   */
  public function expectFiltered (array $filters)
  {
    $failures = array();

    // first, did we get all the desired fields?
    try {
      $this->expect(array_keys($filters));
    } catch (\SparkLib\Application\RequestException $e) {
      $missing = $e->getErrors();
    }

    // second, do they pass the provided filters?
    try {
      $this->filter($filters);
    } catch (\SparkLib\Application\RequestException $e) {
      $invalid = $e->getErrors();
    }

    if (isset($missing)) {
      foreach ($missing as $field => $val)
        $failures[$field] = $val;
    }

    if (isset($invalid)) {
      foreach ($invalid as $field => $val)
        $failures[$field] = $val;
    }

    if ($failures)
      throw new \SparkLib\Application\RequestException($failures);
  }

  /**
   * Require request parameters to be non-empty(). For example, in a
   * Controller action:
   *
   *   $this->req()->expect('foo', 'bar');
   *
   * @param mixed... array or variable length list of parameters to expect
   * @throws \SparkLib\Application\RequestException
   */
  public function expect ()
  {
    $args = func_get_args();

    // DIRTY DIRTY HACK
    if (is_array($args[0]))
      $expectations = $args[0];
    else
      $expectations = $args;

    // Check everything in requires to make sure we have a value
    $failures = $this->checkParams($expectations, $this->_values);

    if (count($failures) > 0)
      throw new \SparkLib\Application\RequestException($failures);
  }

  private function checkParams ($expectation, $value)
  {
    $failures = [];

    if (is_array($expectation)) {
      foreach ($expectation as $key => $expected) {
        $check = is_array($expected) ? $key : $expected;
        $fail = $this->checkParams($expected, $value[$check]);
        $failures = array_merge($failures, $fail);
      }
    } else if (!is_array($value) && !strlen(trim($value))) {
      $failures[$expectation] = 'missing';
    }

    return $failures;
  }

  /**
   * Match request parameters against filters.
   *
   *   $filters = array(
   *     'foo' => 'FILTER_VALIDATE_INT',
   *     'bar' => '/^[a-z]+$/',
   *     'baz' => function ($value) {
   *       if ($value == 'barf') {
   *         return false;
   *       }
   *       return true;
   *     }
   *   );
   *   $this->req()->filter($filters);
   *
   * A filter may be the name of a filter constant, a / delimited
   * PCRE expression, or an anonymous function which takes one parameter
   * and returns true to pass or false to fail.
   *
   * Like expect(), this will throw a \SparkLib\Application\RequestException if something
   * doesn't match, because programmers suck at checking error conditions and
   * I'd rather make failures obvious. Wrap it in a catch block if you want to
   * handle things more gracefully than a "Something broke". RequestException
   * provides getErrors(), which returns the array of validation errors.
   *
   * See also: http://www.php.net/manual/en/filter.filters.validate.php
   *
   * @param array filters to check against specific parameters
   * @throws \SparkLib\Application\RequestException
   */
  public function filter (array $filters)
  {
    $failures = array();

    // Check every param in the request against any defined filters
    foreach ($filters as $param => $filter)
    {
      // If we weren't given a value, don't filter it.
      // (If you want to mandate that the value is set, use expect() or expectFiltered())
      // There is a special case here for the string '0', which empty() considers empty.
      // Let Lerdorf hope that I never encounter him in a dark alley.
      if (empty($this->_values[$param]) && ($this->_values[$param] !== '0')) {
        continue;
      }

      $errstring = 'invalid';
      if (is_array($filter)) {
        $errstring = $filter[1];
        $filter = $filter[0];
      }

      if (is_string($filter)) {

        if ($filter[0] === '/') // treat the filter as a regexp
        {
          // fail if no match:
          if (! preg_match($filter, $this->_values[$param]))
            $failures[$param] = $errstring;
        }
        // treat the filter as a builtin filter
        elseif (filter_var($this->_values[$param], constant($filter)) === FALSE)
        {
          $failures[$param] = $errstring;
        }

      } elseif (is_callable($filter)) {

        // treat the filter as a callback
        if (! $filter($this->_values[$param]))
          $failures[$param] = $errstring;

      }
    }

    if (count($failures) > 0)
      throw new \SparkLib\Application\RequestException($failures);
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
