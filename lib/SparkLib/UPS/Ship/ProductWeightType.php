<?php

namespace SparkLib\UPS\Ship;

class ProductWeightType
{

  /**
   * 
   * @var UnitOfMeasurementType $UnitOfMeasurement
   * @access public
   */
  public $UnitOfMeasurement = null;

  /**
   * 
   * @var string $Weight
   * @access public
   */
  public $Weight = null;

  /**
   * 
   * @param UnitOfMeasurementType $UnitOfMeasurement
   * @param string $Weight
   * @access public
   */
  public function __construct($UnitOfMeasurement = null, $Weight = null)
  {
    $this->UnitOfMeasurement = $UnitOfMeasurement;
    $this->Weight = $Weight;
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
  public function getWeight()
  {
    return $this->Weight;
  }

  /**
   * 
   * @param string $Weight
   */
  public function setWeight($Weight)
  {
    $this->Weight = $Weight;
  }

}
