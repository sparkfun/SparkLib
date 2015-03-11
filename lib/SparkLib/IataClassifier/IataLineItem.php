<?php

namespace SparkLib\IataClassifier;

use \Exception;

use \SparkLib\IataClassifier\IataBattery;

class IataLineItem {

  private $qty;
  private $weight;
  private $battery;
  private $name;

  public function __construct($qty, $weight = null, $battery = null, $name = null) {
    $this->setQty($qty);

    if ($weight)  $this->setWeight($weight);
    if ($battery) $this->setBattery($battery);
    if ($name)    $this->setName($name);
  }

  public static function qty($qty) {
    return new static($qty);
  }

  public function setQty($qty)
  {
    if (! is_integer($qty) || $qty < 0)
      throw new Exception('Invalid line item quantity.');
    $this->qty = $qty;

    return $this;
  }

  public function setWeight($weight)
  {
    if (! is_numeric($weight) || $weight < 0)
      throw new Exception('Invalid line item weight.');
    $this->weight = $weight;

    return $this;
  }

  public function setBattery($battery)
  {
    if ($battery && ! $battery instanceOf IataBattery)
      throw new Exception ('Battery, if included, must be instance of IataBattery.');
    $this->battery = $battery;

    return $this;
  }

  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  public function getQty()
  {
    return $this->qty;
  }

  public function getWeight()
  {
    return $this->weight;
  }

  public function getBattery()
  {
    return $this->battery;
  }

  public function getName()
  {
    return $this->name;
  }

  public function hasRealBattery()
  {
    return $this->battery instanceOf IataBattery;
  }

  public function hasBattery()
  {
    return $this->hasRealBattery() && ! $this->battery->isExempt();
  }
}
