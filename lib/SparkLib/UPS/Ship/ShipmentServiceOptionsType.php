<?php

namespace SparkLib\UPS\Ship;

class ShipmentServiceOptionsType
{

  /**
   * 
   * @var string $SaturdayDeliveryIndicator
   * @access public
   */
  public $SaturdayDeliveryIndicator = null;

  /**
   * 
   * @var CODType $COD
   * @access public
   */
  public $COD = null;

  /**
   * 
   * @var NotificationType $Notification
   * @access public
   */
  public $Notification = null;

  /**
   * 
   * @var LabelDeliveryType $LabelDelivery
   * @access public
   */
  public $LabelDelivery = null;

  /**
   * 
   * @var InternationalFormType $InternationalForms
   * @access public
   */
  public $InternationalForms = null;

  /**
   * 
   * @var DeliveryConfirmationType $DeliveryConfirmation
   * @access public
   */
  public $DeliveryConfirmation = null;

  /**
   * 
   * @var string $ReturnOfDocumentIndicator
   * @access public
   */
  public $ReturnOfDocumentIndicator = null;

  /**
   * 
   * @var string $ImportControlIndicator
   * @access public
   */
  public $ImportControlIndicator = null;

  /**
   * 
   * @var LabelMethodType $LabelMethod
   * @access public
   */
  public $LabelMethod = null;

  /**
   * 
   * @var string $CommercialInvoiceRemovalIndicator
   * @access public
   */
  public $CommercialInvoiceRemovalIndicator = null;

  /**
   * 
   * @var string $UPScarbonneutralIndicator
   * @access public
   */
  public $UPScarbonneutralIndicator = null;

  /**
   * 
   * @var PreAlertNotificationType $PreAlertNotification
   * @access public
   */
  public $PreAlertNotification = null;

  /**
   * 
   * @var string $ExchangeForwardIndicator
   * @access public
   */
  public $ExchangeForwardIndicator = null;

  /**
   * 
   * @var string $HoldForPickupIndicator
   * @access public
   */
  public $HoldForPickupIndicator = null;

  /**
   * 
   * @var string $DropoffAtUPSFacilityIndicator
   * @access public
   */
  public $DropoffAtUPSFacilityIndicator = null;

  /**
   * 
   * @var string $LiftGateForPickUpIndicator
   * @access public
   */
  public $LiftGateForPickUpIndicator = null;

  /**
   * 
   * @var string $LiftGateForDeliveryIndicator
   * @access public
   */
  public $LiftGateForDeliveryIndicator = null;

  /**
   * 
   * @var string $SDLShipmentIndicator
   * @access public
   */
  public $SDLShipmentIndicator = null;

