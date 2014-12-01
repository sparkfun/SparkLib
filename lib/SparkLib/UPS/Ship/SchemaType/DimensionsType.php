<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class DimensionsType
{

  /**
   *
   * @var ShipUnitOfMeasurementType $UnitOfMeasurement
   * @access public
   */
  public $UnitOfMeasurement = null;

  /**
   *
   * @var string $Length
   * @access public
   */
  public $Length = null;

  /**
   *
   * @var string $Width
   * @access public
   */
  public $Width = null;

  /**
   *
   * @var string $Height
   * @access public
   */
  public $Height = null;

  /**
   *
   * @param ShipUnitOfMeasurementType $UnitOfMeasurement
   * @param string $Length
   * @param string $Width
   * @param string $Height
   * @access public
   */
  public function __construct($UnitOfMeasurement = null, $Length = null, $Width = null, $Height = null)
  {
    $this->UnitOfMeasurement = $UnitOfMeasurement;
    $this->Length = $Length;
    $this->Width = $Width;
    $this->Height = $Height;
  }

  /**
   *
   * @return ShipUnitOfMeasurementType
   */
  public function getUnitOfMeasurement()
  {
    return $this->UnitOfMeasurement;
  }

  /**
   *
   * @param ShipUnitOfMeasurementType $UnitOfMeasurement
   */
  public function setUnitOfMeasurement($UnitOfMeasurement)
  {
    $this->UnitOfMeasurement = $UnitOfMeasurement;
  }

  /**
   *
   * @return string
   */
  public function getLength()
  {
    return $this->Length;
  }

  /**
   *
   * @param string $Length
   */
  public function setLength($Length)
  {
    $this->Length = $Length;
  }

  /**
   *
   * @return string
   */
  public function getWidth()
  {
    return $this->Width;
  }

  /**
   *
   * @param string $Width
   */
  public function setWidth($Width)
  {
    $this->Width = $Width;
  }

  /**
   *
   * @return string
   */
  public function getHeight()
  {
    return $this->Height;
  }

  /**
   *
   * @param string $Height
   */
  public function setHeight($Height)
  {
    $this->Height = $Height;
  }

}
