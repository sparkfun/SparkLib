<?php

namespace SparkLib\UPS\Rate;

class NMFCCommodityType
{

  /**
   * 
   * @var string $PrimeCode
   * @access public
   */
  public $PrimeCode = null;

  /**
   * 
   * @var string $SubCode
   * @access public
   */
  public $SubCode = null;

  /**
   * 
   * @param string $PrimeCode
   * @param string $SubCode
   * @access public
   */
  public function __construct($PrimeCode = null, $SubCode = null)
  {
    $this->PrimeCode = $PrimeCode;
    $this->SubCode = $SubCode;
  }

  /**
   * 
   * @return string
   */
  public function getPrimeCode()
  {
    return $this->PrimeCode;
  }

  /**
   * 
   * @param string $PrimeCode
   */
  public function setPrimeCode($PrimeCode)
  {
    $this->PrimeCode = $PrimeCode;
  }

  /**
   * 
   * @return string
   */
  public function getSubCode()
  {
    return $this->SubCode;
  }

  /**
   * 
   * @param string $SubCode
   */
  public function setSubCode($SubCode)
  {
    $this->SubCode = $SubCode;
  }

}
