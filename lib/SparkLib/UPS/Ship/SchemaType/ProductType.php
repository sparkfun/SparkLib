<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ProductType
{

  /**
   *
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   *
   * @var UnitType $Unit
   * @access public
   */
  public $Unit = null;

  /**
   *
   * @var string $CommodityCode
   * @access public
   */
  public $CommodityCode = null;

  /**
   *
   * @var string $PartNumber
   * @access public
   */
  public $PartNumber = null;

  /**
   *
   * @var string $OriginCountryCode
   * @access public
   */
  public $OriginCountryCode = null;

  /**
   *
   * @var string $JointProductionIndicator
   * @access public
   */
  public $JointProductionIndicator = null;

  /**
   *
   * @var string $NetCostCode
   * @access public
   */
  public $NetCostCode = null;

  /**
   *
   * @var NetCostDateType $NetCostDateRange
   * @access public
   */
  public $NetCostDateRange = null;

  /**
   *
   * @var string $PreferenceCriteria
   * @access public
   */
  public $PreferenceCriteria = null;

  /**
   *
   * @var string $ProducerInfo
   * @access public
   */
  public $ProducerInfo = null;

  /**
   *
   * @var string $MarksAndNumbers
   * @access public
   */
  public $MarksAndNumbers = null;

  /**
   *
   * @var string $NumberOfPackagesPerCommodity
   * @access public
   */
  public $NumberOfPackagesPerCommodity = null;

  /**
   *
   * @var ProductWeightType $ProductWeight
   * @access public
   */
  public $ProductWeight = null;

  /**
   *
   * @var string $VehicleID
   * @access public
   */
  public $VehicleID = null;

  /**
   *
   * @var ScheduleBType $ScheduleB
   * @access public
   */
  public $ScheduleB = null;

  /**
   *
   * @var string $ExportType
   * @access public
   */
  public $ExportType = null;

  /**
   *
   * @var string $SEDTotalValue
   * @access public
   */
  public $SEDTotalValue = null;

  /**
   *
   * @var ExcludeFromFormType $ExcludeFromForm
   * @access public
   */
  public $ExcludeFromForm = null;

  /**
   *
   * @var string $ProductCurrencyCode
   * @access public
   */
  public $ProductCurrencyCode = null;

  /**
   *
   * @var PackingListInfoType $PackingListInfo
   * @access public
   */
  public $PackingListInfo = null;

  /**
   *
   * @var EEIInformationType $EEIInformation
   * @access public
   */
  public $EEIInformation = null;

  /**
   *
   * @param string $Description
   * @param UnitType $Unit
   * @param string $CommodityCode
   * @param string $PartNumber
   * @param string $OriginCountryCode
   * @param string $JointProductionIndicator
   * @param string $NetCostCode
   * @param NetCostDateType $NetCostDateRange
   * @param string $PreferenceCriteria
   * @param string $ProducerInfo
   * @param string $MarksAndNumbers
   * @param string $NumberOfPackagesPerCommodity
   * @param ProductWeightType $ProductWeight
   * @param string $VehicleID
   * @param ScheduleBType $ScheduleB
   * @param string $ExportType
   * @param string $SEDTotalValue
   * @param ExcludeFromFormType $ExcludeFromForm
   * @param string $ProductCurrencyCode
   * @param PackingListInfoType $PackingListInfo
   * @param EEIInformationType $EEIInformation
   * @access public
   */
  public function __construct($Description = null, $Unit = null, $CommodityCode = null, $PartNumber = null, $OriginCountryCode = null, $JointProductionIndicator = null, $NetCostCode = null, $NetCostDateRange = null, $PreferenceCriteria = null, $ProducerInfo = null, $MarksAndNumbers = null, $NumberOfPackagesPerCommodity = null, $ProductWeight = null, $VehicleID = null, $ScheduleB = null, $ExportType = null, $SEDTotalValue = null, $ExcludeFromForm = null, $ProductCurrencyCode = null, $PackingListInfo = null, $EEIInformation = null)
  {
    $this->Description = $Description;
    $this->Unit = $Unit;
    $this->CommodityCode = $CommodityCode;
    $this->PartNumber = $PartNumber;
    $this->OriginCountryCode = $OriginCountryCode;
    $this->JointProductionIndicator = $JointProductionIndicator;
    $this->NetCostCode = $NetCostCode;
    $this->NetCostDateRange = $NetCostDateRange;
    $this->PreferenceCriteria = $PreferenceCriteria;
    $this->ProducerInfo = $ProducerInfo;
    $this->MarksAndNumbers = $MarksAndNumbers;
    $this->NumberOfPackagesPerCommodity = $NumberOfPackagesPerCommodity;
    $this->ProductWeight = $ProductWeight;
    $this->VehicleID = $VehicleID;
    $this->ScheduleB = $ScheduleB;
    $this->ExportType = $ExportType;
    $this->SEDTotalValue = $SEDTotalValue;
    $this->ExcludeFromForm = $ExcludeFromForm;
    $this->ProductCurrencyCode = $ProductCurrencyCode;
    $this->PackingListInfo = $PackingListInfo;
    $this->EEIInformation = $EEIInformation;
  }

  /**
   *
   * @return string
   */
  public function getDescription()
  {
    return $this->Description;
  }

  /**
   *
   * @param string $Description
   */
  public function setDescription($Description)
  {
    $this->Description = $Description;
  }

  /**
   *
   * @return UnitType
   */
  public function getUnit()
  {
    return $this->Unit;
  }

  /**
   *
   * @param UnitType $Unit
   */
  public function setUnit($Unit)
  {
    $this->Unit = $Unit;
  }

  /**
   *
   * @return string
   */
  public function getCommodityCode()
  {
    return $this->CommodityCode;
  }

  /**
   *
   * @param string $CommodityCode
   */
  public function setCommodityCode($CommodityCode)
  {
    $this->CommodityCode = $CommodityCode;
  }

  /**
   *
   * @return string
   */
  public function getPartNumber()
  {
    return $this->PartNumber;
  }

  /**
   *
   * @param string $PartNumber
   */
  public function setPartNumber($PartNumber)
  {
    $this->PartNumber = $PartNumber;
  }

  /**
   *
   * @return string
   */
  public function getOriginCountryCode()
  {
    return $this->OriginCountryCode;
  }

  /**
   *
   * @param string $OriginCountryCode
   */
  public function setOriginCountryCode($OriginCountryCode)
  {
    $this->OriginCountryCode = $OriginCountryCode;
  }

  /**
   *
   * @return string
   */
  public function getJointProductionIndicator()
  {
    return $this->JointProductionIndicator;
  }

  /**
   *
   * @param string $JointProductionIndicator
   */
  public function setJointProductionIndicator($JointProductionIndicator)
  {
    $this->JointProductionIndicator = $JointProductionIndicator;
  }

  /**
   *
   * @return string
   */
  public function getNetCostCode()
  {
    return $this->NetCostCode;
  }

  /**
   *
   * @param string $NetCostCode
   */
  public function setNetCostCode($NetCostCode)
  {
    $this->NetCostCode = $NetCostCode;
  }

  /**
   *
   * @return NetCostDateType
   */
  public function getNetCostDateRange()
  {
    return $this->NetCostDateRange;
  }

  /**
   *
   * @param NetCostDateType $NetCostDateRange
   */
  public function setNetCostDateRange($NetCostDateRange)
  {
    $this->NetCostDateRange = $NetCostDateRange;
  }

  /**
   *
   * @return string
   */
  public function getPreferenceCriteria()
  {
    return $this->PreferenceCriteria;
  }

  /**
   *
   * @param string $PreferenceCriteria
   */
  public function setPreferenceCriteria($PreferenceCriteria)
  {
    $this->PreferenceCriteria = $PreferenceCriteria;
  }

  /**
   *
   * @return string
   */
  public function getProducerInfo()
  {
    return $this->ProducerInfo;
  }

  /**
   *
   * @param string $ProducerInfo
   */
  public function setProducerInfo($ProducerInfo)
  {
    $this->ProducerInfo = $ProducerInfo;
  }

  /**
   *
   * @return string
   */
  public function getMarksAndNumbers()
  {
    return $this->MarksAndNumbers;
  }

  /**
   *
   * @param string $MarksAndNumbers
   */
  public function setMarksAndNumbers($MarksAndNumbers)
  {
    $this->MarksAndNumbers = $MarksAndNumbers;
  }

  /**
   *
   * @return string
   */
  public function getNumberOfPackagesPerCommodity()
  {
    return $this->NumberOfPackagesPerCommodity;
  }

  /**
   *
   * @param string $NumberOfPackagesPerCommodity
   */
  public function setNumberOfPackagesPerCommodity($NumberOfPackagesPerCommodity)
  {
    $this->NumberOfPackagesPerCommodity = $NumberOfPackagesPerCommodity;
  }

  /**
   *
   * @return ProductWeightType
   */
  public function getProductWeight()
  {
    return $this->ProductWeight;
  }

  /**
   *
   * @param ProductWeightType $ProductWeight
   */
  public function setProductWeight($ProductWeight)
  {
    $this->ProductWeight = $ProductWeight;
  }

  /**
   *
   * @return string
   */
  public function getVehicleID()
  {
    return $this->VehicleID;
  }

  /**
   *
   * @param string $VehicleID
   */
  public function setVehicleID($VehicleID)
  {
    $this->VehicleID = $VehicleID;
  }

  /**
   *
   * @return ScheduleBType
   */
  public function getScheduleB()
  {
    return $this->ScheduleB;
  }

  /**
   *
   * @param ScheduleBType $ScheduleB
   */
  public function setScheduleB($ScheduleB)
  {
    $this->ScheduleB = $ScheduleB;
  }

  /**
   *
   * @return string
   */
  public function getExportType()
  {
    return $this->ExportType;
  }

  /**
   *
   * @param string $ExportType
   */
  public function setExportType($ExportType)
  {
    $this->ExportType = $ExportType;
  }

  /**
   *
   * @return string
   */
  public function getSEDTotalValue()
  {
    return $this->SEDTotalValue;
  }

  /**
   *
   * @param string $SEDTotalValue
   */
  public function setSEDTotalValue($SEDTotalValue)
  {
    $this->SEDTotalValue = $SEDTotalValue;
  }

  /**
   *
   * @return ExcludeFromFormType
   */
  public function getExcludeFromForm()
  {
    return $this->ExcludeFromForm;
  }

  /**
   *
   * @param ExcludeFromFormType $ExcludeFromForm
   */
  public function setExcludeFromForm($ExcludeFromForm)
  {
    $this->ExcludeFromForm = $ExcludeFromForm;
  }

  /**
   *
   * @return string
   */
  public function getProductCurrencyCode()
  {
    return $this->ProductCurrencyCode;
  }

  /**
   *
   * @param string $ProductCurrencyCode
   */
  public function setProductCurrencyCode($ProductCurrencyCode)
  {
    $this->ProductCurrencyCode = $ProductCurrencyCode;
  }

  /**
   *
   * @return PackingListInfoType
   */
  public function getPackingListInfo()
  {
    return $this->PackingListInfo;
  }

  /**
   *
   * @param PackingListInfoType $PackingListInfo
   */
  public function setPackingListInfo($PackingListInfo)
  {
    $this->PackingListInfo = $PackingListInfo;
  }

  /**
   *
   * @return EEIInformationType
   */
  public function getEEIInformation()
  {
    return $this->EEIInformation;
  }

  /**
   *
   * @param EEIInformationType $EEIInformation
   */
  public function setEEIInformation($EEIInformation)
  {
    $this->EEIInformation = $EEIInformation;
  }

}
