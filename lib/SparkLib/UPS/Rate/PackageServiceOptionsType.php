<?php

namespace SparkLib\UPS\Rate;

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
   * @var CODType $COD
   * @access public
   */
  public $COD = null;

  /**
   * 
   * @var InsuredValueType $DeclaredValue
   * @access public
   */
  public $DeclaredValue = null;

  /**
   * 
   * @var ShipperDeclaredValueType $ShipperDeclaredValue
   * @access public
   */
  public $ShipperDeclaredValue = null;

  /**
   * 
   * @var string $ProactiveIndicator
   * @access public
   */
  public $ProactiveIndicator = null;

  /**
   * 
   * @var InsuranceType $Insurance
   * @access public
   */
  public $Insurance = null;

  /**
   * 
   * @var string $VerbalConfirmationIndicator
   * @access public
   */
  public $VerbalConfirmationIndicator = null;

  /**
   * 
   * @var string $UPSPremiumCareIndicator
   * @access public
   */
  public $UPSPremiumCareIndicator = null;

  /**
   * 
   * @var DryIceType $DryIce
   * @access public
   */
  public $DryIce = null;

  /**
   * 
   * @param DeliveryConfirmationType $DeliveryConfirmation
   * @param CODType $COD
   * @param InsuredValueType $DeclaredValue
   * @param ShipperDeclaredValueType $ShipperDeclaredValue
   * @param string $ProactiveIndicator
   * @param InsuranceType $Insurance
   * @param string $VerbalConfirmationIndicator
   * @param string $UPSPremiumCareIndicator
   * @param DryIceType $DryIce
   * @access public
   */
  public function __construct($DeliveryConfirmation = null, $COD = null, $DeclaredValue = null, $ShipperDeclaredValue = null, $ProactiveIndicator = null, $Insurance = null, $VerbalConfirmationIndicator = null, $UPSPremiumCareIndicator = null, $DryIce = null)
  {
    $this->DeliveryConfirmation = $DeliveryConfirmation;
    $this->COD = $COD;
    $this->DeclaredValue = $DeclaredValue;
    $this->ShipperDeclaredValue = $ShipperDeclaredValue;
    $this->ProactiveIndicator = $ProactiveIndicator;
    $this->Insurance = $Insurance;
    $this->VerbalConfirmationIndicator = $VerbalConfirmationIndicator;
    $this->UPSPremiumCareIndicator = $UPSPremiumCareIndicator;
    $this->DryIce = $DryIce;
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
   * @return InsuredValueType
   */
  public function getDeclaredValue()
  {
    return $this->DeclaredValue;
  }

  /**
   * 
   * @param InsuredValueType $DeclaredValue
   */
  public function setDeclaredValue($DeclaredValue)
  {
    $this->DeclaredValue = $DeclaredValue;
  }

  /**
   * 
   * @return ShipperDeclaredValueType
   */
  public function getShipperDeclaredValue()
  {
    return $this->ShipperDeclaredValue;
  }

  /**
   * 
   * @param ShipperDeclaredValueType $ShipperDeclaredValue
   */
  public function setShipperDeclaredValue($ShipperDeclaredValue)
  {
    $this->ShipperDeclaredValue = $ShipperDeclaredValue;
  }

  /**
   * 
   * @return string
   */
  public function getProactiveIndicator()
  {
    return $this->ProactiveIndicator;
  }

  /**
   * 
   * @param string $ProactiveIndicator
   */
  public function setProactiveIndicator($ProactiveIndicator)
  {
    $this->ProactiveIndicator = $ProactiveIndicator;
  }

  /**
   * 
   * @return InsuranceType
   */
  public function getInsurance()
  {
    return $this->Insurance;
  }

  /**
   * 
   * @param InsuranceType $Insurance
   */
  public function setInsurance($Insurance)
  {
    $this->Insurance = $Insurance;
  }

  /**
   * 
   * @return string
   */
  public function getVerbalConfirmationIndicator()
  {
    return $this->VerbalConfirmationIndicator;
  }

  /**
   * 
   * @param string $VerbalConfirmationIndicator
   */
  public function setVerbalConfirmationIndicator($VerbalConfirmationIndicator)
  {
    $this->VerbalConfirmationIndicator = $VerbalConfirmationIndicator;
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

}
