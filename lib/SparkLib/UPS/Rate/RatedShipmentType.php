<?php

namespace SparkLib\UPS\Rate;

class RatedShipmentType
{

  /**
   * 
   * @var CodeDescriptionType $Service
   * @access public
   */
  public $Service = null;

  /**
   * 
   * @var string $RateChart
   * @access public
   */
  public $RateChart = null;

  /**
   * 
   * @var RatedShipmentInfoType $RatedShipmentAlert
   * @access public
   */
  public $RatedShipmentAlert = null;

  /**
   * 
   * @var BillingWeightType $BillingWeight
   * @access public
   */
  public $BillingWeight = null;

  /**
   * 
   * @var ChargesType $TransportationCharges
   * @access public
   */
  public $TransportationCharges = null;

  /**
   * 
   * @var ChargesType $AccessorialCharges
   * @access public
   */
  public $AccessorialCharges = null;

  /**
   * 
   * @var ChargesType $SurCharges
   * @access public
   */
  public $SurCharges = null;

  /**
   * 
   * @var FRSShipmentType $FRSShipmentData
   * @access public
   */
  public $FRSShipmentData = null;

  /**
   * 
   * @var ChargesType $ServiceOptionsCharges
   * @access public
   */
  public $ServiceOptionsCharges = null;

  /**
   * 
   * @var ChargesType $TotalCharges
   * @access public
   */
  public $TotalCharges = null;

  /**
   * 
   * @var TotalChargeType $NegotiatedRateCharges
   * @access public
   */
  public $NegotiatedRateCharges = null;

  /**
   * 
   * @var GuaranteedDeliveryType $GuaranteedDelivery
   * @access public
   */
  public $GuaranteedDelivery = null;

  /**
   * 
   * @var RatedPackageType $RatedPackage
   * @access public
   */
  public $RatedPackage = null;

  /**
   * 
   * @param CodeDescriptionType $Service
   * @param string $RateChart
   * @param RatedShipmentInfoType $RatedShipmentAlert
   * @param BillingWeightType $BillingWeight
   * @param ChargesType $TransportationCharges
   * @param ChargesType $AccessorialCharges
   * @param ChargesType $SurCharges
   * @param FRSShipmentType $FRSShipmentData
   * @param ChargesType $ServiceOptionsCharges
   * @param ChargesType $TotalCharges
   * @param TotalChargeType $NegotiatedRateCharges
   * @param GuaranteedDeliveryType $GuaranteedDelivery
   * @param RatedPackageType $RatedPackage
   * @access public
   */
  public function __construct($Service = null, $RateChart = null, $RatedShipmentAlert = null, $BillingWeight = null, $TransportationCharges = null, $AccessorialCharges = null, $SurCharges = null, $FRSShipmentData = null, $ServiceOptionsCharges = null, $TotalCharges = null, $NegotiatedRateCharges = null, $GuaranteedDelivery = null, $RatedPackage = null)
  {
    $this->Service = $Service;
    $this->RateChart = $RateChart;
    $this->RatedShipmentAlert = $RatedShipmentAlert;
    $this->BillingWeight = $BillingWeight;
    $this->TransportationCharges = $TransportationCharges;
    $this->AccessorialCharges = $AccessorialCharges;
    $this->SurCharges = $SurCharges;
    $this->FRSShipmentData = $FRSShipmentData;
    $this->ServiceOptionsCharges = $ServiceOptionsCharges;
    $this->TotalCharges = $TotalCharges;
    $this->NegotiatedRateCharges = $NegotiatedRateCharges;
    $this->GuaranteedDelivery = $GuaranteedDelivery;
    $this->RatedPackage = $RatedPackage;
  }

  /**
   * 
   * @return CodeDescriptionType
   */
  public function getService()
  {
    return $this->Service;
  }

  /**
   * 
   * @param CodeDescriptionType $Service
   */
  public function setService($Service)
  {
    $this->Service = $Service;
  }

