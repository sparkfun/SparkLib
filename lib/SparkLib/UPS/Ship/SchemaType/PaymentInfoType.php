<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class PaymentInfoType
{

  /**
   *
   * @var ShipmentChargeType $ShipmentCharge
   * @access public
   */
  public $ShipmentCharge = null;

  /**
   *
   * @var string $SplitDutyVATIndicator
   * @access public
   */
  public $SplitDutyVATIndicator = null;

  /**
   *
   * @param ShipmentChargeType $ShipmentCharge
   * @param string $SplitDutyVATIndicator
   * @access public
   */
  public function __construct($ShipmentCharge = null, $SplitDutyVATIndicator = null)
  {
    $this->ShipmentCharge = $ShipmentCharge;
    $this->SplitDutyVATIndicator = $SplitDutyVATIndicator;
  }

  /**
   *
   * @return ShipmentChargeType
   */
  public function getShipmentCharge()
  {
    return $this->ShipmentCharge;
  }

  /**
   *
   * @param ShipmentChargeType $ShipmentCharge
   */
  public function setShipmentCharge($ShipmentCharge)
  {
    $this->ShipmentCharge = $ShipmentCharge;
  }

  /**
   *
   * @return string
   */
  public function getSplitDutyVATIndicator()
  {
    return $this->SplitDutyVATIndicator;
  }

  /**
   *
   * @param string $SplitDutyVATIndicator
   */
  public function setSplitDutyVATIndicator($SplitDutyVATIndicator)
  {
    $this->SplitDutyVATIndicator = $SplitDutyVATIndicator;
  }

}
