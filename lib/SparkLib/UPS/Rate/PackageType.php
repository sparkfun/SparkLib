<?php

namespace SparkLib\UPS\Rate;

class PackageType
{

  /**
   * 
   * @var CodeDescriptionType $PackagingType
   * @access public
   */
  public $PackagingType = null;

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
   * @var CommodityType $Commodity
   * @access public
   */
  public $Commodity = null;

  /**
   * 
   * @var string $LargePackageIndicator
   * @access public
   */
  public $LargePackageIndicator = null;

  /**
   * 
   * @var PackageServiceOptionsType $PackageServiceOptions
   * @access public
   */
  public $PackageServiceOptions = null;

  /**
   * 
   * @var string $AdditionalHandlingIndicator
   * @access public
   */
  public $AdditionalHandlingIndicator = null;

  /**
   * 
   * @param CodeDescriptionType $PackagingType
   * @param DimensionsType $Dimensions
   * @param PackageWeightType $PackageWeight
   * @param CommodityType $Commodity
   * @param string $LargePackageIndicator
   * @param PackageServiceOptionsType $PackageServiceOptions
   * @param string $AdditionalHandlingIndicator
   * @access public
   */
  public function __construct($PackagingType = null, $Dimensions = null, $PackageWeight = null, $Commodity = null, $LargePackageIndicator = null, $PackageServiceOptions = null, $AdditionalHandlingIndicator = null)
  {
    $this->PackagingType = $PackagingType;
    $this->Dimensions = $Dimensions;
    $this->PackageWeight = $PackageWeight;
    $this->Commodity = $Commodity;
    $this->LargePackageIndicator = $LargePackageIndicator;
    $this->PackageServiceOptions = $PackageServiceOptions;
    $this->AdditionalHandlingIndicator = $AdditionalHandlingIndicator;
  }

  /**
   * 
   * @return CodeDescriptionType
   */
  public function getPackagingType()
  {
    return $this->PackagingType;
  }

  /**
   * 
   * @param CodeDescriptionType $PackagingType
   */
  public function setPackagingType($PackagingType)
  {
    $this->PackagingType = $PackagingType;
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

}
