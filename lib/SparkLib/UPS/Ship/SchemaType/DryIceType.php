<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class DryIceType
{

  /**
   *
   * @var string $RegulationSet
   * @access public
   */
  public $RegulationSet = null;

  /**
   *
   * @var DryIceWeightType $DryIceWeight
   * @access public
   */
  public $DryIceWeight = null;

  /**
   *
   * @var string $MedicalUseIndicator
   * @access public
   */
  public $MedicalUseIndicator = null;

  /**
   *
   * @param string $RegulationSet
   * @param DryIceWeightType $DryIceWeight
   * @param string $MedicalUseIndicator
   * @access public
   */
  public function __construct($RegulationSet = null, $DryIceWeight = null, $MedicalUseIndicator = null)
  {
    $this->RegulationSet = $RegulationSet;
    $this->DryIceWeight = $DryIceWeight;
    $this->MedicalUseIndicator = $MedicalUseIndicator;
  }

  /**
   *
   * @return string
   */
  public function getRegulationSet()
  {
    return $this->RegulationSet;
  }

  /**
   *
   * @param string $RegulationSet
   */
  public function setRegulationSet($RegulationSet)
  {
    $this->RegulationSet = $RegulationSet;
  }

  /**
   *
   * @return DryIceWeightType
   */
  public function getDryIceWeight()
  {
    return $this->DryIceWeight;
  }

  /**
   *
   * @param DryIceWeightType $DryIceWeight
   */
  public function setDryIceWeight($DryIceWeight)
  {
    $this->DryIceWeight = $DryIceWeight;
  }

  /**
   *
   * @return string
   */
  public function getMedicalUseIndicator()
  {
    return $this->MedicalUseIndicator;
  }

  /**
   *
   * @param string $MedicalUseIndicator
   */
  public function setMedicalUseIndicator($MedicalUseIndicator)
  {
    $this->MedicalUseIndicator = $MedicalUseIndicator;
  }

}
