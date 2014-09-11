<?php

namespace SparkLib\UPS\Rate;

class TotalChargeType
{

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
   * @var ChargesType $TransportationCharges
   * @access public
   */
  public $TransportationCharges = null;

  /**
   * 
   * @var ChargesType $TotalCharge
   * @access public
   */
  public $TotalCharge = null;

  /**
   * 
   * @param ChargesType $AccessorialCharges
   * @param ChargesType $SurCharges
   * @param ChargesType $TransportationCharges
   * @param ChargesType $TotalCharge
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
  public function getTotalCharge()
  {
    return $this->TotalCharge;
  }

  /**
   * 
   * @param ChargesType $TotalCharge
   */
  public function setTotalCharge($TotalCharge)
  {
    $this->TotalCharge = $TotalCharge;
  }

}
