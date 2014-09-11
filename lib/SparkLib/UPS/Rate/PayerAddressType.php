<?php

namespace SparkLib\UPS\Rate;

class PayerAddressType
{

  /**
   * 
   * @var string $PostalCode
   * @access public
   */
  public $PostalCode = null;

  /**
   * 
   * @var string $CountryCode
   * @access public
   */
  public $CountryCode = null;

  /**
   * 
   * @param string $PostalCode
   * @param string $CountryCode
   * @access public
   */
  public function __construct($PostalCode = null, $CountryCode = null)
  {
    $this->PostalCode = $PostalCode;
    $this->CountryCode = $CountryCode;
  }

  /**
   * 
   * @return string
   */
  public function getPostalCode()
  {
    return $this->PostalCode;
  }

  /**
   * 
   * @param string $PostalCode
   */
  public function setPostalCode($PostalCode)
  {
    $this->PostalCode = $PostalCode;
  }

  /**
   * 
   * @return string
   */
  public function getCountryCode()
  {
    return $this->CountryCode;
  }

  /**
   * 
   * @param string $CountryCode
   */
  public function setCountryCode($CountryCode)
  {
    $this->CountryCode = $CountryCode;
  }

}