  /**
   * 
   * @param string $SaturdayDeliveryIndicator
   * @param CODType $COD
   * @param NotificationType $Notification
   * @param LabelDeliveryType $LabelDelivery
   * @param InternationalFormType $InternationalForms
   * @param DeliveryConfirmationType $DeliveryConfirmation
   * @param string $ReturnOfDocumentIndicator
   * @param string $ImportControlIndicator
   * @param LabelMethodType $LabelMethod
   * @param string $CommercialInvoiceRemovalIndicator
   * @param string $UPScarbonneutralIndicator
   * @param PreAlertNotificationType $PreAlertNotification
   * @param string $ExchangeForwardIndicator
   * @param string $HoldForPickupIndicator
   * @param string $DropoffAtUPSFacilityIndicator
   * @param string $LiftGateForPickUpIndicator
   * @param string $LiftGateForDeliveryIndicator
   * @param string $SDLShipmentIndicator
   * @access public
   */
  public function __construct($SaturdayDeliveryIndicator = null, $COD = null, $Notification = null, $LabelDelivery = null, $InternationalForms = null, $DeliveryConfirmation = null, $ReturnOfDocumentIndicator = null, $ImportControlIndicator = null, $LabelMethod = null, $CommercialInvoiceRemovalIndicator = null, $UPScarbonneutralIndicator = null, $PreAlertNotification = null, $ExchangeForwardIndicator = null, $HoldForPickupIndicator = null, $DropoffAtUPSFacilityIndicator = null, $LiftGateForPickUpIndicator = null, $LiftGateForDeliveryIndicator = null, $SDLShipmentIndicator = null)
  {
    $this->SaturdayDeliveryIndicator = $SaturdayDeliveryIndicator;
    $this->COD = $COD;
    $this->Notification = $Notification;
    $this->LabelDelivery = $LabelDelivery;
    $this->InternationalForms = $InternationalForms;
    $this->DeliveryConfirmation = $DeliveryConfirmation;
    $this->ReturnOfDocumentIndicator = $ReturnOfDocumentIndicator;
    $this->ImportControlIndicator = $ImportControlIndicator;
    $this->LabelMethod = $LabelMethod;
    $this->CommercialInvoiceRemovalIndicator = $CommercialInvoiceRemovalIndicator;
    $this->UPScarbonneutralIndicator = $UPScarbonneutralIndicator;
    $this->PreAlertNotification = $PreAlertNotification;
    $this->ExchangeForwardIndicator = $ExchangeForwardIndicator;
    $this->HoldForPickupIndicator = $HoldForPickupIndicator;
    $this->DropoffAtUPSFacilityIndicator = $DropoffAtUPSFacilityIndicator;
    $this->LiftGateForPickUpIndicator = $LiftGateForPickUpIndicator;
    $this->LiftGateForDeliveryIndicator = $LiftGateForDeliveryIndicator;
    $this->SDLShipmentIndicator = $SDLShipmentIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getSaturdayDeliveryIndicator()
  {
    return $this->SaturdayDeliveryIndicator;
  }

  /**
   * 
   * @param string $SaturdayDeliveryIndicator
   */
  public function setSaturdayDeliveryIndicator($SaturdayDeliveryIndicator)
  {
    $this->SaturdayDeliveryIndicator = $SaturdayDeliveryIndicator;
  }

  /**
   * 
   * @return CODType
   */
  public function getCOD()
  {
    return $this->COD;
  }

  /**
   * 
   * @param CODType $COD
   */
  public function setCOD($COD)
  {
    $this->COD = $COD;
  }

  /**
   * 
   * @return NotificationType
   */
  public function getNotification()
  {
    return $this->Notification;
  }

  /**
   * 
   * @param NotificationType $Notification
   */
  public function setNotification($Notification)
  {
    $this->Notification = $Notification;
  }

  /**
   * 
   * @return LabelDeliveryType
   */
  public function getLabelDelivery()
  {
    return $this->LabelDelivery;
  }

  /**
   * 
   * @param LabelDeliveryType $LabelDelivery
   */
  public function setLabelDelivery($LabelDelivery)
  {
    $this->LabelDelivery = $LabelDelivery;
  }

  /**
   * 
   * @return InternationalFormType
   */
  public function getInternationalForms()
  {
    return $this->InternationalForms;
  }

  /**
   * 
   * @param InternationalFormType $InternationalForms
   */
  public function setInternationalForms($InternationalForms)
  {
    $this->InternationalForms = $InternationalForms;
  }

  /**
   * 
   * @return DeliveryConfirmationType
   */
  public function getDeliveryConfirmation()
  {
    return $this->DeliveryConfirmation;
  }

  /**
   * 
   * @param DeliveryConfirmationType $DeliveryConfirmation
   */
  public function setDeliveryConfirmation($DeliveryConfirmation)
  {
    $this->DeliveryConfirmation = $DeliveryConfirmation;
  }

  /**
   * 
   * @return string
   */
  public function getReturnOfDocumentIndicator()
  {
    return $this->ReturnOfDocumentIndicator;
  }

  /**
   * 
   * @param string $ReturnOfDocumentIndicator
   */
  public function setReturnOfDocumentIndicator($ReturnOfDocumentIndicator)
  {
    $this->ReturnOfDocumentIndicator = $ReturnOfDocumentIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getImportControlIndicator()
  {
    return $this->ImportControlIndicator;
  }

  /**
   * 
   * @param string $ImportControlIndicator
   */
  public function setImportControlIndicator($ImportControlIndicator)
  {
    $this->ImportControlIndicator = $ImportControlIndicator;
  }

  /**
   * 
   * @return LabelMethodType
   */
  public function getLabelMethod()
  {
    return $this->LabelMethod;
  }

  /**
   * 
   * @param LabelMethodType $LabelMethod
   */
  public function setLabelMethod($LabelMethod)
  {
    $this->LabelMethod = $LabelMethod;
  }

  /**
   * 
   * @return string
   */
  public function getCommercialInvoiceRemovalIndicator()
  {
    return $this->CommercialInvoiceRemovalIndicator;
  }

  /**
   * 
   * @param string $CommercialInvoiceRemovalIndicator
   */
  public function setCommercialInvoiceRemovalIndicator($CommercialInvoiceRemovalIndicator)
  {
    $this->CommercialInvoiceRemovalIndicator = $CommercialInvoiceRemovalIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getUPScarbonneutralIndicator()
  {
    return $this->UPScarbonneutralIndicator;
  }

  /**
   * 
   * @param string $UPScarbonneutralIndicator
   */
  public function setUPScarbonneutralIndicator($UPScarbonneutralIndicator)
  {
    $this->UPScarbonneutralIndicator = $UPScarbonneutralIndicator;
  }

  /**
   * 
   * @return PreAlertNotificationType
   */
  public function getPreAlertNotification()
  {
    return $this->PreAlertNotification;
  }

  /**
   * 
   * @param PreAlertNotificationType $PreAlertNotification
   */
  public function setPreAlertNotification($PreAlertNotification)
  {
    $this->PreAlertNotification = $PreAlertNotification;
  }

  /**
   * 
   * @return string
   */
  public function getExchangeForwardIndicator()
  {
    return $this->ExchangeForwardIndicator;
  }

  /**
   * 
   * @param string $ExchangeForwardIndicator
   */
  public function setExchangeForwardIndicator($ExchangeForwardIndicator)
  {
    $this->ExchangeForwardIndicator = $ExchangeForwardIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getHoldForPickupIndicator()
  {
    return $this->HoldForPickupIndicator;
  }

  /**
   * 
   * @param string $HoldForPickupIndicator
   */
  public function setHoldForPickupIndicator($HoldForPickupIndicator)
  {
    $this->HoldForPickupIndicator = $HoldForPickupIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getDropoffAtUPSFacilityIndicator()
  {
    return $this->DropoffAtUPSFacilityIndicator;
  }

  /**
   * 
   * @param string $DropoffAtUPSFacilityIndicator
   */
  public function setDropoffAtUPSFacilityIndicator($DropoffAtUPSFacilityIndicator)
  {
    $this->DropoffAtUPSFacilityIndicator = $DropoffAtUPSFacilityIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getLiftGateForPickUpIndicator()
  {
    return $this->LiftGateForPickUpIndicator;
  }

  /**
   * 
   * @param string $LiftGateForPickUpIndicator
   */
  public function setLiftGateForPickUpIndicator($LiftGateForPickUpIndicator)
  {
    $this->LiftGateForPickUpIndicator = $LiftGateForPickUpIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getLiftGateForDeliveryIndicator()
  {
    return $this->LiftGateForDeliveryIndicator;
  }

  /**
   * 
   * @param string $LiftGateForDeliveryIndicator
   */
  public function setLiftGateForDeliveryIndicator($LiftGateForDeliveryIndicator)
  {
    $this->LiftGateForDeliveryIndicator = $LiftGateForDeliveryIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getSDLShipmentIndicator()
  {
    return $this->SDLShipmentIndicator;
  }

  /**
   * 
   * @param string $SDLShipmentIndicator
   */
  public function setSDLShipmentIndicator($SDLShipmentIndicator)
  {
    $this->SDLShipmentIndicator = $SDLShipmentIndicator;
  }

}
