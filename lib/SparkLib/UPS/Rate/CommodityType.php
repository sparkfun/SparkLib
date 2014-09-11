<?php

namespace SparkLib\UPS\Rate;

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
   * @var NMFCCommodityType $NMFC
   * @access public
   */
  public $NMFC = null;

  /**
   * 
   * @param string $FreightClass
   * @param NMFCCommodityType $NMFC
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
   * @return NMFCCommodityType
   */
  public function getNMFC()
  {
    return $this->NMFC;
  }

  /**
   * 
   * @param NMFCCommodityType $NMFC
   */
  public function setNMFC($NMFC)
  {
    $this->NMFC = $NMFC;
  }

}
