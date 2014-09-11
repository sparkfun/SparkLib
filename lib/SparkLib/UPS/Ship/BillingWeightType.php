<?php

namespace SparkLib\UPS\Ship;

class BillingWeightType
{

  /**
   * 
   * @var BillingUnitOfMeasurementType $UnitOfMeasurement
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
   * @param BillingUnitOfMeasurementType $UnitOfMeasurement
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
   * @return BillingUnitOfMeasurementType
   */
  public function getUnitOfMeasurement()
  {
    return $this->UnitOfMeasurement;
  }

  /**
   * 
   * @param BillingUnitOfMeasurementType $UnitOfMeasurement
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
