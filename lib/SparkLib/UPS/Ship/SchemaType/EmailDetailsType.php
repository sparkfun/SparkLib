<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class EmailDetailsType
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
   * @var string $FromEMailAddress
   * @access public
   */
  public $FromEMailAddress = null;

  /**
   *
   * @var string $FromName
   * @access public
   */
  public $FromName = null;

  /**
   *
   * @var string $Memo
   * @access public
   */
  public $Memo = null;

  /**
   *
   * @var string $Subject
   * @access public
   */
  public $Subject = null;

  /**
   *
   * @var string $SubjectCode
   * @access public
   */
  public $SubjectCode = null;

  /**
   *
   * @param string $EMailAddress
   * @param string $UndeliverableEMailAddress
   * @param string $FromEMailAddress
   * @param string $FromName
   * @param string $Memo
   * @param string $Subject
   * @param string $SubjectCode
   * @access public
   */
  public function __construct($EMailAddress = null, $UndeliverableEMailAddress = null, $FromEMailAddress = null, $FromName = null, $Memo = null, $Subject = null, $SubjectCode = null)
  {
    $this->EMailAddress = $EMailAddress;
    $this->UndeliverableEMailAddress = $UndeliverableEMailAddress;
    $this->FromEMailAddress = $FromEMailAddress;
    $this->FromName = $FromName;
    $this->Memo = $Memo;
    $this->Subject = $Subject;
    $this->SubjectCode = $SubjectCode;
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

  /**
   *
   * @return string
   */
  public function getFromEMailAddress()
  {
    return $this->FromEMailAddress;
  }

  /**
   *
   * @param string $FromEMailAddress
   */
  public function setFromEMailAddress($FromEMailAddress)
  {
    $this->FromEMailAddress = $FromEMailAddress;
  }

  /**
   *
   * @return string
   */
  public function getFromName()
  {
    return $this->FromName;
  }

  /**
   *
   * @param string $FromName
   */
  public function setFromName($FromName)
  {
    $this->FromName = $FromName;
  }

  /**
   *
   * @return string
   */
  public function getMemo()
  {
    return $this->Memo;
  }

  /**
   *
   * @param string $Memo
   */
  public function setMemo($Memo)
  {
    $this->Memo = $Memo;
  }

  /**
   *
   * @return string
   */
  public function getSubject()
  {
    return $this->Subject;
  }

  /**
   *
   * @param string $Subject
   */
  public function setSubject($Subject)
  {
    $this->Subject = $Subject;
  }

  /**
   *
   * @return string
   */
  public function getSubjectCode()
  {
    return $this->SubjectCode;
  }

  /**
   *
   * @param string $SubjectCode
   */
  public function setSubjectCode($SubjectCode)
  {
    $this->SubjectCode = $SubjectCode;
  }

}
