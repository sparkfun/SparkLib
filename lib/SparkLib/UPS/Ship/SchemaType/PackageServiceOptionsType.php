<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class PackageServiceOptionsType
{

  /**
   *
   * @var DeliveryConfirmationType $DeliveryConfirmation
   * @access public
   */
  public $DeliveryConfirmation = null;

  /**
   *
   * @var PackageDeclaredValueType $DeclaredValue
   * @access public
   */
  public $DeclaredValue = null;

  /**
   *
   * @var PSOCODType $COD
   * @access public
   */
  public $COD = null;

  /**
   *
   * @var VerbalConfirmationType $VerbalConfirmation
   * @access public
   */
  public $VerbalConfirmation = null;

  /**
   *
   * @var string $ShipperReleaseIndicator
   * @access public
   */
  public $ShipperReleaseIndicator = null;

  /**
   *
   * @var PSONotificationType $Notification
   * @access public
   */
  public $Notification = null;

  /**
   *
   * @var DryIceType $DryIce
   * @access public
   */
  public $DryIce = null;

  /**
   *
   * @var string $UPSPremiumCareIndicator
   * @access public
   */
  public $UPSPremiumCareIndicator = null;

  /**
   *
   * @param DeliveryConfirmationType $DeliveryConfirmation
   * @param PackageDeclaredValueType $DeclaredValue
   * @param PSOCODType $COD
   * @param VerbalConfirmationType $VerbalConfirmation
   * @param string $ShipperReleaseIndicator
   * @param PSONotificationType $Notification
   * @param DryIceType $DryIce
   * @param string $UPSPremiumCareIndicator
   * @access public
   */
  public function __construct($DeliveryConfirmation = null, $DeclaredValue = null, $COD = null, $VerbalConfirmation = null, $ShipperReleaseIndicator = null, $Notification = null, $DryIce = null, $UPSPremiumCareIndicator = null)
  {
    $this->DeliveryConfirmation = $DeliveryConfirmation;
    $this->DeclaredValue = $DeclaredValue;
    $this->COD = $COD;
    $this->VerbalConfirmation = $VerbalConfirmation;
    $this->ShipperReleaseIndicator = $ShipperReleaseIndicator;
    $this->Notification = $Notification;
    $this->DryIce = $DryIce;
    $this->UPSPremiumCareIndicator = $UPSPremiumCareIndicator;
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
   * @return PackageDeclaredValueType
   */
  public function getDeclaredValue()
  {
    return $this->DeclaredValue;
  }

  /**
   *
   * @param PackageDeclaredValueType $DeclaredValue
   */
  public function setDeclaredValue($DeclaredValue)
  {
    $this->DeclaredValue = $DeclaredValue;
  }

  /**
   *
   * @return PSOCODType
   */
  public function getCOD()
  {
    return $this->COD;
  }

  /**
   *
   * @param PSOCODType $COD
   */
  public function setCOD($COD)
  {
    $this->COD = $COD;
  }

  /**
   *
   * @return VerbalConfirmationType
   */
  public function getVerbalConfirmation()
  {
    return $this->VerbalConfirmation;
  }

  /**
   *
   * @param VerbalConfirmationType $VerbalConfirmation
   */
  public function setVerbalConfirmation($VerbalConfirmation)
  {
    $this->VerbalConfirmation = $VerbalConfirmation;
  }

  /**
   *
   * @return string
   */
  public function getShipperReleaseIndicator()
  {
    return $this->ShipperReleaseIndicator;
  }

  /**
   *
   * @param string $ShipperReleaseIndicator
   */
  public function setShipperReleaseIndicator($ShipperReleaseIndicator)
  {
    $this->ShipperReleaseIndicator = $ShipperReleaseIndicator;
  }

  /**
   *
   * @return PSONotificationType
   */
  public function getNotification()
  {
    return $this->Notification;
  }

  /**
   *
   * @param PSONotificationType $Notification
   */
  public function setNotification($Notification)
  {
    $this->Notification = $Notification;
  }

  /**
   *
   * @return DryIceType
   */
  public function getDryIce()
  {
    return $this->DryIce;
  }

  /**
   *
   * @param DryIceType $DryIce
   */
  public function setDryIce($DryIce)
  {
    $this->DryIce = $DryIce;
  }

  /**
   *
   * @return string
   */
  public function getUPSPremiumCareIndicator()
  {
    return $this->UPSPremiumCareIndicator;
  }

  /**
   *
   * @param string $UPSPremiumCareIndicator
   */
  public function setUPSPremiumCareIndicator($UPSPremiumCareIndicator)
  {
    $this->UPSPremiumCareIndicator = $UPSPremiumCareIndicator;
  }

}
