<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class DDTCInformationType
{

  /**
   *
   * @var string $ITARExemptionNumber
   * @access public
   */
  public $ITARExemptionNumber = null;

  /**
   *
   * @var string $USMLCategoryCode
   * @access public
   */
  public $USMLCategoryCode = null;

  /**
   *
   * @var string $EligiblePartyIndicator
   * @access public
   */
  public $EligiblePartyIndicator = null;

  /**
   *
   * @var string $RegistrationNumber
   * @access public
   */
  public $RegistrationNumber = null;

  /**
   *
   * @var string $Quantity
   * @access public
   */
  public $Quantity = null;

  /**
   *
   * @var UnitOfMeasurementType $UnitOfMeasurement
   * @access public
   */
  public $UnitOfMeasurement = null;

  /**
   *
   * @var string $SignificantMilitaryEquipmentIndicator
   * @access public
   */
  public $SignificantMilitaryEquipmentIndicator = null;

  /**
   *
   * @var string $ACMNumber
   * @access public
   */
  public $ACMNumber = null;

  /**
   *
   * @param string $ITARExemptionNumber
   * @param string $USMLCategoryCode
   * @param string $EligiblePartyIndicator
   * @param string $RegistrationNumber
   * @param string $Quantity
   * @param UnitOfMeasurementType $UnitOfMeasurement
   * @param string $SignificantMilitaryEquipmentIndicator
   * @param string $ACMNumber
   * @access public
   */
  public function __construct($ITARExemptionNumber = null, $USMLCategoryCode = null, $EligiblePartyIndicator = null, $RegistrationNumber = null, $Quantity = null, $UnitOfMeasurement = null, $SignificantMilitaryEquipmentIndicator = null, $ACMNumber = null)
  {
    $this->ITARExemptionNumber = $ITARExemptionNumber;
    $this->USMLCategoryCode = $USMLCategoryCode;
    $this->EligiblePartyIndicator = $EligiblePartyIndicator;
    $this->RegistrationNumber = $RegistrationNumber;
    $this->Quantity = $Quantity;
    $this->UnitOfMeasurement = $UnitOfMeasurement;
    $this->SignificantMilitaryEquipmentIndicator = $SignificantMilitaryEquipmentIndicator;
    $this->ACMNumber = $ACMNumber;
  }

  /**
   *
   * @return string
   */
  public function getITARExemptionNumber()
  {
    return $this->ITARExemptionNumber;
  }

  /**
   *
   * @param string $ITARExemptionNumber
   */
  public function setITARExemptionNumber($ITARExemptionNumber)
  {
    $this->ITARExemptionNumber = $ITARExemptionNumber;
  }

  /**
   *
   * @return string
   */
  public function getUSMLCategoryCode()
  {
    return $this->USMLCategoryCode;
  }

  /**
   *
   * @param string $USMLCategoryCode
   */
  public function setUSMLCategoryCode($USMLCategoryCode)
  {
    $this->USMLCategoryCode = $USMLCategoryCode;
  }

  /**
   *
   * @return string
   */
  public function getEligiblePartyIndicator()
  {
    return $this->EligiblePartyIndicator;
  }

  /**
   *
   * @param string $EligiblePartyIndicator
   */
  public function setEligiblePartyIndicator($EligiblePartyIndicator)
  {
    $this->EligiblePartyIndicator = $EligiblePartyIndicator;
  }

  /**
   *
   * @return string
   */
  public function getRegistrationNumber()
  {
    return $this->RegistrationNumber;
  }

  /**
   *
   * @param string $RegistrationNumber
   */
  public function setRegistrationNumber($RegistrationNumber)
  {
    $this->RegistrationNumber = $RegistrationNumber;
  }

  /**
   *
   * @return string
   */
  public function getQuantity()
  {
    return $this->Quantity;
  }

  /**
   *
   * @param string $Quantity
   */
  public function setQuantity($Quantity)
  {
    $this->Quantity = $Quantity;
  }

  /**
   *
   * @return UnitOfMeasurementType
   */
  public function getUnitOfMeasurement()
  {
    return $this->UnitOfMeasurement;
  }

  /**
   *
   * @param UnitOfMeasurementType $UnitOfMeasurement
   */
  public function setUnitOfMeasurement($UnitOfMeasurement)
  {
    $this->UnitOfMeasurement = $UnitOfMeasurement;
  }

  /**
   *
   * @return string
   */
  public function getSignificantMilitaryEquipmentIndicator()
  {
    return $this->SignificantMilitaryEquipmentIndicator;
  }

  /**
   *
   * @param string $SignificantMilitaryEquipmentIndicator
   */
  public function setSignificantMilitaryEquipmentIndicator($SignificantMilitaryEquipmentIndicator)
  {
    $this->SignificantMilitaryEquipmentIndicator = $SignificantMilitaryEquipmentIndicator;
  }

  /**
   *
   * @return string
   */
  public function getACMNumber()
  {
    return $this->ACMNumber;
  }

  /**
   *
   * @param string $ACMNumber
   */
  public function setACMNumber($ACMNumber)
  {
    $this->ACMNumber = $ACMNumber;
  }

}
