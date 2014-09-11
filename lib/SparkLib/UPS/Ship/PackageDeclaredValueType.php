<?php

namespace SparkLib\UPS\Ship;

class PackageDeclaredValueType
{

  /**
   * 
   * @var DeclaredValueType $Type
   * @access public
   */
  public $Type = null;

  /**
   * 
   * @var string $CurrencyCode
   * @access public
   */
  public $CurrencyCode = null;

  /**
   * 
   * @var string $MonetaryValue
   * @access public
   */
  public $MonetaryValue = null;

  /**
   * 
   * @param DeclaredValueType $Type
   * @param string $CurrencyCode
   * @param string $MonetaryValue
   * @access public
   */
  public function __construct($Type = null, $CurrencyCode = null, $MonetaryValue = null)
  {
    $this->Type = $Type;
    $this->CurrencyCode = $CurrencyCode;
    $this->MonetaryValue = $MonetaryValue;
  }

  /**
   * 
   * @return DeclaredValueType
   */
  public function getType()
  {
    return $this->Type;
  }

  /**
   * 
   * @param DeclaredValueType $Type
   */
  public function setType($Type)
  {
    $this->Type = $Type;
  }

  /**
   * 
   * @return string
   */
  public function getCurrencyCode()
  {
    return $this->CurrencyCode;
  }

  /**
   * 
   * @param string $CurrencyCode
   */
  public function setCurrencyCode($CurrencyCode)
  {
    $this->CurrencyCode = $CurrencyCode;
  }

  /**
   * 
   * @return string
   */
  public function getMonetaryValue()
  {
    return $this->MonetaryValue;
  }

  /**
   * 
   * @param string $MonetaryValue
   */
  public function setMonetaryValue($MonetaryValue)
  {
    $this->MonetaryValue = $MonetaryValue;
  }

}
