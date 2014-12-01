<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class SoldToType
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
   * @var string $TaxIdentificationNumber
   * @access public
   */
  public $TaxIdentificationNumber = null;

  /**
   *
   * @var PhoneType $Phone
   * @access public
   */
  public $Phone = null;

  /**
   *
   * @var string $Option
   * @access public
   */
  public $Option = null;

  /**
   *
   * @var AddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   *
   * @var string $EMailAddress
   * @access public
   */
  public $EMailAddress = null;

  /**
   *
   * @param string $Name
   * @param string $AttentionName
   * @param string $TaxIdentificationNumber
   * @param PhoneType $Phone
   * @param string $Option
   * @param AddressType $Address
   * @param string $EMailAddress
   * @access public
   */
  public function __construct($Name = null, $AttentionName = null, $TaxIdentificationNumber = null, $Phone = null, $Option = null, $Address = null, $EMailAddress = null)
  {
    $this->Name = $Name;
    $this->AttentionName = $AttentionName;
    $this->TaxIdentificationNumber = $TaxIdentificationNumber;
    $this->Phone = $Phone;
    $this->Option = $Option;
    $this->Address = $Address;
    $this->EMailAddress = $EMailAddress;
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
   * @return PhoneType
   */
  public function getPhone()
  {
    return $this->Phone;
  }

  /**
   *
   * @param PhoneType $Phone
   */
  public function setPhone($Phone)
  {
    $this->Phone = $Phone;
  }

  /**
   *
   * @return string
   */
  public function getOption()
  {
    return $this->Option;
  }

  /**
   *
   * @param string $Option
   */
  public function setOption($Option)
  {
    $this->Option = $Option;
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
   * @return string
   */
  public function getEMailAddress()
  {
    return $this->EMailAddress;
  }

  /**
   *
   * @param string $EMailAddress
   */
  public function setEMailAddress($EMailAddress)
  {
    $this->EMailAddress = $EMailAddress;
  }

}
