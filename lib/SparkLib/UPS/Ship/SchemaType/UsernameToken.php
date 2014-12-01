<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class UsernameToken
{

  /**
   *
   * @var string $Username
   * @access public
   */
  public $Username = null;

  /**
   *
   * @var string $Password
   * @access public
   */
  public $Password = null;

  /**
   *
   * @param string $Username
   * @param string $Password
   * @access public
   */
  public function __construct($Username = null, $Password = null)
  {
    $this->Username = $Username;
    $this->Password = $Password;
  }

  /**
   *
   * @return string
   */
  public function getUsername()
  {
    return $this->Username;
  }

  /**
   *
   * @param string $Username
   */
  public function setUsername($Username)
  {
    $this->Username = $Username;
  }

  /**
   *
   * @return string
   */
  public function getPassword()
  {
    return $this->Password;
  }

  /**
   *
   * @param string $Password
   */
  public function setPassword($Password)
  {
    $this->Password = $Password;
  }

}
