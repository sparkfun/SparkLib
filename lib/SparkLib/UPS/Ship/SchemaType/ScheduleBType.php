<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ScheduleBType
{

  /**
   *
   * @var string $Number
   * @access public
   */
  public $Number = null;

  /**
   *
   * @var string $Quantity
   * @access public
   */
  public $Quantity = null;

  /**
   *
   * @var UnitOfMeasurementType $UnitOfMeasurement
   * @access public
   */
  public $UnitOfMeasurement = null;

  /**
   *
   * @param string $Number
   * @param string $Quantity
   * @param UnitOfMeasurementType $UnitOfMeasurement
   * @access public
   */
  public function __construct($Number = null, $Quantity = null, $UnitOfMeasurement = null)
  {
    $this->Number = $Number;
    $this->Quantity = $Quantity;
    $this->UnitOfMeasurement = $UnitOfMeasurement;
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
  public function getQuantity()
  {
    return $this->Quantity;
  }

  /**
   *
   * @param string $Quantity
   */
  public function setQuantity($Quantity)
  {
    $this->Quantity = $Quantity;
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

}
