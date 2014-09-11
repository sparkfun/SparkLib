<?php

namespace SparkLib\UPS\Rate;

class DryIceWeightType
{

  /**
   * 
   * @var CodeDescriptionType $UnitOfMeasurement
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
   * @param CodeDescriptionType $UnitOfMeasurement
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
   * @return CodeDescriptionType
   */
  public function getUnitOfMeasurement()
  {
    return $this->UnitOfMeasurement;
  }

  /**
   * 
   * @param CodeDescriptionType $UnitOfMeasurement
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
