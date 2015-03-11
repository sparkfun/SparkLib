<?php

namespace SparkLib\IataClassifier;

use \Exception;

use \SparkLib\IataClassifier\IataLiIonBattery,
    \SparkLib\IataClassifier\IataLiMetalBattery;

abstract class IataBattery {

  // Battery chemistries
  const LI_ION                = 1;
  const LI_METAL              = 2;

  // Battery packaging type
  const BATTERY_ONLY          = 1;
  const PACKED_EQUIPMENT      = 2;
  const CONTAINED_EQUIPMENT   = 3;

  // Battery size
  const SMALL                 = 1;
  const MEDIUM                = 2;
  const LARGE                 = 3;

  // Classification Q values
  const Q_SM                  = 2.5;
  const Q_CELL_MED            = 8;
  const Q_BATT_MED            = 2;

  protected $weight;
  protected $voltage;
  protected $charge;
  protected $cells;
  protected $packaging;
  protected $exempt = false;

  abstract protected function getLithiumContent();
  abstract protected function iataSize();
  abstract protected function iataClassification();
  abstract protected function getChemistry();

  public function __construct ($params = null)
  {
    if ($params !== null) {
      if (isset($params['weight']))
        $this->setWeight($params['weight']);

      if (isset($params['voltage']))
        $this->setVoltage($params['voltage']);

      if (isset($params['charge']))
        $this->setCharge($params['charge']);

      if (isset($params['cells']))
        $this->setCells($params['cells']);

      if (isset($params['packaging']))
        $this->setPackaging($params['packaging']);

      if (isset($params['exempt']))
        $this->setExempt($params['exempt']);

    } else {
      $this->setCells(1);
      $this->setPackaging(self::BATTERY_ONLY);
    }
  }

  public static function create($chemistry = null) {
    if ($chemistry == static::LI_ION)
      return new IataLiIonBattery();
    else if ($chemistry == static::LI_METAL)
      return new IataLiMetalBattery();
  }

  public function setWeight($weight)
  {
    if (! is_numeric($weight) || $weight < 0)
      throw new Exception('Invalid battery weight.');
    $this->weight = $weight;

    return $this;
  }

  public function setCells($cells)
  {
    if (! is_integer($cells) || $cells < 1)
      throw new Exception('Invalid number of battery cells.');
    $this->cells = $cells;

    return $this;
  }

  public function setVoltage($voltage)
  {
    if (! is_numeric($voltage) || $voltage < 0)
      throw new Exception('Invalid battery voltage.');
    $this->voltage = $voltage;

    return $this;
  }

  public function setCharge($charge)
  {
    if (! is_numeric($charge) || $charge < 0)
      throw new Exception('Invalid battery charge.');
    $this->charge = $charge;

    return $this;
  }

  public function setPackaging($packaging)
  {
    if (! is_integer($packaging) || $packaging < 1 || $packaging > 3)
      throw new Exception('Invalid battery packaging type.');
    $this->packaging = $packaging;

    return $this;
  }

  public function setExempt($exempt = true)
  {
    $this->exempt = $exempt;

    return $this;
  }

  public function getWeight()
  {
    return $this->weight;
  }

  public function isLiIon()
  {
    return $this instanceOf IataLiIonBattery;
  }

  public function isLiMetal()
  {
    return $this instanceOf IataLiMetalBattery;
  }

  public function getCells()
  {
    return $this->cells;
  }

  public function isBattery()
  {
    return $this->cells > 1;
  }

  public function isCell()
  {
    return $this->cells == 1;
  }

  public function isExempt()
  {
    return $this->exempt;
  }

  public function getVoltage()
  {
    return $this->voltage;
  }

  public function getCharge()
  {
    return $this->charge;
  }

  public function getEnergy()
  {
    return $this->voltage * $this->charge;
  }

  public function getPackaging()
  {
    return $this->packaging;
  }

  public function isBatteryOnly()
  {
    return $this->packaging == static::BATTERY_ONLY;
  }

  public function isPackedEquipment()
  {
    return $this->packaging == static::PACKED_EQUIPMENT;
  }

  public function isContainedEquipment()
  {
    return $this->packaging == static::CONTAINED_EQUIPMENT;
  }

  public function isSmall()
  {
    return $this->iataSize() == static::SMALL;
  }

  public function isMedium()
  {
    return $this->iataSize() == static::MEDIUM;
  }

  public function isLarge()
  {
    return $this->iataSize() == static::LARGE;
  }

  public function validateBattery() {
    if ($this->weight === null)
      throw new Exception('Weight must be set.');

    if ($this->voltage === null)
      throw new Exception('Voltage must be set.');

    if ($this->charge === null)
      throw new Exception('Charge must be set.');

    if ($this->cells === null)
      throw new Exception('Cells must be set.');

    if ($this->packaging === null)
      throw new Exception('Packaging must be set.');
  }

  public function qValue()
  {
    $this->validateBattery();

    if ($this->isSmall())
      return $this->getWeight() / static::Q_SM;
    else if ($this->isMedium() &&  $this->isCell())
      return 1 / static::Q_CELL_MED;
    else if ($this->isMedium() &&  $this->isBattery())
      return 1 / static::Q_BATT_MED;
  }
}
