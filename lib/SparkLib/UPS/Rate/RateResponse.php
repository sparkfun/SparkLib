<?php

namespace SparkLib\UPS\Rate;

class RateResponse
{

  /**
   * 
   * @var ResponseType $Response
   * @access public
   */
  public $Response = null;

  /**
   * 
   * @var RatedShipmentType $RatedShipment
   * @access public
   */
  public $RatedShipment = null;

  /**
   * 
   * @param ResponseType $Response
   * @param RatedShipmentType $RatedShipment
   * @access public
   */
  public function __construct($Response = null, $RatedShipment = null)
  {
    $this->Response = $Response;
    $this->RatedShipment = $RatedShipment;
  }

  /**
   * 
   * @return ResponseType
   */
  public function getResponse()
  {
    return $this->Response;
  }

  /**
   * 
   * @param ResponseType $Response
   */
  public function setResponse($Response)
  {
    $this->Response = $Response;
  }

  /**
   * 
   * @return RatedShipmentType
   */
  public function getRatedShipment()
  {
    return $this->RatedShipment;
  }

  /**
   * 
   * @param RatedShipmentType $RatedShipment
   */
  public function setRatedShipment($RatedShipment)
  {
    $this->RatedShipment = $RatedShipment;
  }

}
