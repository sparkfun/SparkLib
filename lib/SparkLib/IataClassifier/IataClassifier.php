<?php

namespace SparkLib\IataClassifier;

use \Exception;

use \SparkLib\IataClassifier\IataPackage,
    \SparkLib\IataClassifier\IataLineItem,
    \SparkLib\IataClassifier\IataBattery;

class IataClassifier {

  // No classification required
  const IATA_NONE     = 000;

  // Lithium ion
  const IATA_965_IA    = 111;
  const IATA_965_IB    = 112;
  const IATA_965_II    = 113;

  // Lithium ion packed with equipment
  const IATA_966_I     = 121;
  const IATA_966_II    = 122;

  // Lithium ion contained in equipment
  const IATA_967_I     = 131;
  const IATA_967_II    = 132;

  // Lithium metal
  const IATA_968_IA    = 211;
  const IATA_968_IB    = 212;
  const IATA_968_II    = 213;

  // Lithium metal packed with equipment
  const IATA_969_I     = 221;
  const IATA_969_II    = 222;

  // Lithium metal contained in equipment
  const IATA_970_I     = 231;
  const IATA_970_II    = 232;

  // Multiple types
  const IATA_MULTIPLE  = 555;

  // Illegal to ship
  const IATA_ILLEGAL   = 666;

  // Various package markings that might be required
  const IATA_BATT_DEC             = 1;
  const IATA_STICKER_LI_ION       = 2;
  const IATA_STICKER_LI_METAL     = 3;
  const IATA_STICKER_FORBIDDEN    = 4;
  const IATA_STICKER_CARGO_ONLY   = 5;
  const IATA_STICKER_HAZARD       = 6;

  // Human readable IATA classification names
  private static $iataClassNames = [
    000 => 'IATA None',
    111 => 'IATA 965 IA',
    112 => 'IATA 965 IB',
    113 => 'IATA 965 II',
    121 => 'IATA 966 I',
    122 => 'IATA 966 II',
    131 => 'IATA 967 I',
    132 => 'IATA 967 II',
    211 => 'IATA 968 IA',
    212 => 'IATA 968 IB',
    213 => 'IATA 968 II',
    221 => 'IATA 969 I',
    222 => 'IATA 969 II',
    231 => 'IATA 970 I',
    232 => 'IATA 970 II',
    555 => 'IATA Multiple',
    666 => 'IATA Illegal',
  ];

  // Li Ion Classes
  private $liIonClasses = [
    self::IATA_965_IA,
    self::IATA_965_IB,
    self::IATA_965_II,
    self::IATA_966_I,
    self::IATA_966_II,
    self::IATA_967_I,
    self::IATA_967_II,
  ];

  // Li Metal Classes
  private $liMetalClasses = [
    self::IATA_968_IA,
    self::IATA_968_IB,
    self::IATA_968_II,
    self::IATA_969_I,
    self::IATA_969_II,
    self::IATA_970_I,
    self::IATA_970_II,
  ];

  // Battery Only Classes
  private $batteryOnlyClasses = [
    self::IATA_965_IA,
    self::IATA_965_IB,
    self::IATA_965_II,
    self::IATA_968_IA,
    self::IATA_968_IB,
    self::IATA_968_II,
  ];

  // Battery Only Class 2 Classes
  private $batteryOnlyClassTwoClasses = [
    self::IATA_965_II,
    self::IATA_968_II,
  ];

  // Contained Classes
  private $containedClasses = [
    self::IATA_967_II,
    self::IATA_970_II,
  ];

  // Class 9 hazard classes
  private $hazardClasses = [
    self::IATA_965_IA,
    self::IATA_965_IB,
    self::IATA_966_I,
    self::IATA_967_I,
    self::IATA_968_IA,
    self::IATA_968_IB,
    self::IATA_969_I,
    self::IATA_970_I,
  ];

  // IATA package containing all line items
  private $iataPackage;

  // The calculated classification of this class
  private $iataClassification = null;

