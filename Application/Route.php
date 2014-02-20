<?php
namespace SparkLib\Application;

/**
 * Model components of a route. See SparkLib\Application.
 */
class Route {

  protected $_route = array();

  public function __construct (array $route)
  {
    $this->_route = $route;
  }

  public function __get ($component)
  {
    if (isset($this->_route[$component]))
      return $this->_route[$component];
    return false;
  }

}
