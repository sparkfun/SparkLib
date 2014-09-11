<?php

namespace SparkLib\UPS\Ship;

class NotificationType
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
   * @var ShipmentServiceOptionsNotificationVoiceMessageType $VoiceMessage
   * @access public
   */
  public $VoiceMessage = null;

  /**
   * 
   * @var ShipmentServiceOptionsNotificationTextMessageType $TextMessage
   * @access public
   */
  public $TextMessage = null;

  /**
   * 
   * @var LocaleType $Locale
   * @access public
   */
  public $Locale = null;

  /**
   * 
   * @param string $NotificationCode
   * @param EmailDetailsType $EMail
   * @param ShipmentServiceOptionsNotificationVoiceMessageType $VoiceMessage
   * @param ShipmentServiceOptionsNotificationTextMessageType $TextMessage
   * @param LocaleType $Locale
   * @access public
   */
  public function __construct($NotificationCode = null, $EMail = null, $VoiceMessage = null, $TextMessage = null, $Locale = null)
  {
    $this->NotificationCode = $NotificationCode;
    $this->EMail = $EMail;
    $this->VoiceMessage = $VoiceMessage;
    $this->TextMessage = $TextMessage;
    $this->Locale = $Locale;
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

  /**
   * 
   * @return ShipmentServiceOptionsNotificationVoiceMessageType
   */
  public function getVoiceMessage()
  {
    return $this->VoiceMessage;
  }

  /**
   * 
   * @param ShipmentServiceOptionsNotificationVoiceMessageType $VoiceMessage
   */
  public function setVoiceMessage($VoiceMessage)
  {
    $this->VoiceMessage = $VoiceMessage;
  }

  /**
   * 
   * @return ShipmentServiceOptionsNotificationTextMessageType
   */
  public function getTextMessage()
  {
    return $this->TextMessage;
  }

  /**
   * 
   * @param ShipmentServiceOptionsNotificationTextMessageType $TextMessage
   */
  public function setTextMessage($TextMessage)
  {
    $this->TextMessage = $TextMessage;
  }

  /**
   * 
   * @return LocaleType
   */
  public function getLocale()
  {
    return $this->Locale;
  }

  /**
   * 
   * @param LocaleType $Locale
   */
  public function setLocale($Locale)
  {
    $this->Locale = $Locale;
  }

}
