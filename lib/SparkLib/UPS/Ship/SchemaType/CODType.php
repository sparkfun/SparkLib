<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class CODType
{

  /**
   *
   * @var string $CODFundsCode
   * @access public
   */
  public $CODFundsCode = null;

  /**
   *
   * @var CurrencyMonetaryType $CODAmount
   * @access public
   */
  public $CODAmount = null;

  /**
   *
   * @param string $CODFundsCode
   * @param CurrencyMonetaryType $CODAmount
   * @access public
   */
  public function __construct($CODFundsCode = null, $CODAmount = null)
  {
    $this->CODFundsCode = $CODFundsCode;
    $this->CODAmount = $CODAmount;
  }

  /**
   *
   * @return string
   */
  public function getCODFundsCode()
  {
    return $this->CODFundsCode;
  }

  /**
   *
   * @param string $CODFundsCode
   */
  public function setCODFundsCode($CODFundsCode)
  {
    $this->CODFundsCode = $CODFundsCode;
  }

  /**
   *
   * @return CurrencyMonetaryType
   */
  public function getCODAmount()
  {
    return $this->CODAmount;
  }

  /**
   *
   * @param CurrencyMonetaryType $CODAmount
   */
  public function setCODAmount($CODAmount)
  {
    $this->CODAmount = $CODAmount;
  }

}
