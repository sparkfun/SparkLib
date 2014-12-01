<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ShipConfirmRequest
{

  /**
   *
   * @var RequestType $Request
   * @access public
   */
  public $Request = null;

  /**
   *
   * @var ShipmentType $Shipment
   * @access public
   */
  public $Shipment = null;

  /**
   *
   * @var LabelSpecificationType $LabelSpecification
   * @access public
   */
  public $LabelSpecification = null;

  /**
   *
   * @var ReceiptSpecificationType $ReceiptSpecification
   * @access public
   */
  public $ReceiptSpecification = null;

  /**
   *
   * @param RequestType $Request
   * @param ShipmentType $Shipment
   * @param LabelSpecificationType $LabelSpecification
   * @param ReceiptSpecificationType $ReceiptSpecification
   * @access public
   */
  public function __construct($Request = null, $Shipment = null, $LabelSpecification = null, $ReceiptSpecification = null)
  {
    $this->Request = $Request;
    $this->Shipment = $Shipment;
    $this->LabelSpecification = $LabelSpecification;
    $this->ReceiptSpecification = $ReceiptSpecification;
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

  /**
   *
   * @return LabelSpecificationType
   */
  public function getLabelSpecification()
  {
    return $this->LabelSpecification;
  }

  /**
   *
   * @param LabelSpecificationType $LabelSpecification
   */
  public function setLabelSpecification($LabelSpecification)
  {
    $this->LabelSpecification = $LabelSpecification;
  }

  /**
   *
   * @return ReceiptSpecificationType
   */
  public function getReceiptSpecification()
  {
    return $this->ReceiptSpecification;
  }

  /**
   *
   * @param ReceiptSpecificationType $ReceiptSpecification
   */
  public function setReceiptSpecification($ReceiptSpecification)
  {
    $this->ReceiptSpecification = $ReceiptSpecification;
  }

}
