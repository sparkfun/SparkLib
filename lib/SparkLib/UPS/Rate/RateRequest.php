<?php

namespace SparkLib\UPS\Rate;

class RateRequest
{

  /**
   *
   * @var RequestType $Request
   * @access public
   */
  public $Request = null;

  /**
   *
   * @var CodeDescriptionType $PickupType
   * @access public
   */
  public $PickupType = null;

  /**
   *
   * @var CodeDescriptionType $CustomerClassification
   * @access public
   */
  public $CustomerClassification = null;

  /**
   *
   * @var ShipmentType $Shipment
   * @access public
   */
  public $Shipment = null;

  /**
   *
   * @param RequestType $Request
   * @param CodeDescriptionType $PickupType
   * @param CodeDescriptionType $CustomerClassification
   * @param ShipmentType $Shipment
   * @access public
   */
  public function __construct($Request = null, $PickupType = null, $CustomerClassification = null, $Shipment = null)
  {
    $this->Request = $Request;
    $this->PickupType = $PickupType;
    $this->CustomerClassification = $CustomerClassification;
    $this->Shipment = $Shipment;
  }

  /**
   *
   * @return RequestType
   */
  public function getRequest()
  {
    return $this->Request;
  }

  /**
   *
   * @param RequestType $Request
   */
  public function setRequest($Request)
  {
    $this->Request = $Request;
  }

  /**
   *
   * @return CodeDescriptionType
   */
  public function getPickupType()
  {
    return $this->PickupType;
  }

  /**
   *
   * @param CodeDescriptionType $PickupType
   */
  public function setPickupType($PickupType)
  {
    $this->PickupType = $PickupType;
  }

  /**
   *
   * @return CodeDescriptionType
   */
  public function getCustomerClassification()
  {
    return $this->CustomerClassification;
  }

  /**
   *
   * @param CodeDescriptionType $CustomerClassification
   */
  public function setCustomerClassification($CustomerClassification)
  {
    $this->CustomerClassification = $CustomerClassification;
  }

  /**
   *
   * @return ShipmentType
   */
  public function getShipment()
  {
    return $this->Shipment;
  }

  /**
   *
   * @param ShipmentType $Shipment
   */
  public function setShipment($Shipment)
  {
    $this->Shipment = $Shipment;
  }

}
