<?php

namespace SparkLib\UPS\Ship;

class IntermediateConsigneeType
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
   * @param string $CompanyName
   * @param AddressType $Address
   * @access public
   */
  public function __construct($CompanyName = null, $Address = null)
  {
    $this->CompanyName = $CompanyName;
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
