<?php

namespace SparkLib\UPS\Rate;

class OnCallPickupType
{

  /**
   * 
   * @var ScheduleType $Schedule
   * @access public
   */
  public $Schedule = null;

  /**
   * 
   * @param ScheduleType $Schedule
   * @access public
   */
  public function __construct($Schedule = null)
  {
    $this->Schedule = $Schedule;
  }

  /**
   * 
   * @return ScheduleType
   */
  public function getSchedule()
  {
    return $this->Schedule;
  }

  /**
   * 
   * @param ScheduleType $Schedule
   */
  public function setSchedule($Schedule)
  {
    $this->Schedule = $Schedule;
  }

}
