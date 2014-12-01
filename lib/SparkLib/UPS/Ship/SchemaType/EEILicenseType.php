<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class EEILicenseType
{

  /**
   *
   * @var string $Number
   * @access public
   */
  public $Number = null;

  /**
   *
   * @var string $Code
   * @access public
   */
  public $Code = null;

  /**
   *
   * @var string $LicenseLineValue
   * @access public
   */
  public $LicenseLineValue = null;

  /**
   *
   * @var string $ECCNNumber
   * @access public
   */
  public $ECCNNumber = null;

  /**
   *
   * @param string $Number
   * @param string $Code
   * @param string $LicenseLineValue
   * @param string $ECCNNumber
   * @access public
   */
  public function __construct($Number = null, $Code = null, $LicenseLineValue = null, $ECCNNumber = null)
  {
    $this->Number = $Number;
    $this->Code = $Code;
    $this->LicenseLineValue = $LicenseLineValue;
    $this->ECCNNumber = $ECCNNumber;
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
  public function getCode()
  {
    return $this->Code;
  }

  /**
   *
   * @param string $Code
   */
  public function setCode($Code)
  {
    $this->Code = $Code;
  }

  /**
   *
   * @return string
   */
  public function getLicenseLineValue()
  {
    return $this->LicenseLineValue;
  }

  /**
   *
   * @param string $LicenseLineValue
   */
  public function setLicenseLineValue($LicenseLineValue)
  {
    $this->LicenseLineValue = $LicenseLineValue;
  }

  /**
   *
   * @return string
   */
  public function getECCNNumber()
  {
    return $this->ECCNNumber;
  }

  /**
   *
   * @param string $ECCNNumber
   */
  public function setECCNNumber($ECCNNumber)
  {
    $this->ECCNNumber = $ECCNNumber;
  }

}
