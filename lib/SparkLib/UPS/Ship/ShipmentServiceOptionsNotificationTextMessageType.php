<?php

namespace SparkLib\UPS\Ship;

class ShipmentServiceOptionsNotificationTextMessageType
{

  /**
   * 
   * @var string $PhoneNumber
   * @access public
   */
  public $PhoneNumber = null;

  /**
   * 
   * @param string $PhoneNumber
   * @access public
   */
  public function __construct($PhoneNumber = null)
  {
    $this->PhoneNumber = $PhoneNumber;
  }

  /**
   * 
   * @return string
   */
  public function getPhoneNumber()
  {
    return $this->PhoneNumber;
  }

  /**
   * 
   * @param string $PhoneNumber
   */
  public function setPhoneNumber($PhoneNumber)
  {
    $this->PhoneNumber = $PhoneNumber;
  }

}