  /**
   * 
   * @return string
   */
  public function getRateChart()
  {
    return $this->RateChart;
  }

  /**
   * 
   * @param string $RateChart
   */
  public function setRateChart($RateChart)
  {
    $this->RateChart = $RateChart;
  }

  /**
   * 
   * @return RatedShipmentInfoType
   */
  public function getRatedShipmentAlert()
  {
    return $this->RatedShipmentAlert;
  }

  /**
   * 
   * @param RatedShipmentInfoType $RatedShipmentAlert
   */
  public function setRatedShipmentAlert($RatedShipmentAlert)
  {
    $this->RatedShipmentAlert = $RatedShipmentAlert;
  }

  /**
   * 
   * @return BillingWeightType
   */
  public function getBillingWeight()
  {
    return $this->BillingWeight;
  }

  /**
   * 
   * @param BillingWeightType $BillingWeight
   */
  public function setBillingWeight($BillingWeight)
  {
    $this->BillingWeight = $BillingWeight;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getTransportationCharges()
  {
    return $this->TransportationCharges;
  }

  /**
   * 
   * @param ChargesType $TransportationCharges
   */
  public function setTransportationCharges($TransportationCharges)
  {
    $this->TransportationCharges = $TransportationCharges;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getAccessorialCharges()
  {
    return $this->AccessorialCharges;
  }

  /**
   * 
   * @param ChargesType $AccessorialCharges
   */
  public function setAccessorialCharges($AccessorialCharges)
  {
    $this->AccessorialCharges = $AccessorialCharges;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getSurCharges()
  {
    return $this->SurCharges;
  }

  /**
   * 
   * @param ChargesType $SurCharges
   */
  public function setSurCharges($SurCharges)
  {
    $this->SurCharges = $SurCharges;
  }

  /**
   * 
   * @return FRSShipmentType
   */
  public function getFRSShipmentData()
  {
    return $this->FRSShipmentData;
  }

  /**
   * 
   * @param FRSShipmentType $FRSShipmentData
   */
  public function setFRSShipmentData($FRSShipmentData)
  {
    $this->FRSShipmentData = $FRSShipmentData;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getServiceOptionsCharges()
  {
    return $this->ServiceOptionsCharges;
  }

  /**
   * 
   * @param ChargesType $ServiceOptionsCharges
   */
  public function setServiceOptionsCharges($ServiceOptionsCharges)
  {
    $this->ServiceOptionsCharges = $ServiceOptionsCharges;
  }

  /**
   * 
   * @return ChargesType
   */
  public function getTotalCharges()
  {
    return $this->TotalCharges;
  }

  /**
   * 
   * @param ChargesType $TotalCharges
   */
  public function setTotalCharges($TotalCharges)
  {
    $this->TotalCharges = $TotalCharges;
  }

  /**
   * 
   * @return TotalChargeType
   */
  public function getNegotiatedRateCharges()
  {
    return $this->NegotiatedRateCharges;
  }

  /**
   * 
   * @param TotalChargeType $NegotiatedRateCharges
   */
  public function setNegotiatedRateCharges($NegotiatedRateCharges)
  {
    $this->NegotiatedRateCharges = $NegotiatedRateCharges;
  }

  /**
   * 
   * @return GuaranteedDeliveryType
   */
  public function getGuaranteedDelivery()
  {
    return $this->GuaranteedDelivery;
  }

  /**
   * 
   * @param GuaranteedDeliveryType $GuaranteedDelivery
   */
  public function setGuaranteedDelivery($GuaranteedDelivery)
  {
    $this->GuaranteedDelivery = $GuaranteedDelivery;
  }

  /**
   * 
   * @return RatedPackageType
   */
  public function getRatedPackage()
  {
    return $this->RatedPackage;
  }

  /**
   * 
   * @param RatedPackageType $RatedPackage
   */
  public function setRatedPackage($RatedPackage)
  {
    $this->RatedPackage = $RatedPackage;
  }

}
