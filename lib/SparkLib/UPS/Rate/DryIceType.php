<?php

namespace SparkLib\UPS\Rate;

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
   * @var string $AuditRequired
   * @access public
   */
  public $AuditRequired = null;

  /**
   * 
   * @param string $RegulationSet
   * @param DryIceWeightType $DryIceWeight
   * @param string $MedicalUseIndicator
   * @param string $AuditRequired
   * @access public
   */
  public function __construct($RegulationSet = null, $DryIceWeight = null, $MedicalUseIndicator = null, $AuditRequired = null)
  {
    $this->RegulationSet = $RegulationSet;
    $this->DryIceWeight = $DryIceWeight;
    $this->MedicalUseIndicator = $MedicalUseIndicator;
    $this->AuditRequired = $AuditRequired;
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

  /**
   * 
   * @return string
   */
  public function getAuditRequired()
  {
    return $this->AuditRequired;
  }

  /**
   * 
   * @param string $AuditRequired
   */
  public function setAuditRequired($AuditRequired)
  {
    $this->AuditRequired = $AuditRequired;
  }

}
