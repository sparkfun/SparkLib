<?php

namespace SparkLib\UPS\Rate;

class ADRType
{

  /**
   * 
   * @var string $AddressLine
   * @access public
   */
  public $AddressLine = null;

  /**
   * 
   * @var string $City
   * @access public
   */
  public $City = null;

  /**
   * 
   * @var string $StateProvinceCode
   * @access public
   */
  public $StateProvinceCode = null;

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
   * @var string $ResidentialAddressIndicator
   * @access public
   */
  public $ResidentialAddressIndicator = null;

  /**
   * 
   * @var string $POBoxIndicator
   * @access public
   */
  public $POBoxIndicator = null;

  /**
   * 
   * @param string $AddressLine
   * @param string $City
   * @param string $StateProvinceCode
   * @param string $PostalCode
   * @param string $CountryCode
   * @param string $ResidentialAddressIndicator
   * @param string $POBoxIndicator
   * @access public
   */
  public function __construct($AddressLine = null, $City = null, $StateProvinceCode = null, $PostalCode = null, $CountryCode = null, $ResidentialAddressIndicator = null, $POBoxIndicator = null)
  {
    $this->AddressLine = $AddressLine;
    $this->City = $City;
    $this->StateProvinceCode = $StateProvinceCode;
    $this->PostalCode = $PostalCode;
    $this->CountryCode = $CountryCode;
    $this->ResidentialAddressIndicator = $ResidentialAddressIndicator;
    $this->POBoxIndicator = $POBoxIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getAddressLine()
  {
    return $this->AddressLine;
  }

  /**
   * 
   * @param string $AddressLine
   */
  public function setAddressLine($AddressLine)
  {
    $this->AddressLine = $AddressLine;
  }

  /**
   * 
   * @return string
   */
  public function getCity()
  {
    return $this->City;
  }

  /**
   * 
   * @param string $City
   */
  public function setCity($City)
  {
    $this->City = $City;
  }

  /**
   * 
   * @return string
   */
  public function getStateProvinceCode()
  {
    return $this->StateProvinceCode;
  }

  /**
   * 
   * @param string $StateProvinceCode
   */
  public function setStateProvinceCode($StateProvinceCode)
  {
    $this->StateProvinceCode = $StateProvinceCode;
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

  /**
   * 
   * @return string
   */
  public function getResidentialAddressIndicator()
  {
    return $this->ResidentialAddressIndicator;
  }

  /**
   * 
   * @param string $ResidentialAddressIndicator
   */
  public function setResidentialAddressIndicator($ResidentialAddressIndicator)
  {
    $this->ResidentialAddressIndicator = $ResidentialAddressIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getPOBoxIndicator()
  {
    return $this->POBoxIndicator;
  }

  /**
   * 
   * @param string $POBoxIndicator
   */
  public function setPOBoxIndicator($POBoxIndicator)
  {
    $this->POBoxIndicator = $POBoxIndicator;
  }

}
