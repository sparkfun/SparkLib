<?php
namespace SparkLib;

/**
 * Model the components of a URL as a simple object.
 */
class URLParser {

  protected $_parsed     = false;
  protected $_string     = '';
  protected $_components = array();
  protected $_req        = array();

  // to be used to detect search engines. in preg format.
  protected $_searchEngines = array(
    '.*google\.*',
    '.*bing\.com.*',
    '.*ask\.com.*',
    '.*search\.msn\.*',
    '.*search\.yahoo.*',
  );

  public function __construct ($url)
  {
    $this->_string = $url;

    if (is_array($this->_components = parse_url($this->_string))) {
      $this->_parsed = true;

      if (isset($this->_components['query'])) {
        parse_str($this->_components['query'], $this->_req);
      }
    }
  }

  /**
   * Were we successful at parsing a URL string?
   */
  public function parsed () { return $this->_parsed; }


  /**
   * Just get at the original URL string.
   */
  public function string () { return $this->_string; }

  /**
   * Get components of the URL.
   */
  public function __get ($key)
  {
    return $this->_components[$key];
  }

  /**
   * Get an object representing the GET request params, if PHP could parse
   * any, of the URL.
   */
  public function req ()
  {
    return (object)$this->_req;
  }

  /**
   * Get request GET params as an array, if we have any.
   */
  public function getReqArray()
  {
    return $this->_req;
  }

  /**
   * Do we think this looks like a search engine?
   */
  public function isSearchEngine ()
  {
    $search_re = '{https?://(' . implode('|', $this->_searchEngines) . ')}i';
    if (preg_match($search_re, $this->_string)) {
      return true;
    }
    return false;
  }
}
