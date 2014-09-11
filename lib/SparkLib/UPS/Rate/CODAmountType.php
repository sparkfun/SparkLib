<?php

namespace SparkLib\UPS\Rate;

class CODAmountType
{

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
   * @param string $CurrencyCode
   * @param string $MonetaryValue
   * @access public
   */
  public function __construct($CurrencyCode = null, $MonetaryValue = null)
  {
    $this->CurrencyCode = $CurrencyCode;
    $this->MonetaryValue = $MonetaryValue;
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
