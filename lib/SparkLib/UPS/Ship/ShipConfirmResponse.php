<?php

namespace SparkLib\UPS\Ship;

class ShipConfirmResponse
{

  /**
   * 
   * @var ResponseType $Response
   * @access public
   */
  public $Response = null;

  /**
   * 
   * @var ShipmentResultsType $ShipmentResults
   * @access public
   */
  public $ShipmentResults = null;

  /**
   * 
   * @param ResponseType $Response
   * @param ShipmentResultsType $ShipmentResults
   * @access public
   */
  public function __construct($Response = null, $ShipmentResults = null)
  {
    $this->Response = $Response;
    $this->ShipmentResults = $ShipmentResults;
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
   * @return ShipmentResultsType
   */
  public function getShipmentResults()
  {
    return $this->ShipmentResults;
  }

  /**
   * 
   * @param ShipmentResultsType $ShipmentResults
   */
  public function setShipmentResults($ShipmentResults)
  {
    $this->ShipmentResults = $ShipmentResults;
  }

}
