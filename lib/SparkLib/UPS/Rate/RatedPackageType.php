<?php

namespace SparkLib\UPS\Rate;

class RatedPackageType
{

  /**
   * 
   * @var ChargesType $TransportationCharges
   * @access public
   */
  public $TransportationCharges = null;

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
   * @var string $Weight
   * @access public
   */
  public $Weight = null;

  /**
   * 
   * @var BillingWeightType $BillingWeight
   * @access public
   */
  public $BillingWeight = null;

  /**
   * 
   * @var AccessorialType $Accessorial
   * @access public
   */
  public $Accessorial = null;

  /**
   * 
   * @param ChargesType $TransportationCharges
   * @param ChargesType $ServiceOptionsCharges
   * @param ChargesType $TotalCharges
   * @param string $Weight
   * @param BillingWeightType $BillingWeight
   * @param AccessorialType $Accessorial
   * @access public
   */
  public function __construct($TransportationCharges = null, $ServiceOptionsCharges = null, $TotalCharges = null, $Weight = null, $BillingWeight = null, $Accessorial = null)
  {
    $this->TransportationCharges = $TransportationCharges;
    $this->ServiceOptionsCharges = $ServiceOptionsCharges;
    $this->TotalCharges = $TotalCharges;
    $this->Weight = $Weight;
    $this->BillingWeight = $BillingWeight;
    $this->Accessorial = $Accessorial;
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
   * @return string
   */
  public function getWeight()
  {
    return $this->Weight;
  }

  /**
   * 
   * @param string $Weight
   */
  public function setWeight($Weight)
  {
    $this->Weight = $Weight;
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

}
