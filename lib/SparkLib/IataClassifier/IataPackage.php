<?php

namespace SparkLib\IataClassifier;

use \SparkLib\IataClassifier\IataBattery;
use \SparkLib\IataClassifier\IataLineItem;

class IataPackage {

  protected $lineItems = [];

  protected $length;
  protected $width;
  protected $height;

  public function __construct ($dims = null)
  {
    if ($dims !== null) {
      if (isset($dims['length']) && isset($dims['width']) && isset($dims['height'])) {
        $this->setLength($dims['length']);
        $this->setWidth($dims['width']);
        $this->setHeight($dims['height']);
      } else {
        throw new Exception('When setting package dimensions, all dimensions must be set.');
      }
    }
  }

  public static function create($dims = null) {
    return new static($dims);
  }

  public function setLength($length)
  {
    if (! is_numeric($length) || $length < 0)
      throw new Exception('Invalid package length.');
    $this->length = $length;

    return $this;
  }

  public function setWidth($width)
  {
    if (! is_numeric($width) || $width < 0)
      throw new Exception('Invalid package width.');
    $this->width = $width;

    return $this;
  }

  public function setHeight($height)
  {
    if (! is_numeric($height) || $height < 0)
      throw new Exception('Invalid package height.');
    $this->height = $height;

    return $this;
  }

  public function resetLineItems()
  {
    $this->lineItems = [];
  }

  public function addLineItem($lineItem)
  {
    if (! is_array($lineItem))
      $lineItem = [ $lineItem ];

    foreach ($lineItem as $i) {
      if (! $i instanceOf IataLineItem)
        throw new Exception('Line item must be an instance of IataLineItem.');

      $this->lineItems[] = $i;
    }

    return $this;
  }

  public function calcTotalWeight()
  {
    $weight = 0;

    foreach ($this->lineItems as $i)
      $weight += $i->getQty() * $i->getWeight();

    return $weight;
  }

  public function getPackagingTypes()
  {
    $packagingTypes = [];

    foreach ($this->lineItems as $i)
      if ($i->hasBattery() && ! in_array($i->getBattery()->getPackaging(), $packagingTypes))
        $packagingTypes[] = $i->getBattery()->getPackaging();

    return $packagingTypes;
  }

  public function hasMultiplePackagingTypes()
  {
    return count($this->getPackagingTypes()) > 1 ? true : false;
  }

  public function calcBatteryWeight()
  {
    $weight = 0;

    foreach ($this->lineItems as $i)
      if ($i->hasBattery())
        $weight += $i->getQty() * $i->getBattery()->getWeight();

    return $weight;
  }

  public function calcQValue()
  {
    $qValue = 0;

    foreach ($this->lineItems as $i)
      if ($i->hasBattery())
        $qValue += $i->getQty() * $i->getBattery()->qValue();

    return $qValue;
  }

  public function getBatteries()
  {
    $batteries = [];

    foreach ($this->lineItems as $i)
      if ($i->hasBattery())
        $batteries[] = $i->hasBattery();

    return $batteries;
  }

  public function hasBatteries()
  {
    return count($this->getBatteries()) > 0 ? true : false;
  }

  public function batteriesOnly()
  {
    $onePackagingType = ! $this->hasMultiplePackagingTypes();
    $batteriesOnly    = in_array(IataBattery::BATTERY_ONLY, $this->getPackagingTypes());

    return ($onePackagingType && $batteriesOnly) ? true : false;
  }

  public function getTotalBatteries()
  {
    $batteries = 0;

    foreach ($this->lineItems as $li) {
      if ($li->hasBattery() && $li->getBattery()->isBattery()){
        $batteries += $li->getQty();
      }
    }

    return $batteries;
  }

  public function getTotalCells()
  {
    $cells = 0;

    foreach ($this->lineItems as $li) {
      if ($li->hasBattery() && $li->getBattery()->isCell()){
        $cells += $li->getQty();
      }
    }

    return $cells;
  }

  public function getSizes()
  {
    $sizes = [];

    foreach ($this->lineItems as $i)
      if ($i->hasBattery())
        if (! in_array($i->getBattery()->iataSize(), $sizes))
          $sizes[] = $i->getBattery()->iataSize();

    return $sizes;
  }

  public function hasSmallBattery()
  {
    return in_array(IataBattery::SMALL, $this->getSizes());
  }

  public function hasMediumBattery()
  {
    return in_array(IataBattery::MEDIUM, $this->getSizes());
  }

  public function hasSmallAndMediumBatteries()
  {
    return $this->hasSmallBattery() && $this->hasMediumBattery();
  }

  public function hasMultipleSizes()
  {
    if ($this->hasSmallBattery())
      $size_qty = count($this->getSizes()) - 1;
    else
      $size_qty = count($this->getSizes());

    return $size_qty > 1 ? true : false;
  }

  public function hasMultipleChemistries()
  {
    $chemistries = [];

    foreach ($this->lineItems as $i)
      if ($i->hasBattery())
        if (! in_array($i->getBattery()->getChemistry(), $chemistries))
          $chemistries[] = $i->getBattery()->getChemistry();

    return count($chemistries) > 1 ? true : false;
  }

  public function largestBattery()
  {
    $largest = null;

    foreach ($this->lineItems as $i) {
      if ($i->hasBattery()) {
        if (! $largest instanceOf iataBattery) {
          $largest = $i->getBattery();
        } else if ($i->getBattery()->iataSize() > $largest->iataSize()) {
          $largest = $i->getBattery();
        }
      }
    }

    return $largest;
  }
}
