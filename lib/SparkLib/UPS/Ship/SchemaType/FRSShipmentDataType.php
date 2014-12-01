<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class FRSShipmentDataType
{

  /**
   *
   * @var TransportationChargeType $TransportationCharges
   * @access public
   */
  public $TransportationCharges = null;

  /**
   *
   * @param TransportationChargeType $TransportationCharges
   * @access public
   */
  public function __construct($TransportationCharges = null)
  {
    $this->TransportationCharges = $TransportationCharges;
  }

  /**
   *
   * @return TransportationChargeType
   */
  public function getTransportationCharges()
  {
    return $this->TransportationCharges;
  }

  /**
   *
   * @param TransportationChargeType $TransportationCharges
   */
  public function setTransportationCharges($TransportationCharges)
  {
    $this->TransportationCharges = $TransportationCharges;
  }

}
