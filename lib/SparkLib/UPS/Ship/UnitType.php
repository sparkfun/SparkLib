<?php

namespace SparkLib\UPS\Ship;

class UnitType
{

  /**
   * 
   * @var string $Number
   * @access public
   */
  public $Number = null;

  /**
   * 
   * @var UnitOfMeasurementType $UnitOfMeasurement
   * @access public
   */
  public $UnitOfMeasurement = null;

  /**
   * 
   * @var string $Value
   * @access public
   */
  public $Value = null;

  /**
   * 
   * @param string $Number
   * @param UnitOfMeasurementType $UnitOfMeasurement
   * @param string $Value
   * @access public
   */
  public function __construct($Number = null, $UnitOfMeasurement = null, $Value = null)
  {
    $this->Number = $Number;
    $this->UnitOfMeasurement = $UnitOfMeasurement;
    $this->Value = $Value;
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
   * @return UnitOfMeasurementType
   */
  public function getUnitOfMeasurement()
  {
    return $this->UnitOfMeasurement;
  }

  /**
   * 
   * @param UnitOfMeasurementType $UnitOfMeasurement
   */
  public function setUnitOfMeasurement($UnitOfMeasurement)
  {
    $this->UnitOfMeasurement = $UnitOfMeasurement;
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
