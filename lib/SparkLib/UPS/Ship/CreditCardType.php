<?php

namespace SparkLib\UPS\Ship;

class CreditCardType
{

  /**
   * 
   * @var string $Type
   * @access public
   */
  public $Type = null;

  /**
   * 
   * @var string $Number
   * @access public
   */
  public $Number = null;

  /**
   * 
   * @var string $ExpirationDate
   * @access public
   */
  public $ExpirationDate = null;

  /**
   * 
   * @var string $SecurityCode
   * @access public
   */
  public $SecurityCode = null;

  /**
   * 
   * @var CreditCardAddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   * 
   * @param string $Type
   * @param string $Number
   * @param string $ExpirationDate
   * @param string $SecurityCode
   * @param CreditCardAddressType $Address
   * @access public
   */
  public function __construct($Type = null, $Number = null, $ExpirationDate = null, $SecurityCode = null, $Address = null)
  {
    $this->Type = $Type;
    $this->Number = $Number;
    $this->ExpirationDate = $ExpirationDate;
    $this->SecurityCode = $SecurityCode;
    $this->Address = $Address;
  }

  /**
   * 
   * @return string
   */
  public function getType()
  {
    return $this->Type;
  }

  /**
   * 
   * @param string $Type
   */
  public function setType($Type)
  {
    $this->Type = $Type;
  }

  /**
   * 
   * @return string
   */
  public function getNumber()
  {
    return $this->Number;
  }

  /**
   * 
   * @param string $Number
   */
  public function setNumber($Number)
  {
    $this->Number = $Number;
  }

  /**
   * 
   * @return string
   */
  public function getExpirationDate()
  {
    return $this->ExpirationDate;
  }

  /**
   * 
   * @param string $ExpirationDate
   */
  public function setExpirationDate($ExpirationDate)
  {
    $this->ExpirationDate = $ExpirationDate;
  }

  /**
   * 
   * @return string
   */
  public function getSecurityCode()
  {
    return $this->SecurityCode;
  }

  /**
   * 
   * @param string $SecurityCode
   */
  public function setSecurityCode($SecurityCode)
  {
    $this->SecurityCode = $SecurityCode;
  }

  /**
   * 
   * @return CreditCardAddressType
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   * 
   * @param CreditCardAddressType $Address
   */
  public function setAddress($Address)
  {
    $this->Address = $Address;
  }

}
