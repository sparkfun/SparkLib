<?php

namespace SparkLib\UPS\Ship;

class PackageType
{

  /**
   * 
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   * 
   * @var PackagingType $Packaging
   * @access public
   */
  public $Packaging = null;

  /**
   * 
   * @var DimensionsType $Dimensions
   * @access public
   */
  public $Dimensions = null;

  /**
   * 
   * @var PackageWeightType $PackageWeight
   * @access public
   */
  public $PackageWeight = null;

  /**
   * 
   * @var string $LargePackageIndicator
   * @access public
   */
  public $LargePackageIndicator = null;

  /**
   * 
   * @var ReferenceNumberType $ReferenceNumber
   * @access public
   */
  public $ReferenceNumber = null;

  /**
   * 
   * @var string $AdditionalHandlingIndicator
   * @access public
   */
  public $AdditionalHandlingIndicator = null;

  /**
   * 
   * @var PackageServiceOptionsType $PackageServiceOptions
   * @access public
   */
  public $PackageServiceOptions = null;

  /**
   * 
   * @var CommodityType $Commodity
   * @access public
   */
  public $Commodity = null;

  /**
   * 
   * @param string $Description
   * @param PackagingType $Packaging
   * @param DimensionsType $Dimensions
   * @param PackageWeightType $PackageWeight
   * @param string $LargePackageIndicator
   * @param ReferenceNumberType $ReferenceNumber
   * @param string $AdditionalHandlingIndicator
   * @param PackageServiceOptionsType $PackageServiceOptions
   * @param CommodityType $Commodity
   * @access public
   */
  public function __construct($Description = null, $Packaging = null, $Dimensions = null, $PackageWeight = null, $LargePackageIndicator = null, $ReferenceNumber = null, $AdditionalHandlingIndicator = null, $PackageServiceOptions = null, $Commodity = null)
  {
    $this->Description = $Description;
    $this->Packaging = $Packaging;
    $this->Dimensions = $Dimensions;
    $this->PackageWeight = $PackageWeight;
    $this->LargePackageIndicator = $LargePackageIndicator;
    $this->ReferenceNumber = $ReferenceNumber;
    $this->AdditionalHandlingIndicator = $AdditionalHandlingIndicator;
    $this->PackageServiceOptions = $PackageServiceOptions;
    $this->Commodity = $Commodity;
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
   * @return PackagingType
   */
  public function getPackaging()
  {
    return $this->Packaging;
  }

  /**
   * 
   * @param PackagingType $Packaging
   */
  public function setPackaging($Packaging)
  {
    $this->Packaging = $Packaging;
  }

  /**
   * 
   * @return DimensionsType
   */
  public function getDimensions()
  {
    return $this->Dimensions;
  }

  /**
   * 
   * @param DimensionsType $Dimensions
   */
  public function setDimensions($Dimensions)
  {
    $this->Dimensions = $Dimensions;
  }

  /**
   * 
   * @return PackageWeightType
   */
  public function getPackageWeight()
  {
    return $this->PackageWeight;
  }

  /**
   * 
   * @param PackageWeightType $PackageWeight
   */
  public function setPackageWeight($PackageWeight)
  {
    $this->PackageWeight = $PackageWeight;
  }

  /**
   * 
   * @return string
   */
  public function getLargePackageIndicator()
  {
    return $this->LargePackageIndicator;
  }

  /**
   * 
   * @param string $LargePackageIndicator
   */
  public function setLargePackageIndicator($LargePackageIndicator)
  {
    $this->LargePackageIndicator = $LargePackageIndicator;
  }

  /**
   * 
   * @return ReferenceNumberType
   */
  public function getReferenceNumber()
  {
    return $this->ReferenceNumber;
  }

  /**
   * 
   * @param ReferenceNumberType $ReferenceNumber
   */
  public function setReferenceNumber($ReferenceNumber)
  {
    $this->ReferenceNumber = $ReferenceNumber;
  }

  /**
   * 
   * @return string
   */
  public function getAdditionalHandlingIndicator()
  {
    return $this->AdditionalHandlingIndicator;
  }

  /**
   * 
   * @param string $AdditionalHandlingIndicator
   */
  public function setAdditionalHandlingIndicator($AdditionalHandlingIndicator)
  {
    $this->AdditionalHandlingIndicator = $AdditionalHandlingIndicator;
  }

  /**
   * 
   * @return PackageServiceOptionsType
   */
  public function getPackageServiceOptions()
  {
    return $this->PackageServiceOptions;
  }

  /**
   * 
   * @param PackageServiceOptionsType $PackageServiceOptions
   */
  public function setPackageServiceOptions($PackageServiceOptions)
  {
    $this->PackageServiceOptions = $PackageServiceOptions;
  }

  /**
   * 
   * @return CommodityType
   */
  public function getCommodity()
  {
    return $this->Commodity;
  }

  /**
   * 
   * @param CommodityType $Commodity
   */
  public function setCommodity($Commodity)
  {
    $this->Commodity = $Commodity;
  }

}
