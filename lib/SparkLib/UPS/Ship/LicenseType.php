<?php

namespace SparkLib\UPS\Ship;

class LicenseType
{

  /**
   * 
   * @var string $Number
   * @access public
   */
  public $Number = null;

  /**
   * 
   * @var string $Date
   * @access public
   */
  public $Date = null;

  /**
   * 
   * @var string $ExceptionCode
   * @access public
   */
  public $ExceptionCode = null;

  /**
   * 
   * @param string $Number
   * @param string $Date
   * @param string $ExceptionCode
   * @access public
   */
  public function __construct($Number = null, $Date = null, $ExceptionCode = null)
  {
    $this->Number = $Number;
    $this->Date = $Date;
    $this->ExceptionCode = $ExceptionCode;
  }

  /**
   * 
   * @return string
   */
  public function getNumber()
  {
    return $this->Number;
  }

  /**
   * 
   * @param string $Number
   */
  public function setNumber($Number)
  {
    $this->Number = $Number;
  }

  /**
   * 
   * @return string
   */
  public function getDate()
  {
    return $this->Date;
  }

  /**
   * 
   * @param string $Date
   */
  public function setDate($Date)
  {
    $this->Date = $Date;
  }

  /**
   * 
   * @return string
   */
  public function getExceptionCode()
  {
    return $this->ExceptionCode;
  }

  /**
   * 
   * @param string $ExceptionCode
   */
  public function setExceptionCode($ExceptionCode)
  {
    $this->ExceptionCode = $ExceptionCode;
  }

}
