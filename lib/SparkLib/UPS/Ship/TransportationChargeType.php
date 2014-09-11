<?php

namespace SparkLib\UPS\Ship;

class TransportationChargeType
{

  /**
   * 
   * @var ShipChargeType $GrossCharge
   * @access public
   */
  public $GrossCharge = null;

  /**
   * 
   * @var ShipChargeType $DiscountAmount
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
   * @var ShipChargeType $NetCharge
   * @access public
   */
  public $NetCharge = null;

  /**
   * 
   * @param ShipChargeType $GrossCharge
   * @param ShipChargeType $DiscountAmount
   * @param string $DiscountPercentage
   * @param ShipChargeType $NetCharge
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
   * @return ShipChargeType
   */
  public function getGrossCharge()
  {
    return $this->GrossCharge;
  }

  /**
   * 
   * @param ShipChargeType $GrossCharge
   */
  public function setGrossCharge($GrossCharge)
  {
    $this->GrossCharge = $GrossCharge;
  }

  /**
   * 
   * @return ShipChargeType
   */
  public function getDiscountAmount()
  {
    return $this->DiscountAmount;
  }

  /**
   * 
   * @param ShipChargeType $DiscountAmount
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
   * @return ShipChargeType
   */
  public function getNetCharge()
  {
    return $this->NetCharge;
  }

  /**
   * 
   * @param ShipChargeType $NetCharge
   */
  public function setNetCharge($NetCharge)
  {
    $this->NetCharge = $NetCharge;
  }

}
