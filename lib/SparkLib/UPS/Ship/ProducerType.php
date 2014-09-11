<?php

namespace SparkLib\UPS\Ship;

class ProducerType
{

  /**
   * 
   * @var string $Option
   * @access public
   */
  public $Option = null;

  /**
   * 
   * @var string $CompanyName
   * @access public
   */
  public $CompanyName = null;

  /**
   * 
   * @var string $TaxIdentificationNumber
   * @access public
   */
  public $TaxIdentificationNumber = null;

  /**
   * 
   * @var AddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   * 
   * @var string $AttentionName
   * @access public
   */
  public $AttentionName = null;

  /**
   * 
   * @var PhoneType $Phone
   * @access public
   */
  public $Phone = null;

  /**
   * 
   * @var string $EMailAddress
   * @access public
   */
  public $EMailAddress = null;

  /**
   * 
   * @param string $Option
   * @param string $CompanyName
   * @param string $TaxIdentificationNumber
   * @param AddressType $Address
   * @param string $AttentionName
   * @param PhoneType $Phone
   * @param string $EMailAddress
   * @access public
   */
  public function __construct($Option = null, $CompanyName = null, $TaxIdentificationNumber = null, $Address = null, $AttentionName = null, $Phone = null, $EMailAddress = null)
  {
    $this->Option = $Option;
    $this->CompanyName = $CompanyName;
    $this->TaxIdentificationNumber = $TaxIdentificationNumber;
    $this->Address = $Address;
    $this->AttentionName = $AttentionName;
    $this->Phone = $Phone;
    $this->EMailAddress = $EMailAddress;
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
