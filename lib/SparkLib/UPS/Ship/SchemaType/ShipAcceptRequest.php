<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ShipAcceptRequest
{

  /**
   *
   * @var RequestType $Request
   * @access public
   */
  public $Request = null;

  /**
   *
   * @var string $ShipmentDigest
   * @access public
   */
  public $ShipmentDigest = null;

  /**
   *
   * @param RequestType $Request
   * @param string $ShipmentDigest
   * @access public
   */
  public function __construct($Request = null, $ShipmentDigest = null)
  {
    $this->Request = $Request;
    $this->ShipmentDigest = $ShipmentDigest;
  }

  /**
   *
   * @return RequestType
   */
  public function getRequest()
  {
    return $this->Request;
  }

  /**
   *
   * @param RequestType $Request
   */
  public function setRequest($Request)
  {
    $this->Request = $Request;
  }

  /**
   *
   * @return string
   */
  public function getShipmentDigest()
  {
    return $this->ShipmentDigest;
  }

  /**
   *
   * @param string $ShipmentDigest
   */
  public function setShipmentDigest($ShipmentDigest)
  {
    $this->ShipmentDigest = $ShipmentDigest;
  }

}
