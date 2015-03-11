<?php

namespace SparkLib\IataClassifier;

use \Exception;

use \SparkLib\IataClassifier\IataBattery,
    \SparkLib\IataClassifier\IataClassifier;

class IataLiIonBattery extends IataBattery {

  // Classification cutoffs
  const LI_ION_SM             = 2.7;
  const LI_ION_CELL           = 20.0;
  const LI_ION_BATT           = 100.0;

  public static function create($chemistry = null) {
    return new static;
  }

  public function getChemistry()
  {
    return IataBattery::LI_ION;
  }

  public function getLithiumContent()
  {
    return $this->getEnergy() * 0.3;
  }

  public function iataSize()
  {
    if ($this->getEnergy() <= static::LI_ION_SM)
      return static::SMALL;
    else if ($this->isCell() && $this->getEnergy() <= static::LI_ION_CELL)
      return static::MEDIUM;
    else if ($this->isBattery() && $this->getEnergy() <= static::LI_ION_BATT)
      return static::MEDIUM;
    else
      return static::LARGE;
  }

  public function iataClassification()
  {
    switch ($this->getPackaging()) {
      case IataBattery::BATTERY_ONLY :
        switch ($this->iataSize()) {
          case static::SMALL  : return IataClassifier::IATA_965_II;
          case static::MEDIUM : return IataClassifier::IATA_965_II;
          case static::LARGE  : return IataClassifier::IATA_965_IA;
        }
      case IataBattery::PACKED_EQUIPMENT :
        switch ($this->iataSize()) {
          case static::SMALL  : return IataClassifier::IATA_966_II;
          case static::MEDIUM : return IataClassifier::IATA_966_II;
          case static::LARGE  : return IataClassifier::IATA_966_I;
        }
      case IataBattery::CONTAINED_EQUIPMENT :
        switch ($this->iataSize()) {
          case static::SMALL  : return IataClassifier::IATA_967_II;
          case static::MEDIUM : return IataClassifier::IATA_967_II;
          case static::LARGE  : return IataClassifier::IATA_967_I;
        }
    }
  }
}
