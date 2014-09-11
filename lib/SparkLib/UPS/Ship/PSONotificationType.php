<?php

namespace SparkLib\UPS\Ship;

class PSONotificationType
{

  /**
   * 
   * @var string $NotificationCode
   * @access public
   */
  public $NotificationCode = null;

  /**
   * 
   * @var EmailDetailsType $EMail
   * @access public
   */
  public $EMail = null;

  /**
   * 
   * @param string $NotificationCode
   * @param EmailDetailsType $EMail
   * @access public
   */
  public function __construct($NotificationCode = null, $EMail = null)
  {
    $this->NotificationCode = $NotificationCode;
    $this->EMail = $EMail;
  }

  /**
   * 
   * @return string
   */
  public function getNotificationCode()
  {
    return $this->NotificationCode;
  }

  /**
   * 
   * @param string $NotificationCode
   */
  public function setNotificationCode($NotificationCode)
  {
    $this->NotificationCode = $NotificationCode;
  }

  /**
   * 
   * @return EmailDetailsType
   */
  public function getEMail()
  {
    return $this->EMail;
  }

  /**
   * 
   * @param EmailDetailsType $EMail
   */
  public function setEMail($EMail)
  {
    $this->EMail = $EMail;
  }

}
