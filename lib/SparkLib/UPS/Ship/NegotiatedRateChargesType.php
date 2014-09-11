<?php

namespace SparkLib\UPS\Ship;

class NegotiatedRateChargesType
{

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
   * @var ShipChargeType $TransportationCharges
   * @access public
   */
  public $TransportationCharges = null;

  /**
   * 
   * @var ShipChargeType $TotalCharge
   * @access public
   */
  public $TotalCharge = null;

  /**
   * 
   * @param ShipChargeType $AccessorialCharges
   * @param ShipChargeType $SurCharges
   * @param ShipChargeType $TransportationCharges
   * @param ShipChargeType $TotalCharge
   * @access public
   */
  public function __construct($AccessorialCharges = null, $SurCharges = null, $TransportationCharges = null, $TotalCharge = null)
  {
    $this->AccessorialCharges = $AccessorialCharges;
    $this->SurCharges = $SurCharges;
    $this->TransportationCharges = $TransportationCharges;
    $this->TotalCharge = $TotalCharge;
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
  public function getTotalCharge()
  {
    return $this->TotalCharge;
  }

  /**
   * 
   * @param ShipChargeType $TotalCharge
   */
  public function setTotalCharge($TotalCharge)
  {
    $this->TotalCharge = $TotalCharge;
  }

}
