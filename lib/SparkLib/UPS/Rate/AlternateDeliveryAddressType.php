<?php

namespace SparkLib\UPS\Rate;

class AlternateDeliveryAddressType
{

  /**
   * 
   * @var string $Name
   * @access public
   */
  public $Name = null;

  /**
   * 
   * @var ADRType $Address
   * @access public
   */
  public $Address = null;

  /**
   * 
   * @param string $Name
   * @param ADRType $Address
   * @access public
   */
  public function __construct($Name = null, $Address = null)
  {
    $this->Name = $Name;
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
   * @return ADRType
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   * 
   * @param ADRType $Address
   */
  public function setAddress($Address)
  {
    $this->Address = $Address;
  }

}
