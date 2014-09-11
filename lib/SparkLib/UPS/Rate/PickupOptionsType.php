<?php

namespace SparkLib\UPS\Rate;

class PickupOptionsType
{

  /**
   * 
   * @var string $LiftGateAtPickupIndicator
   * @access public
   */
  public $LiftGateAtPickupIndicator = null;

  /**
   * 
   * @var string $HoldForPickupIndicator
   * @access public
   */
  public $HoldForPickupIndicator = null;

  /**
   * 
   * @param string $LiftGateAtPickupIndicator
   * @param string $HoldForPickupIndicator
   * @access public
   */
  public function __construct($LiftGateAtPickupIndicator = null, $HoldForPickupIndicator = null)
  {
    $this->LiftGateAtPickupIndicator = $LiftGateAtPickupIndicator;
    $this->HoldForPickupIndicator = $HoldForPickupIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getLiftGateAtPickupIndicator()
  {
    return $this->LiftGateAtPickupIndicator;
  }

  /**
   * 
   * @param string $LiftGateAtPickupIndicator
   */
  public function setLiftGateAtPickupIndicator($LiftGateAtPickupIndicator)
  {
    $this->LiftGateAtPickupIndicator = $LiftGateAtPickupIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getHoldForPickupIndicator()
  {
    return $this->HoldForPickupIndicator;
  }

  /**
   * 
   * @param string $HoldForPickupIndicator
   */
  public function setHoldForPickupIndicator($HoldForPickupIndicator)
  {
    $this->HoldForPickupIndicator = $HoldForPickupIndicator;
  }

}
