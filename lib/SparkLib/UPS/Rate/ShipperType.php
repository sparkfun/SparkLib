<?php

namespace SparkLib\UPS\Rate;

class ShipperType
{

  /**
   * 
   * @var string $Name
   * @access public
   */
  public $Name = null;

  /**
   * 
   * @var string $ShipperNumber
   * @access public
   */
  public $ShipperNumber = null;

  /**
   * 
   * @var AddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   * 
   * @param string $Name
   * @param string $ShipperNumber
   * @param AddressType $Address
   * @access public
   */
  public function __construct($Name = null, $ShipperNumber = null, $Address = null)
  {
    $this->Name = $Name;
    $this->ShipperNumber = $ShipperNumber;
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
  public function getShipperNumber()
  {
    return $this->ShipperNumber;
  }

  /**
   * 
   * @param string $ShipperNumber
   */
  public function setShipperNumber($ShipperNumber)
  {
    $this->ShipperNumber = $ShipperNumber;
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
