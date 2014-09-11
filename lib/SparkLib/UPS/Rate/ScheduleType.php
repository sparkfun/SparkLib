<?php

namespace SparkLib\UPS\Rate;

class ScheduleType
{

  /**
   * 
   * @var string $PickupDay
   * @access public
   */
  public $PickupDay = null;

  /**
   * 
   * @var string $Method
   * @access public
   */
  public $Method = null;

  /**
   * 
   * @param string $PickupDay
   * @param string $Method
   * @access public
   */
  public function __construct($PickupDay = null, $Method = null)
  {
    $this->PickupDay = $PickupDay;
    $this->Method = $Method;
  }

  /**
   * 
   * @return string
   */
  public function getPickupDay()
  {
    return $this->PickupDay;
  }

  /**
   * 
   * @param string $PickupDay
   */
  public function setPickupDay($PickupDay)
  {
    $this->PickupDay = $PickupDay;
  }

  /**
   * 
   * @return string
   */
  public function getMethod()
  {
    return $this->Method;
  }

  /**
   * 
   * @param string $Method
   */
  public function setMethod($Method)
  {
    $this->Method = $Method;
  }

}
