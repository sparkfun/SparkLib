<?php

namespace SparkLib\UPS\Rate;

class TransportationChargesType
{

  /**
   * 
   * @var ChargesType $GrossCharge
   * @access public
   */
  public $GrossCharge = null;

  /**
   * 
   * @var ChargesType $DiscountAmount
   * @access public
   */
  public $DiscountAmount = null;

  /**
   * 
   * @var string $DiscountPercentage
   * @access public
   */
  public $DiscountPercentage = null;

  /**
   * 
   * @var ChargesType $NetCharge
   * @access public
   */
  public $NetCharge = null;

  /**
   * 
   * @param ChargesType $GrossCharge
   * @param ChargesType $DiscountAmount
   * @param string $DiscountPercentage
   * @param ChargesType $NetCharge
   * @access public
   */
  public function __construct($GrossCharge = null, $DiscountAmount = null, $DiscountPercentage = null, $NetCharge = null)
  {
    $this->GrossCharge = $GrossCharge;
    $this->DiscountAmount = $DiscountAmount;
    $this->DiscountPercentage = $DiscountPercentage;
    $this->NetCharge = $NetCharge;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getGrossCharge()
  {
    return $this->GrossCharge;
  }

  /**
   * 
   * @param ChargesType $GrossCharge
   */
  public function setGrossCharge($GrossCharge)
  {
    $this->GrossCharge = $GrossCharge;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getDiscountAmount()
  {
    return $this->DiscountAmount;
  }

  /**
   * 
   * @param ChargesType $DiscountAmount
   */
  public function setDiscountAmount($DiscountAmount)
  {
    $this->DiscountAmount = $DiscountAmount;
  }

  /**
   * 
   * @return string
   */
  public function getDiscountPercentage()
  {
    return $this->DiscountPercentage;
  }

  /**
   * 
   * @param string $DiscountPercentage
   */
  public function setDiscountPercentage($DiscountPercentage)
  {
    $this->DiscountPercentage = $DiscountPercentage;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getNetCharge()
  {
    return $this->NetCharge;
  }

  /**
   * 
   * @param ChargesType $NetCharge
   */
  public function setNetCharge($NetCharge)
  {
    $this->NetCharge = $NetCharge;
  }

}
