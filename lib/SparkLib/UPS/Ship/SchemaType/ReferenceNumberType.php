<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ReferenceNumberType
{

  /**
   *
   * @var string $BarCodeIndicator
   * @access public
   */
  public $BarCodeIndicator = null;

  /**
   *
   * @var string $Code
   * @access public
   */
  public $Code = null;

  /**
   *
   * @var string $Value
   * @access public
   */
  public $Value = null;

  /**
   *
   * @param string $BarCodeIndicator
   * @param string $Code
   * @param string $Value
   * @access public
   */
  public function __construct($BarCodeIndicator = null, $Code = null, $Value = null)
  {
    $this->BarCodeIndicator = $BarCodeIndicator;
    $this->Code = $Code;
    $this->Value = $Value;
  }

  /**
   *
   * @return string
   */
  public function getBarCodeIndicator()
  {
    return $this->BarCodeIndicator;
  }

  /**
   *
   * @param string $BarCodeIndicator
   */
  public function setBarCodeIndicator($BarCodeIndicator)
  {
    $this->BarCodeIndicator = $BarCodeIndicator;
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
  public function getValue()
  {
    return $this->Value;
  }

  /**
   *
   * @param string $Value
   */
  public function setValue($Value)
  {
    $this->Value = $Value;
  }

}
