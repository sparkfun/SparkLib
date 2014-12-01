<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class PreAlertEMailMessageType
{

  /**
   *
   * @var string $EMailAddress
   * @access public
   */
  public $EMailAddress = null;

  /**
   *
   * @var string $UndeliverableEMailAddress
   * @access public
   */
  public $UndeliverableEMailAddress = null;

  /**
   *
   * @param string $EMailAddress
   * @param string $UndeliverableEMailAddress
   * @access public
   */
  public function __construct($EMailAddress = null, $UndeliverableEMailAddress = null)
  {
    $this->EMailAddress = $EMailAddress;
    $this->UndeliverableEMailAddress = $UndeliverableEMailAddress;
  }

  /**
   *
   * @return string
   */
  public function getEMailAddress()
  {
    return $this->EMailAddress;
  }

  /**
   *
   * @param string $EMailAddress
   */
  public function setEMailAddress($EMailAddress)
  {
    $this->EMailAddress = $EMailAddress;
  }

  /**
   *
   * @return string
   */
  public function getUndeliverableEMailAddress()
  {
    return $this->UndeliverableEMailAddress;
  }

  /**
   *
   * @param string $UndeliverableEMailAddress
   */
  public function setUndeliverableEMailAddress($UndeliverableEMailAddress)
  {
    $this->UndeliverableEMailAddress = $UndeliverableEMailAddress;
  }

}
