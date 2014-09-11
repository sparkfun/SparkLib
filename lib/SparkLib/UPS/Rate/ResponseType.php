<?php

namespace SparkLib\UPS\Rate;

class ResponseType
{

  /**
   * 
   * @var CodeDescriptionType $ResponseStatus
   * @access public
   */
  public $ResponseStatus = null;

  /**
   * 
   * @var CodeDescriptionType $Alert
   * @access public
   */
  public $Alert = null;

  /**
   * 
   * @var TransactionReferenceType $TransactionReference
   * @access public
   */
  public $TransactionReference = null;

  /**
   * 
   * @param CodeDescriptionType $ResponseStatus
   * @param CodeDescriptionType $Alert
   * @param TransactionReferenceType $TransactionReference
   * @access public
   */
  public function __construct($ResponseStatus = null, $Alert = null, $TransactionReference = null)
  {
    $this->ResponseStatus = $ResponseStatus;
    $this->Alert = $Alert;
    $this->TransactionReference = $TransactionReference;
  }

  /**
   * 
   * @return CodeDescriptionType
   */
  public function getResponseStatus()
  {
    return $this->ResponseStatus;
  }

  /**
   * 
   * @param CodeDescriptionType $ResponseStatus
   */
  public function setResponseStatus($ResponseStatus)
  {
    $this->ResponseStatus = $ResponseStatus;
  }

  /**
   * 
   * @return CodeDescriptionType
   */
  public function getAlert()
  {
    return $this->Alert;
  }

  /**
   * 
   * @param CodeDescriptionType $Alert
   */
  public function setAlert($Alert)
  {
    $this->Alert = $Alert;
  }

  /**
   * 
   * @return TransactionReferenceType
   */
  public function getTransactionReference()
  {
    return $this->TransactionReference;
  }

  /**
   * 
   * @param TransactionReferenceType $TransactionReference
   */
  public function setTransactionReference($TransactionReference)
  {
    $this->TransactionReference = $TransactionReference;
  }

}
