<?php

namespace SparkLib\UPS\Rate;

class ShipmentRatingOptionsType
{

  /**
   * 
   * @var string $NegotiatedRatesIndicator
   * @access public
   */
  public $NegotiatedRatesIndicator = null;

  /**
   * 
   * @var string $FRSShipmentIndicator
   * @access public
   */
  public $FRSShipmentIndicator = null;

  /**
   * 
   * @var string $RateChartIndicator
   * @access public
   */
  public $RateChartIndicator = null;

  /**
   * 
   * @param string $NegotiatedRatesIndicator
   * @param string $FRSShipmentIndicator
   * @param string $RateChartIndicator
   * @access public
   */
  public function __construct($NegotiatedRatesIndicator = null, $FRSShipmentIndicator = null, $RateChartIndicator = null)
  {
    $this->NegotiatedRatesIndicator = $NegotiatedRatesIndicator;
    $this->FRSShipmentIndicator = $FRSShipmentIndicator;
    $this->RateChartIndicator = $RateChartIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getNegotiatedRatesIndicator()
  {
    return $this->NegotiatedRatesIndicator;
  }

  /**
   * 
   * @param string $NegotiatedRatesIndicator
   */
  public function setNegotiatedRatesIndicator($NegotiatedRatesIndicator)
  {
    $this->NegotiatedRatesIndicator = $NegotiatedRatesIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getFRSShipmentIndicator()
  {
    return $this->FRSShipmentIndicator;
  }

  /**
   * 
   * @param string $FRSShipmentIndicator
   */
  public function setFRSShipmentIndicator($FRSShipmentIndicator)
  {
    $this->FRSShipmentIndicator = $FRSShipmentIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getRateChartIndicator()
  {
    return $this->RateChartIndicator;
  }

  /**
   * 
   * @param string $RateChartIndicator
   */
  public function setRateChartIndicator($RateChartIndicator)
  {
    $this->RateChartIndicator = $RateChartIndicator;
  }

}
