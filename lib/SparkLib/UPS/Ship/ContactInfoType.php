<?php

namespace SparkLib\UPS\Ship;

class ContactInfoType
{

  /**
   * 
   * @var string $Name
   * @access public
   */
  public $Name = null;

  /**
   * 
   * @var ShipPhoneType $Phone
   * @access public
   */
  public $Phone = null;

  /**
   * 
   * @param string $Name
   * @param ShipPhoneType $Phone
   * @access public
   */
  public function __construct($Name = null, $Phone = null)
  {
    $this->Name = $Name;
    $this->Phone = $Phone;
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

}
