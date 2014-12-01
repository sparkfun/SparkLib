<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ShipperFiledType
{

  /**
   *
   * @var string $Code
   * @access public
   */
  public $Code = null;

  /**
   *
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   *
   * @var string $PreDepartureITNNumber
   * @access public
   */
  public $PreDepartureITNNumber = null;

  /**
   *
   * @var string $ExemptionLegend
   * @access public
   */
  public $ExemptionLegend = null;

  /**
   *
   * @param string $Code
   * @param string $Description
   * @param string $PreDepartureITNNumber
   * @param string $ExemptionLegend
   * @access public
   */
  public function __construct($Code = null, $Description = null, $PreDepartureITNNumber = null, $ExemptionLegend = null)
  {
    $this->Code = $Code;
    $this->Description = $Description;
    $this->PreDepartureITNNumber = $PreDepartureITNNumber;
    $this->ExemptionLegend = $ExemptionLegend;
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
  public function getDescription()
  {
    return $this->Description;
  }

  /**
   *
   * @param string $Description
   */
  public function setDescription($Description)
  {
    $this->Description = $Description;
  }

  /**
   *
   * @return string
   */
  public function getPreDepartureITNNumber()
  {
    return $this->PreDepartureITNNumber;
  }

  /**
   *
   * @param string $PreDepartureITNNumber
   */
  public function setPreDepartureITNNumber($PreDepartureITNNumber)
  {
    $this->PreDepartureITNNumber = $PreDepartureITNNumber;
  }

  /**
   *
   * @return string
   */
  public function getExemptionLegend()
  {
    return $this->ExemptionLegend;
  }

  /**
   *
   * @param string $ExemptionLegend
   */
  public function setExemptionLegend($ExemptionLegend)
  {
    $this->ExemptionLegend = $ExemptionLegend;
  }

}
