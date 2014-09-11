<?php

namespace SparkLib\UPS\Rate;

class DeliveryConfirmationType
{

  /**
   * 
   * @var string $DCISType
   * @access public
   */
  public $DCISType = null;

  /**
   * 
   * @param string $DCISType
   * @access public
   */
  public function __construct($DCISType = null)
  {
    $this->DCISType = $DCISType;
  }

  /**
   * 
   * @return string
   */
  public function getDCISType()
  {
    return $this->DCISType;
  }

  /**
   * 
   * @param string $DCISType
   */
  public function setDCISType($DCISType)
  {
    $this->DCISType = $DCISType;
  }

}
