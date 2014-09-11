<?php

namespace SparkLib\UPS\Rate;

class ErrorDetailType
{

  /**
   * 
   * @var string $Severity
   * @access public
   */
  public $Severity = null;

  /**
   * 
   * @var CodeType $PrimaryErrorCode
   * @access public
   */
  public $PrimaryErrorCode = null;

  /**
   * 
   * @var string $MinimumRetrySeconds
   * @access public
   */
  public $MinimumRetrySeconds = null;

  /**
   * 
   * @var LocationType $Location
   * @access public
   */
  public $Location = null;

  /**
   * 
   * @var CodeType $SubErrorCode
   * @access public
   */
  public $SubErrorCode = null;

  /**
   * 
   * @var AdditionalInfoType $AdditionalInformation
   * @access public
   */
  public $AdditionalInformation = null;

  /**
   * 
   * @param string $Severity
   * @param CodeType $PrimaryErrorCode
   * @param string $MinimumRetrySeconds
   * @param LocationType $Location
   * @param CodeType $SubErrorCode
   * @param AdditionalInfoType $AdditionalInformation
   * @access public
   */
  public function __construct($Severity = null, $PrimaryErrorCode = null, $MinimumRetrySeconds = null, $Location = null, $SubErrorCode = null, $AdditionalInformation = null)
  {
    $this->Severity = $Severity;
    $this->PrimaryErrorCode = $PrimaryErrorCode;
    $this->MinimumRetrySeconds = $MinimumRetrySeconds;
    $this->Location = $Location;
    $this->SubErrorCode = $SubErrorCode;
    $this->AdditionalInformation = $AdditionalInformation;
  }

  /**
   * 
   * @return string
   */
  public function getSeverity()
  {
    return $this->Severity;
  }

  /**
   * 
   * @param string $Severity
   */
  public function setSeverity($Severity)
  {
    $this->Severity = $Severity;
  }

  /**
   * 
   * @return CodeType
   */
  public function getPrimaryErrorCode()
  {
    return $this->PrimaryErrorCode;
  }

  /**
   * 
   * @param CodeType $PrimaryErrorCode
   */
  public function setPrimaryErrorCode($PrimaryErrorCode)
  {
    $this->PrimaryErrorCode = $PrimaryErrorCode;
  }

  /**
   * 
   * @return string
   */
  public function getMinimumRetrySeconds()
  {
    return $this->MinimumRetrySeconds;
  }

  /**
   * 
   * @param string $MinimumRetrySeconds
   */
  public function setMinimumRetrySeconds($MinimumRetrySeconds)
  {
    $this->MinimumRetrySeconds = $MinimumRetrySeconds;
  }

  /**
   * 
   * @return LocationType
   */
  public function getLocation()
  {
    return $this->Location;
  }

  /**
   * 
   * @param LocationType $Location
   */
  public function setLocation($Location)
  {
    $this->Location = $Location;
  }

  /**
   * 
   * @return CodeType
   */
  public function getSubErrorCode()
  {
    return $this->SubErrorCode;
  }

  /**
   * 
   * @param CodeType $SubErrorCode
   */
  public function setSubErrorCode($SubErrorCode)
  {
    $this->SubErrorCode = $SubErrorCode;
  }

  /**
   * 
   * @return AdditionalInfoType
   */
  public function getAdditionalInformation()
  {
    return $this->AdditionalInformation;
  }

  /**
   * 
   * @param AdditionalInfoType $AdditionalInformation
   */
  public function setAdditionalInformation($AdditionalInformation)
  {
    $this->AdditionalInformation = $AdditionalInformation;
  }

}