  // The labelling and documentation requirements of the package
  private $iataRequirements = [
    self::IATA_BATT_DEC            => false,
    self::IATA_STICKER_LI_ION      => false,
    self::IATA_STICKER_LI_METAL    => false,
    self::IATA_STICKER_FORBIDDEN   => false,
    self::IATA_STICKER_CARGO_ONLY  => false,
    self::IATA_STICKER_HAZARD      => false,
  ];

  public function __construct($package = null)
  {
    $this->iataPackage = $package instanceOf IataPackage ? $package : new IataPackage();
  }

  public static function make()
  {
    return new static;
  }

  public function addLineItem($lineItem)
  {
    $this->iataClassification = null;

    $this->iataPackage->addLineItem($lineItem);
    return $this;
  }

  public static function idToClassificationName($class)
  {
    if (array_key_exists($class, static::$iataClassNames))
      return static::$iataClassNames[$class];
  }

  public function getClassificationName()
  {
    $this->classify();
    return static::idToClassificationName($this->getClassification());
  }

  public function getClassification()
  {
    $this->classify();
    return $this->iataClassification;
  }

  public function getQValue($round = false)
  {
    $q = $this->iataPackage->calcQValue();

    if ($round)
      $q = round($q, $round);

    return $q;
  }

  private function classify()
  {
    if ($this->iataClassification === null) {
      $this->setInitialClassification();
      $this->setRequirements();
      $this->checkClassification();
      $this->checkRequirements();
    }

    return $this->iataClassification;
  }

  public function specialHandlingRequired()
  {
    $this->classify();

    if ($this->batteryDecRequired())
      return true;

    if ($this->stickerLiIonRequired())
      return true;

    if ($this->stickerLiMetalRequired())
      return true;

    if ($this->stickerForbiddenRequired())
      return true;

    if ($this->stickerCargoOnlyRequired())
      return true;

    if ($this->stickerHazardRequired())
      return true;

    return false;
  }

  private function setInitialClassification()
  {
    $p = $this->iataPackage;

    if (! $p->hasBatteries())
    {
      $this->iataClassification = self::IATA_NONE;
    }
    else if ($p->hasMultiplePackagingTypes())
    {
      $this->iataClassification = self::IATA_MULTIPLE;
    }
    else if ($p->hasMultipleChemistries())
    {
      $this->iataClassification = self::IATA_MULTIPLE;
    }
    else if ($p->hasMultipleSizes())
    {
      $this->iataClassification = self::IATA_MULTIPLE;
    }
    else
    {
      $this->iataClassification = $p->largestBattery()->iataClassification();
    }
  }

  private function checkClassification()
  {
    $p = $this->iataPackage;

    if ($this->isBatteryOnlyClassTwoClass()) {
      $cells     = $p->getTotalCells();
      $batteries = $p->getTotalBatteries();

      if ($p->hasSmallAndMediumBatteries())
      {
        $this->bumpClassTwoClassification();
      }
      else if ($p->hasSmallBattery() && $p->calcBatteryWeight() > IataBattery::Q_SM)
      {
        $this->bumpClassTwoClassification();
      }
      else if ($p->hasMediumBattery() && $cells != 0 && $batteries != 0)
      {
        $this->bumpClassTwoClassification();
      }
      else if ($p->hasMediumBattery() && $cells > IataBattery::Q_CELL_MED)
      {
        $this->bumpClassTwoClassification();
      }
      else if ($p->hasMediumBattery() && $batteries > IataBattery::Q_BATT_MED)
      {
        $this->bumpClassTwoClassification();
      }
    }
  }

  public function isRestrictedClass()
  {
    return $this->getClassification() != static::IATA_NONE;
  }

