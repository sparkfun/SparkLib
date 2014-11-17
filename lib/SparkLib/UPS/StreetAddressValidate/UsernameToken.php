<?php

namespace SparkLib\UPS\StreetAddressValidate;

class UsernameToken
{

    /**
     * @var string $Username
     * @access public
     */
    public $Username = null;

    /**
     * @var string $Password
     * @access public
     */
    public $Password = null;

    /**
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
     * @return string
     */
    public function getUsername()
    {
      return $this->Username;
    }

    /**
     * @param string $Username
     * @return \SparkLib\UPS\StreetAddressValidate\UsernameToken
     */
    public function setUsername($Username)
    {
      $this->Username = $Username;
      return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
      return $this->Password;
    }

    /**
     * @param string $Password
     * @return \SparkLib\UPS\StreetAddressValidate\UsernameToken
     */
    public function setPassword($Password)
    {
      $this->Password = $Password;
      return $this;
    }

}
