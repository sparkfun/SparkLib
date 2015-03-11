<?php

namespace SparkLib\IataClassifier;

use \Exception;

use \SparkLib\IataClassifier\IataBattery,
    \SparkLib\IataClassifier\IataClassifier;

class IataLiMetalBattery extends IataBattery {

  // Classification cutoffs
  const LI_METAL_SM           = 0.3;
  const LI_METAL_CELL         = 1.0;
  const LI_METAL_BATT         = 2.0;

  private $lithium;

  public function __construct ($params = null)
  {
    if ($params != null) {
      if (isset($params['lithium']))
        $this->setLithium($params['lithium']);
    }

    parent::__construct($params);
  }

  public static function create($chemistry = null) {
    return new static;
  }

  public function getChemistry()
  {
    return IataBattery::LI_METAL;
  }

  public function setLithiumContent($lithium)
  {
    if (! is_numeric($lithium) || $lithium < 0)
      throw new Exception('Invalid lithium content amount.');

    $this->lithium = $lithium;

    return $this;
  }

  public function getLithiumContent()
  {
    return $this->lithium;
  }

  public function iataSize()
  {
    if ($this->getLithiumContent() <= static::LI_METAL_SM)
      return static::SMALL;
    else if ($this->isCell() && $this->getLithiumContent() <= static::LI_METAL_CELL)
      return static::MEDIUM;
    else if ($this->isBattery() && $this->getLithiumContent() <= static::LI_METAL_BATT)
      return static::MEDIUM;
    else
      return static::LARGE;
  }

  public function validateBattery() {
    if ($this->lithium === null)
      throw new Exception('Lithium content must be set.');
    parent::validateBattery();
  }

  public function iataClassification()
  {
    $this->validateBattery();

    switch ($this->getPackaging()) {
      case IataBattery::BATTERY_ONLY :
        switch ($this->iataSize()) {
          case static::SMALL  : return IataClassifier::IATA_968_II;
          case static::MEDIUM : return IataClassifier::IATA_968_II;
          case static::LARGE  : return IataClassifier::IATA_968_IA;
        }
      case IataBattery::PACKED_EQUIPMENT :
        switch ($this->iataSize()) {
          case static::SMALL  : return IataClassifier::IATA_969_II;
          case static::MEDIUM : return IataClassifier::IATA_969_II;
          case static::LARGE  : return IataClassifier::IATA_969_I;
        }
      case IataBattery::CONTAINED_EQUIPMENT :
        switch ($this->iataSize()) {
          case static::SMALL  : return IataClassifier::IATA_970_II;
          case static::MEDIUM : return IataClassifier::IATA_970_II;
          case static::LARGE  : return IataClassifier::IATA_970_I;
        }
    }
  }
}
