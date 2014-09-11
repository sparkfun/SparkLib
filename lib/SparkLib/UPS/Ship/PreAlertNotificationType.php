<?php

namespace SparkLib\UPS\Ship;

class PreAlertNotificationType
{

  /**
   * 
   * @var PreAlertEMailMessageType $EMailMessage
   * @access public
   */
  public $EMailMessage = null;

  /**
   * 
   * @var PreAlertVoiceMessageType $VoiceMessage
   * @access public
   */
  public $VoiceMessage = null;

  /**
   * 
   * @var PreAlertTextMessageType $TextMessage
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
   * @param PreAlertEMailMessageType $EMailMessage
   * @param PreAlertVoiceMessageType $VoiceMessage
   * @param PreAlertTextMessageType $TextMessage
   * @param LocaleType $Locale
   * @access public
   */
  public function __construct($EMailMessage = null, $VoiceMessage = null, $TextMessage = null, $Locale = null)
  {
    $this->EMailMessage = $EMailMessage;
    $this->VoiceMessage = $VoiceMessage;
    $this->TextMessage = $TextMessage;
    $this->Locale = $Locale;
  }

  /**
   * 
   * @return PreAlertEMailMessageType
   */
  public function getEMailMessage()
  {
    return $this->EMailMessage;
  }

  /**
   * 
   * @param PreAlertEMailMessageType $EMailMessage
   */
  public function setEMailMessage($EMailMessage)
  {
    $this->EMailMessage = $EMailMessage;
  }

  /**
   * 
   * @return PreAlertVoiceMessageType
   */
  public function getVoiceMessage()
  {
    return $this->VoiceMessage;
  }

  /**
   * 
   * @param PreAlertVoiceMessageType $VoiceMessage
   */
  public function setVoiceMessage($VoiceMessage)
  {
    $this->VoiceMessage = $VoiceMessage;
  }

  /**
   * 
   * @return PreAlertTextMessageType
   */
  public function getTextMessage()
  {
    return $this->TextMessage;
  }

  /**
   * 
   * @param PreAlertTextMessageType $TextMessage
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