  private function setRequirements()
  {
    // All packages with batteries require a declaration
    if (! $this->iataClassification == self::IATA_NONE) {
      $this->setBatteryDecRequired();
    }

    // Set the appropriate sticker for chemistry
    if ($this->isLiIonClass()) {
      $this->setStickerLiIonRequired();
    } else if ($this->isLiMetalClass()) {
      $this->setStickerLimetalRequired();
    }

    // Lithium metal batteries on their own require additional stickers
    if ($this->isLiMetalOnlyClass()) {
      $this->setStickerForbiddenRequired();
      $this->setStickerCargoOnlyRequired();
    }

    // Large batteries require class 9 hazard stickers
    if ($this->isHazardClass()) {
      $this->setStickerHazardRequired();
    }
  }

  private function checkRequirements()
  {
    $p = $this->iataPackage;

    if ($this->isSmallContainedClass() &&
        $p->getTotalCells() <= 4 &&
        $p->getTotalBatteries() <= 2)
    {
      $this->resetRequirements();
    }
  }

  public function batteryDecRequired()
  {
    return $this->iataRequirements[self::IATA_BATT_DEC];
  }

  public function stickerLiIonRequired()
  {
    return $this->iataRequirements[self::IATA_STICKER_LI_ION];
  }

  public function stickerLiMetalRequired()
  {
    return $this->iataRequirements[self::IATA_STICKER_LI_METAL];
  }

  public function stickerForbiddenRequired()
  {
    return $this->iataRequirements[self::IATA_STICKER_FORBIDDEN];
  }

  public function stickerCargoOnlyRequired()
  {
    return $this->iataRequirements[self::IATA_STICKER_CARGO_ONLY];
  }

  public function stickerHazardRequired()
  {
    return $this->iataRequirements[self::IATA_STICKER_HAZARD];
  }

  private function setBatteryDecRequired($true = true)
  {
    $this->iataRequirements[self::IATA_BATT_DEC] = $true;
  }

  private function setStickerLiIonRequired($true = true)
  {
    $this->iataRequirements[self::IATA_STICKER_LI_ION] = $true;
  }

  private function setStickerliMetalRequired($true = true)
  {
    $this->iataRequirements[self::IATA_STICKER_LI_METAL] = $true;
  }

  private function setStickerForbiddenRequired($true = true)
  {
    $this->iataRequirements[self::IATA_STICKER_FORBIDDEN] = $true;
  }

  private function setStickerCargoOnlyRequired($true = true)
  {
    $this->iataRequirements[self::IATA_STICKER_CARGO_ONLY] = $true;
  }

  private function setStickerHazardRequired($true = true)
  {
    $this->iataRequirements[self::IATA_STICKER_HAZARD] = $true;
  }

  private function resetRequirements()
  {
    foreach ($this->iataRequirements as &$r)
      $r = false;
  }

  private function isLiIonClass()
  {
    return $this->isClassificationType($this->liIonClasses);
  }

  private function isLiMetalClass()
  {
    return $this->isClassificationType($this->liMetalClasses);
  }

  private function isBatteryOnlyClass()
  {
    return $this->isClassificationType($this->batteryOnlyClasses);
  }

  private function isBatteryOnlyClassTwoClass()
  {
    return $this->isClassificationType($this->batteryOnlyClassTwoClasses);
  }

  private function isHazardClass()
  {
    return $this->isClassificationType($this->hazardClasses);
  }

  private function isLiMetalOnlyClass()
  {
    return $this->isLiMetalClass() && $this->isBatteryOnlyClass() ? true : false;
  }

  private function isSmallContainedClass()
  {
    return $this->isClassificationType($this->containedClasses);
  }

  private function isClassificationType($type)
  {
    return in_array($this->classify(), $type) ? true : false;
  }

  private function bumpClassTwoClassification()
  {
    if ($this->iataClassification == self::IATA_965_II) {
      $this->iataClassification = self::IATA_965_IB;
      $this->setStickerHazardRequired();
    } else if ($this->iataClassification == self::IATA_968_II) {
      $this->iataClassification = self::IATA_968_IB;
      $this->setStickerHazardRequired();
    }
  }

}
