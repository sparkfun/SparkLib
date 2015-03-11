<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class UltimateConsigneeType
{

  /**
   *
   * @var string $CompanyName
   * @access public
   */
  public $CompanyName = null;

  /**
   *
   * @var AddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   *
   * @var UltimateConsigneeTypeType $UltimateConsigneeType
   * @access public
   */
  public $UltimateConsigneeType = null;

  /**
   *
   * @param string $CompanyName
   * @param AddressType $Address
   * @param UltimateConsigneeTypeType $UltimateConsigneeType
   * @access public
   */
  public function __construct($CompanyName = null, $Address = null, $UltimateConsigneeType = null)
  {
    $this->CompanyName = $CompanyName;
    $this->Address = $Address;
    $this->UltimateConsigneeType = $UltimateConsigneeType;
  }

  /**
   *
   * @return string
   */
  public function getCompanyName()
  {
    return $this->CompanyName;
  }

  /**
   *
   * @param string $CompanyName
   */
  public function setCompanyName($CompanyName)
  {
    $this->CompanyName = $CompanyName;
  }

  /**
   *
   * @return AddressType
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   *
   * @param AddressType $Address
   */
  public function setAddress($Address)
  {
    $this->Address = $Address;
  }

  /**
   *
   * @return UltimateConsigneeTypeType
   */
  public function getUltimateConsigneeType()
  {
    return $this->UltimateConsigneeType;
  }

  /**
   *
   * @param UltimateConsigneeTypeType $UltimateConsigneeType
   */
  public function setUltimateConsigneeType($UltimateConsigneeType)
  {
    $this->UltimateConsigneeType = $UltimateConsigneeType;
  }

}
