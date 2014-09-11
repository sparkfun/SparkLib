<?php

namespace SparkLib\UPS\Rate;

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
   * @var CODAmountType $CODAmount
   * @access public
   */
  public $CODAmount = null;

  /**
   * 
   * @param string $CODFundsCode
   * @param CODAmountType $CODAmount
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
   * @return CODAmountType
   */
  public function getCODAmount()
  {
    return $this->CODAmount;
  }

  /**
   * 
   * @param CODAmountType $CODAmount
   */
  public function setCODAmount($CODAmount)
  {
    $this->CODAmount = $CODAmount;
  }

}
