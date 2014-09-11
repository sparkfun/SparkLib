<?php

namespace SparkLib\UPS\Rate;

class FRSShipmentType
{

  /**
   * 
   * @var TransportationChargesType $TransportationCharges
   * @access public
   */
  public $TransportationCharges = null;

  /**
   * 
   * @param TransportationChargesType $TransportationCharges
   * @access public
   */
  public function __construct($TransportationCharges = null)
  {
    $this->TransportationCharges = $TransportationCharges;
  }

  /**
   * 
   * @return TransportationChargesType
   */
  public function getTransportationCharges()
  {
    return $this->TransportationCharges;
  }

  /**
   * 
   * @param TransportationChargesType $TransportationCharges
   */
  public function setTransportationCharges($TransportationCharges)
  {
    $this->TransportationCharges = $TransportationCharges;
  }

}
