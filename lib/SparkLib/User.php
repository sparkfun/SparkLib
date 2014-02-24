<?php
namespace SparkLib;

/**
 * SparkLib\User - Base user class for all users of the application.
 */
class User {

  protected $_isAuthenticated = false;

  public function isAuthenticated ()
  {
    return $this->_isAuthenticated;
  }

}
