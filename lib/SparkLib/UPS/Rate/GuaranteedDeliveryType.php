<?php

namespace SparkLib\UPS\Rate;

class GuaranteedDeliveryType
{

  /**
   * 
   * @var string $BusinessDaysInTransit
   * @access public
   */
  public $BusinessDaysInTransit = null;

  /**
   * 
   * @var string $DeliveryByTime
   * @access public
   */
  public $DeliveryByTime = null;

  /**
   * 
   * @param string $BusinessDaysInTransit
   * @param string $DeliveryByTime
   * @access public
   */
  public function __construct($BusinessDaysInTransit = null, $DeliveryByTime = null)
  {
    $this->BusinessDaysInTransit = $BusinessDaysInTransit;
    $this->DeliveryByTime = $DeliveryByTime;
  }

  /**
   * 
   * @return string
   */
  public function getBusinessDaysInTransit()
  {
    return $this->BusinessDaysInTransit;
  }

  /**
   * 
   * @param string $BusinessDaysInTransit
   */
  public function setBusinessDaysInTransit($BusinessDaysInTransit)
  {
    $this->BusinessDaysInTransit = $BusinessDaysInTransit;
  }

  /**
   * 
   * @return string
   */
  public function getDeliveryByTime()
  {
    return $this->DeliveryByTime;
  }

  /**
   * 
   * @param string $DeliveryByTime
   */
  public function setDeliveryByTime($DeliveryByTime)
  {
    $this->DeliveryByTime = $DeliveryByTime;
  }

}
