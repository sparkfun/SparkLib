<?php

namespace SparkLib\UPS\Rate;

class DeliveryOptionsType
{

  /**
   * 
   * @var string $LiftGateAtDeliveryIndicator
   * @access public
   */
  public $LiftGateAtDeliveryIndicator = null;

  /**
   * 
   * @var string $DropOffAtUPSFacilityIndicator
   * @access public
   */
  public $DropOffAtUPSFacilityIndicator = null;

  /**
   * 
   * @param string $LiftGateAtDeliveryIndicator
   * @param string $DropOffAtUPSFacilityIndicator
   * @access public
   */
  public function __construct($LiftGateAtDeliveryIndicator = null, $DropOffAtUPSFacilityIndicator = null)
  {
    $this->LiftGateAtDeliveryIndicator = $LiftGateAtDeliveryIndicator;
    $this->DropOffAtUPSFacilityIndicator = $DropOffAtUPSFacilityIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getLiftGateAtDeliveryIndicator()
  {
    return $this->LiftGateAtDeliveryIndicator;
  }

  /**
   * 
   * @param string $LiftGateAtDeliveryIndicator
   */
  public function setLiftGateAtDeliveryIndicator($LiftGateAtDeliveryIndicator)
  {
    $this->LiftGateAtDeliveryIndicator = $LiftGateAtDeliveryIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getDropOffAtUPSFacilityIndicator()
  {
    return $this->DropOffAtUPSFacilityIndicator;
  }

  /**
   * 
   * @param string $DropOffAtUPSFacilityIndicator
   */
  public function setDropOffAtUPSFacilityIndicator($DropOffAtUPSFacilityIndicator)
  {
    $this->DropOffAtUPSFacilityIndicator = $DropOffAtUPSFacilityIndicator;
  }

}
