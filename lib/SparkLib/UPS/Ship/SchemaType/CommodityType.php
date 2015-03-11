<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class CommodityType
{

  /**
   *
   * @var string $FreightClass
   * @access public
   */
  public $FreightClass = null;

  /**
   *
   * @var NMFCType $NMFC
   * @access public
   */
  public $NMFC = null;

  /**
   *
   * @param string $FreightClass
   * @param NMFCType $NMFC
   * @access public
   */
  public function __construct($FreightClass = null, $NMFC = null)
  {
    $this->FreightClass = $FreightClass;
    $this->NMFC = $NMFC;
  }

  /**
   *
   * @return string
   */
  public function getFreightClass()
  {
    return $this->FreightClass;
  }

  /**
   *
   * @param string $FreightClass
   */
  public function setFreightClass($FreightClass)
  {
    $this->FreightClass = $FreightClass;
  }

  /**
   *
   * @return NMFCType
   */
  public function getNMFC()
  {
    return $this->NMFC;
  }

  /**
   *
   * @param NMFCType $NMFC
   */
  public function setNMFC($NMFC)
  {
    $this->NMFC = $NMFC;
  }

}
