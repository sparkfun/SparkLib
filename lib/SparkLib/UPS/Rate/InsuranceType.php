<?php

namespace SparkLib\UPS\Rate;

class InsuranceType
{

  /**
   * 
   * @var InsuranceValueType $BasicFlexibleParcelIndicator
   * @access public
   */
  public $BasicFlexibleParcelIndicator = null;

  /**
   * 
   * @var InsuranceValueType $ExtendedFlexibleParcelIndicator
   * @access public
   */
  public $ExtendedFlexibleParcelIndicator = null;

  /**
   * 
   * @var InsuranceValueType $TimeInTransitFlexibleParcelIndicator
   * @access public
   */
  public $TimeInTransitFlexibleParcelIndicator = null;

  /**
   * 
   * @param InsuranceValueType $BasicFlexibleParcelIndicator
   * @param InsuranceValueType $ExtendedFlexibleParcelIndicator
   * @param InsuranceValueType $TimeInTransitFlexibleParcelIndicator
   * @access public
   */
  public function __construct($BasicFlexibleParcelIndicator = null, $ExtendedFlexibleParcelIndicator = null, $TimeInTransitFlexibleParcelIndicator = null)
  {
    $this->BasicFlexibleParcelIndicator = $BasicFlexibleParcelIndicator;
    $this->ExtendedFlexibleParcelIndicator = $ExtendedFlexibleParcelIndicator;
    $this->TimeInTransitFlexibleParcelIndicator = $TimeInTransitFlexibleParcelIndicator;
  }

  /**
   * 
   * @return InsuranceValueType
   */
  public function getBasicFlexibleParcelIndicator()
  {
    return $this->BasicFlexibleParcelIndicator;
  }

  /**
   * 
   * @param InsuranceValueType $BasicFlexibleParcelIndicator
   */
  public function setBasicFlexibleParcelIndicator($BasicFlexibleParcelIndicator)
  {
    $this->BasicFlexibleParcelIndicator = $BasicFlexibleParcelIndicator;
  }

  /**
   * 
   * @return InsuranceValueType
   */
  public function getExtendedFlexibleParcelIndicator()
  {
    return $this->ExtendedFlexibleParcelIndicator;
  }

  /**
   * 
   * @param InsuranceValueType $ExtendedFlexibleParcelIndicator
   */
  public function setExtendedFlexibleParcelIndicator($ExtendedFlexibleParcelIndicator)
  {
    $this->ExtendedFlexibleParcelIndicator = $ExtendedFlexibleParcelIndicator;
  }

  /**
   * 
   * @return InsuranceValueType
   */
  public function getTimeInTransitFlexibleParcelIndicator()
  {
    return $this->TimeInTransitFlexibleParcelIndicator;
  }

  /**
   * 
   * @param InsuranceValueType $TimeInTransitFlexibleParcelIndicator
   */
  public function setTimeInTransitFlexibleParcelIndicator($TimeInTransitFlexibleParcelIndicator)
  {
    $this->TimeInTransitFlexibleParcelIndicator = $TimeInTransitFlexibleParcelIndicator;
  }

}
