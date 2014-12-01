<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ShipmentChargesType
{

  /**
   *
   * @var string $RateChart
   * @access public
   */
  public $RateChart = null;

  /**
   *
   * @var ShipChargeType $TransportationCharges
   * @access public
   */
  public $TransportationCharges = null;

  /**
   *
   * @var ShipChargeType $AccessorialCharges
   * @access public
   */
  public $AccessorialCharges = null;

  /**
   *
   * @var ShipChargeType $SurCharges
   * @access public
   */
  public $SurCharges = null;

  /**
   *
   * @var ShipChargeType $ServiceOptionsCharges
   * @access public
   */
  public $ServiceOptionsCharges = null;

  /**
   *
   * @var ShipChargeType $TotalCharges
   * @access public
   */
  public $TotalCharges = null;

  /**
   *
   * @param string $RateChart
   * @param ShipChargeType $TransportationCharges
   * @param ShipChargeType $AccessorialCharges
   * @param ShipChargeType $SurCharges
   * @param ShipChargeType $ServiceOptionsCharges
   * @param ShipChargeType $TotalCharges
   * @access public
   */
  public function __construct($RateChart = null, $TransportationCharges = null, $AccessorialCharges = null, $SurCharges = null, $ServiceOptionsCharges = null, $TotalCharges = null)
  {
    $this->RateChart = $RateChart;
    $this->TransportationCharges = $TransportationCharges;
    $this->AccessorialCharges = $AccessorialCharges;
    $this->SurCharges = $SurCharges;
    $this->ServiceOptionsCharges = $ServiceOptionsCharges;
    $this->TotalCharges = $TotalCharges;
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
   * @return ShipChargeType
   */
  public function getTransportationCharges()
  {
    return $this->TransportationCharges;
  }

  /**
   *
   * @param ShipChargeType $TransportationCharges
   */
  public function setTransportationCharges($TransportationCharges)
  {
    $this->TransportationCharges = $TransportationCharges;
  }

  /**
   *
   * @return ShipChargeType
   */
  public function getAccessorialCharges()
  {
    return $this->AccessorialCharges;
  }

  /**
   *
   * @param ShipChargeType $AccessorialCharges
   */
  public function setAccessorialCharges($AccessorialCharges)
  {
    $this->AccessorialCharges = $AccessorialCharges;
  }

  /**
   *
   * @return ShipChargeType
   */
  public function getSurCharges()
  {
    return $this->SurCharges;
  }

  /**
   *
   * @param ShipChargeType $SurCharges
   */
  public function setSurCharges($SurCharges)
  {
    $this->SurCharges = $SurCharges;
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
   * @return ShipChargeType
   */
  public function getTotalCharges()
  {
    return $this->TotalCharges;
  }

  /**
   *
   * @param ShipChargeType $TotalCharges
   */
  public function setTotalCharges($TotalCharges)
  {
    $this->TotalCharges = $TotalCharges;
  }

}
