<?php

namespace SparkLib\UPS\Ship;

class CN22ContentType
{

  /**
   * 
   * @var string $CN22ContentQuantity
   * @access public
   */
  public $CN22ContentQuantity = null;

  /**
   * 
   * @var string $CN22ContentDescription
   * @access public
   */
  public $CN22ContentDescription = null;

  /**
   * 
   * @var ProductWeightType $CN22ContentWeight
   * @access public
   */
  public $CN22ContentWeight = null;

  /**
   * 
   * @var string $CN22ContentTotalValue
   * @access public
   */
  public $CN22ContentTotalValue = null;

  /**
   * 
   * @var string $CN22ContentCurrencyCode
   * @access public
   */
  public $CN22ContentCurrencyCode = null;

  /**
   * 
   * @var string $CN22ContentCountryOfOrigin
   * @access public
   */
  public $CN22ContentCountryOfOrigin = null;

  /**
   * 
   * @var string $CN22ContentTariffNumber
   * @access public
   */
  public $CN22ContentTariffNumber = null;

  /**
   * 
   * @param string $CN22ContentQuantity
   * @param string $CN22ContentDescription
   * @param ProductWeightType $CN22ContentWeight
   * @param string $CN22ContentTotalValue
   * @param string $CN22ContentCurrencyCode
   * @param string $CN22ContentCountryOfOrigin
   * @param string $CN22ContentTariffNumber
   * @access public
   */
  public function __construct($CN22ContentQuantity = null, $CN22ContentDescription = null, $CN22ContentWeight = null, $CN22ContentTotalValue = null, $CN22ContentCurrencyCode = null, $CN22ContentCountryOfOrigin = null, $CN22ContentTariffNumber = null)
  {
    $this->CN22ContentQuantity = $CN22ContentQuantity;
    $this->CN22ContentDescription = $CN22ContentDescription;
    $this->CN22ContentWeight = $CN22ContentWeight;
    $this->CN22ContentTotalValue = $CN22ContentTotalValue;
    $this->CN22ContentCurrencyCode = $CN22ContentCurrencyCode;
    $this->CN22ContentCountryOfOrigin = $CN22ContentCountryOfOrigin;
    $this->CN22ContentTariffNumber = $CN22ContentTariffNumber;
  }

  /**
   * 
   * @return string
   */
  public function getCN22ContentQuantity()
  {
    return $this->CN22ContentQuantity;
  }

  /**
   * 
   * @param string $CN22ContentQuantity
   */
  public function setCN22ContentQuantity($CN22ContentQuantity)
  {
    $this->CN22ContentQuantity = $CN22ContentQuantity;
  }

  /**
   * 
   * @return string
   */
  public function getCN22ContentDescription()
  {
    return $this->CN22ContentDescription;
  }

  /**
   * 
   * @param string $CN22ContentDescription
   */
  public function setCN22ContentDescription($CN22ContentDescription)
  {
    $this->CN22ContentDescription = $CN22ContentDescription;
  }

  /**
   * 
   * @return ProductWeightType
   */
  public function getCN22ContentWeight()
  {
    return $this->CN22ContentWeight;
  }

  /**
   * 
   * @param ProductWeightType $CN22ContentWeight
   */
  public function setCN22ContentWeight($CN22ContentWeight)
  {
    $this->CN22ContentWeight = $CN22ContentWeight;
  }

  /**
   * 
   * @return string
   */
  public function getCN22ContentTotalValue()
  {
    return $this->CN22ContentTotalValue;
  }

  /**
   * 
   * @param string $CN22ContentTotalValue
   */
  public function setCN22ContentTotalValue($CN22ContentTotalValue)
  {
    $this->CN22ContentTotalValue = $CN22ContentTotalValue;
  }

  /**
   * 
   * @return string
   */
  public function getCN22ContentCurrencyCode()
  {
    return $this->CN22ContentCurrencyCode;
  }

  /**
   * 
   * @param string $CN22ContentCurrencyCode
   */
  public function setCN22ContentCurrencyCode($CN22ContentCurrencyCode)
  {
    $this->CN22ContentCurrencyCode = $CN22ContentCurrencyCode;
  }

  /**
   * 
   * @return string
   */
  public function getCN22ContentCountryOfOrigin()
  {
    return $this->CN22ContentCountryOfOrigin;
  }

  /**
   * 
   * @param string $CN22ContentCountryOfOrigin
   */
  public function setCN22ContentCountryOfOrigin($CN22ContentCountryOfOrigin)
  {
    $this->CN22ContentCountryOfOrigin = $CN22ContentCountryOfOrigin;
  }

  /**
   * 
   * @return string
   */
  public function getCN22ContentTariffNumber()
  {
    return $this->CN22ContentTariffNumber;
  }

  /**
   * 
   * @param string $CN22ContentTariffNumber
   */
  public function setCN22ContentTariffNumber($CN22ContentTariffNumber)
  {
    $this->CN22ContentTariffNumber = $CN22ContentTariffNumber;
  }

}
