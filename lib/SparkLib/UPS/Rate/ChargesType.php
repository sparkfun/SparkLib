<?php

namespace SparkLib\UPS\Rate;

class ChargesType
{

  /**
   * 
   * @var string $Code
   * @access public
   */
  public $Code = null;

  /**
   * 
   * @var string $Description
   * @access public
   */
  public $Description = null;

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
   * @var string $SubType
   * @access public
   */
  public $SubType = null;

  /**
   * 
   * @param string $Code
   * @param string $Description
   * @param string $CurrencyCode
   * @param string $MonetaryValue
   * @param string $SubType
   * @access public
   */
  public function __construct($Code = null, $Description = null, $CurrencyCode = null, $MonetaryValue = null, $SubType = null)
  {
    $this->Code = $Code;
    $this->Description = $Description;
    $this->CurrencyCode = $CurrencyCode;
    $this->MonetaryValue = $MonetaryValue;
    $this->SubType = $SubType;
  }

  /**
   * 
   * @return string
   */
  public function getCode()
  {
    return $this->Code;
  }

  /**
   * 
   * @param string $Code
   */
  public function setCode($Code)
  {
    $this->Code = $Code;
  }

  /**
   * 
   * @return string
   */
  public function getDescription()
  {
    return $this->Description;
  }

  /**
   * 
   * @param string $Description
   */
  public function setDescription($Description)
  {
    $this->Description = $Description;
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

  /**
   * 
   * @return string
   */
  public function getSubType()
  {
    return $this->SubType;
  }

  /**
   * 
   * @param string $SubType
   */
  public function setSubType($SubType)
  {
    $this->SubType = $SubType;
  }

}
