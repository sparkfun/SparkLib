<?php

namespace SparkLib\UPS\StreetAddressValidate;

class UPSSecurity
{

    /**
     * @var UsernameToken $UsernameToken
     * @access public
     */
    public $UsernameToken = null;

    /**
     * @var ServiceAccessToken $ServiceAccessToken
     * @access public
     */
    public $ServiceAccessToken = null;

    /**
     * @param UsernameToken $UsernameToken
     * @param ServiceAccessToken $ServiceAccessToken
     * @access public
     */
    public function __construct($UsernameToken = null, $ServiceAccessToken = null)
    {
      $this->UsernameToken = $UsernameToken;
      $this->ServiceAccessToken = $ServiceAccessToken;
    }

    /**
     * @return UsernameToken
     */
    public function getUsernameToken()
    {
      return $this->UsernameToken;
    }

    /**
     * @param UsernameToken $UsernameToken
     * @return \SparkLib\UPS\StreetAddressValidate\UPSSecurity
     */
    public function setUsernameToken($UsernameToken)
    {
      $this->UsernameToken = $UsernameToken;
      return $this;
    }

    /**
     * @return ServiceAccessToken
     */
    public function getServiceAccessToken()
    {
      return $this->ServiceAccessToken;
    }

    /**
     * @param ServiceAccessToken $ServiceAccessToken
     * @return \SparkLib\UPS\StreetAddressValidate\UPSSecurity
     */
    public function setServiceAccessToken($ServiceAccessToken)
    {
      $this->ServiceAccessToken = $ServiceAccessToken;
      return $this;
    }

}
