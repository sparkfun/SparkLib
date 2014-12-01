<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class PackageResultsType
{

  /**
   *
   * @var string $TrackingNumber
   * @access public
   */
  public $TrackingNumber = null;

  /**
   *
   * @var ShipChargeType $ServiceOptionsCharges
   * @access public
   */
  public $ServiceOptionsCharges = null;

  /**
   *
   * @var LabelType $ShippingLabel
   * @access public
   */
  public $ShippingLabel = null;

  /**
   *
   * @var ReceiptType $ShippingReceipt
   * @access public
   */
  public $ShippingReceipt = null;

  /**
   *
   * @var string $USPSPICNumber
   * @access public
   */
  public $USPSPICNumber = null;

  /**
   *
   * @var string $CN22Number
   * @access public
   */
  public $CN22Number = null;

  /**
   *
   * @var AccessorialType $Accessorial
   * @access public
   */
  public $Accessorial = null;

  /**
   *
   * @var FormType $Form
   * @access public
   */
  public $Form = null;

  /**
   *
   * @param string $TrackingNumber
   * @param ShipChargeType $ServiceOptionsCharges
   * @param LabelType $ShippingLabel
   * @param ReceiptType $ShippingReceipt
   * @param string $USPSPICNumber
   * @param string $CN22Number
   * @param AccessorialType $Accessorial
   * @param FormType $Form
   * @access public
   */
  public function __construct($TrackingNumber = null, $ServiceOptionsCharges = null, $ShippingLabel = null, $ShippingReceipt = null, $USPSPICNumber = null, $CN22Number = null, $Accessorial = null, $Form = null)
  {
    $this->TrackingNumber = $TrackingNumber;
    $this->ServiceOptionsCharges = $ServiceOptionsCharges;
    $this->ShippingLabel = $ShippingLabel;
    $this->ShippingReceipt = $ShippingReceipt;
    $this->USPSPICNumber = $USPSPICNumber;
    $this->CN22Number = $CN22Number;
    $this->Accessorial = $Accessorial;
    $this->Form = $Form;
  }

  /**
   *
   * @return string
   */
  public function getTrackingNumber()
  {
    return $this->TrackingNumber;
  }

  /**
   *
   * @param string $TrackingNumber
   */
  public function setTrackingNumber($TrackingNumber)
  {
    $this->TrackingNumber = $TrackingNumber;
  }

  /**
   *
   * @return ShipChargeType
   */
  public function getServiceOptionsCharges()
  {
    return $this->ServiceOptionsCharges;
  }

  /**
   *
   * @param ShipChargeType $ServiceOptionsCharges
   */
  public function setServiceOptionsCharges($ServiceOptionsCharges)
  {
    $this->ServiceOptionsCharges = $ServiceOptionsCharges;
  }

  /**
   *
   * @return LabelType
   */
  public function getShippingLabel()
  {
    return $this->ShippingLabel;
  }

  /**
   *
   * @param LabelType $ShippingLabel
   */
  public function setShippingLabel($ShippingLabel)
  {
    $this->ShippingLabel = $ShippingLabel;
  }

  /**
   *
   * @return ReceiptType
   */
  public function getShippingReceipt()
  {
    return $this->ShippingReceipt;
  }

  /**
   *
   * @param ReceiptType $ShippingReceipt
   */
  public function setShippingReceipt($ShippingReceipt)
  {
    $this->ShippingReceipt = $ShippingReceipt;
  }

  /**
   *
   * @return string
   */
  public function getUSPSPICNumber()
  {
    return $this->USPSPICNumber;
  }

  /**
   *
   * @param string $USPSPICNumber
   */
  public function setUSPSPICNumber($USPSPICNumber)
  {
    $this->USPSPICNumber = $USPSPICNumber;
  }

  /**
   *
   * @return string
   */
  public function getCN22Number()
  {
    return $this->CN22Number;
  }

  /**
   *
   * @param string $CN22Number
   */
  public function setCN22Number($CN22Number)
  {
    $this->CN22Number = $CN22Number;
  }

  /**
   *
   * @return AccessorialType
   */
  public function getAccessorial()
  {
    return $this->Accessorial;
  }

  /**
   *
   * @param AccessorialType $Accessorial
   */
  public function setAccessorial($Accessorial)
  {
    $this->Accessorial = $Accessorial;
  }

  /**
   *
   * @return FormType
   */
  public function getForm()
  {
    return $this->Form;
  }

  /**
   *
   * @param FormType $Form
   */
  public function setForm($Form)
  {
    $this->Form = $Form;
  }

}
