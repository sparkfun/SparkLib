<?php

namespace SparkLib\UPS\Ship;

class ShipFromType
{

  /**
   *
   * @var string $Name
   * @access public
   */
  public $Name = null;

  /**
   *
   * @var string $AttentionName
   * @access public
   */
  public $AttentionName = null;

  /**
   *
   * @var string $CompanyDisplayableName
   * @access public
   */
  public $CompanyDisplayableName = null;

  /**
   *
   * @var string $TaxIdentificationNumber
   * @access public
   */
  public $TaxIdentificationNumber = null;

  /**
   *
   * @var TaxIDCodeDescType $TaxIDType
   * @access public
   */
  public $TaxIDType = null;

  /**
   *
   * @var ShipPhoneType $Phone
   * @access public
   */
  public $Phone = null;

  /**
   *
   * @var string $FaxNumber
   * @access public
   */
  public $FaxNumber = null;

  /**
   *
   * @var ShipAddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   *
   * @param string $Name
   * @param string $AttentionName
   * @param string $CompanyDisplayableName
   * @param string $TaxIdentificationNumber
   * @param TaxIDCodeDescType $TaxIDType
   * @param ShipPhoneType $Phone
   * @param string $FaxNumber
   * @param ShipAddressType $Address
   * @access public
   */
  public function __construct($Name = null, $AttentionName = null, $CompanyDisplayableName = null, $TaxIdentificationNumber = null, $TaxIDType = null, $Phone = null, $FaxNumber = null, $Address = null)
  {
    $this->Name = $Name;
    $this->AttentionName = $AttentionName;
    $this->CompanyDisplayableName = $CompanyDisplayableName;
    $this->TaxIdentificationNumber = $TaxIdentificationNumber;
    $this->TaxIDType = $TaxIDType;
    $this->Phone = $Phone;
    $this->FaxNumber = $FaxNumber;
    $this->Address = $Address;
  }

  /**
   *
   * @return string
   */
  public function getName()
  {
    return $this->Name;
  }

  /**
   *
   * @param string $Name
   */
  public function setName($Name)
  {
    $this->Name = $Name;
  }

  /**
   *
   * @return string
   */
  public function getAttentionName()
  {
    return $this->AttentionName;
  }

  /**
   *
   * @param string $AttentionName
   */
  public function setAttentionName($AttentionName)
  {
    $this->AttentionName = $AttentionName;
  }

  /**
   *
   * @return string
   */
  public function getCompanyDisplayableName()
  {
    return $this->CompanyDisplayableName;
  }

  /**
   *
   * @param string $CompanyDisplayableName
   */
  public function setCompanyDisplayableName($CompanyDisplayableName)
  {
    $this->CompanyDisplayableName = $CompanyDisplayableName;
  }

  /**
   *
   * @return string
   */
  public function getTaxIdentificationNumber()
  {
    return $this->TaxIdentificationNumber;
  }

  /**
   *
   * @param string $TaxIdentificationNumber
   */
  public function setTaxIdentificationNumber($TaxIdentificationNumber)
  {
    $this->TaxIdentificationNumber = $TaxIdentificationNumber;
  }

  /**
   *
   * @return TaxIDCodeDescType
   */
  public function getTaxIDType()
  {
    return $this->TaxIDType;
  }

  /**
   *
   * @param TaxIDCodeDescType $TaxIDType
   */
  public function setTaxIDType($TaxIDType)
  {
    $this->TaxIDType = $TaxIDType;
  }

  /**
   *
   * @return ShipPhoneType
   */
  public function getPhone()
  {
    return $this->Phone;
  }

  /**
   *
   * @param ShipPhoneType $Phone
   */
  public function setPhone($Phone)
  {
    $this->Phone = $Phone;
  }

  /**
   *
   * @return string
   */
  public function getFaxNumber()
  {
    return $this->FaxNumber;
  }

  /**
   *
   * @param string $FaxNumber
   */
  public function setFaxNumber($FaxNumber)
  {
    $this->FaxNumber = $FaxNumber;
  }

  /**
   *
   * @return ShipAddressType
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   *
   * @param ShipAddressType $Address
   */
  public function setAddress($Address)
  {
    $this->Address = $Address;
  }

}
