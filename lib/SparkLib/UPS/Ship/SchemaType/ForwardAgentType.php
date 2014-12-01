<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ForwardAgentType
{

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
   * @param string $CompanyName
   * @param string $TaxIdentificationNumber
   * @param AddressType $Address
   * @access public
   */
  public function __construct($CompanyName = null, $TaxIdentificationNumber = null, $Address = null)
  {
    $this->CompanyName = $CompanyName;
    $this->TaxIdentificationNumber = $TaxIdentificationNumber;
    $this->Address = $Address;
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

}
