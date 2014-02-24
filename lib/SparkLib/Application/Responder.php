<?php
namespace SparkLib\Application;

/**
 * A place for Controllers to put response callbacks. See
 * docs for Controller&respondTo().
 */
class Responder {

  protected $_callbacks;

  /**
   * @param $callbacks array optional hash of functions for type extensions
   */
  public function __construct (array $callbacks = array())
  {
    $this->_callbacks = $callbacks;
  }

  /**
   * Set a callback function for a type using property syntax.
   */
  public function __set ($type, $callback)
  {
    $this->_callbacks[$type] = $callback;
  }

  public function __isset ($type)
  {
    return isset($this->_callbacks[$type]);
  }

  /**
   * Call, if set, the appropriate callback for a desired content type.
   */
  public function run ($type)
  {
    if ($callback = $this->_callbacks[$type])
      // Careful here - it's a fatal error if this isn't a function:
      return $callback();
    else
      throw new \Exception('No callback provided for ' . $type);
  }

}
