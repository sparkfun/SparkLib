<?php

namespace SparkLib\UPS\Ship;

class DryIceWeightType
{

  /**
   * 
   * @var ShipUnitOfMeasurementType $UnitOfMeasurement
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
   * @param ShipUnitOfMeasurementType $UnitOfMeasurement
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
