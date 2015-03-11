<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ShipmentChargeType
{

  /**
   *
   * @var string $Type
   * @access public
   */
  public $Type = null;

  /**
   *
   * @var BillShipperType $BillShipper
   * @access public
   */
  public $BillShipper = null;

  /**
   *
   * @var BillReceiverType $BillReceiver
   * @access public
   */
  public $BillReceiver = null;

  /**
   *
   * @var BillThirdPartyChargeType $BillThirdParty
   * @access public
   */
  public $BillThirdParty = null;

  /**
   *
   * @var string $ConsigneeBilledIndicator
   * @access public
   */
  public $ConsigneeBilledIndicator = null;

  /**
   *
   * @param string $Type
   * @param BillShipperType $BillShipper
   * @param BillReceiverType $BillReceiver
   * @param BillThirdPartyChargeType $BillThirdParty
   * @param string $ConsigneeBilledIndicator
   * @access public
   */
  public function __construct($Type = null, $BillShipper = null, $BillReceiver = null, $BillThirdParty = null, $ConsigneeBilledIndicator = null)
  {
    $this->Type = $Type;
    $this->BillShipper = $BillShipper;
    $this->BillReceiver = $BillReceiver;
    $this->BillThirdParty = $BillThirdParty;
    $this->ConsigneeBilledIndicator = $ConsigneeBilledIndicator;
  }

  /**
   *
   * @return string
   */
  public function getType()
  {
    return $this->Type;
  }

  /**
   *
   * @param string $Type
   */
  public function setType($Type)
  {
    $this->Type = $Type;
  }

  /**
   *
   * @return BillShipperType
   */
  public function getBillShipper()
  {
    return $this->BillShipper;
  }

  /**
   *
   * @param BillShipperType $BillShipper
   */
  public function setBillShipper($BillShipper)
  {
    $this->BillShipper = $BillShipper;
  }

  /**
   *
   * @return BillReceiverType
   */
  public function getBillReceiver()
  {
    return $this->BillReceiver;
  }

  /**
   *
   * @param BillReceiverType $BillReceiver
   */
  public function setBillReceiver($BillReceiver)
  {
    $this->BillReceiver = $BillReceiver;
  }

  /**
   *
   * @return BillThirdPartyChargeType
   */
  public function getBillThirdParty()
  {
    return $this->BillThirdParty;
  }

  /**
   *
   * @param BillThirdPartyChargeType $BillThirdParty
   */
  public function setBillThirdParty($BillThirdParty)
  {
    $this->BillThirdParty = $BillThirdParty;
  }

  /**
   *
   * @return string
   */
  public function getConsigneeBilledIndicator()
  {
    return $this->ConsigneeBilledIndicator;
  }

  /**
   *
   * @param string $ConsigneeBilledIndicator
   */
  public function setConsigneeBilledIndicator($ConsigneeBilledIndicator)
  {
    $this->ConsigneeBilledIndicator = $ConsigneeBilledIndicator;
  }

}
