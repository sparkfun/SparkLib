<?php

namespace SparkLib\UPS\Ship;

class ServiceAccessToken
{

  /**
   * 
   * @var string $AccessLicenseNumber
   * @access public
   */
  public $AccessLicenseNumber = null;

  /**
   * 
   * @param string $AccessLicenseNumber
   * @access public
   */
  public function __construct($AccessLicenseNumber = null)
  {
    $this->AccessLicenseNumber = $AccessLicenseNumber;
  }

  /**
   * 
   * @return string
   */
  public function getAccessLicenseNumber()
  {
    return $this->AccessLicenseNumber;
  }

  /**
   * 
   * @param string $AccessLicenseNumber
   */
  public function setAccessLicenseNumber($AccessLicenseNumber)
  {
    $this->AccessLicenseNumber = $AccessLicenseNumber;
  }

}
