<?php

namespace SparkLib\UPS\Ship;

class UPSPremiumCareFormType
{

  /**
   * 
   * @var string $ShipmentDate
   * @access public
   */
  public $ShipmentDate = null;

  /**
   * 
   * @var string $PageSize
   * @access public
   */
  public $PageSize = null;

  /**
   * 
   * @var string $PrintType
   * @access public
   */
  public $PrintType = null;

  /**
   * 
   * @var string $NumOfCopies
   * @access public
   */
  public $NumOfCopies = null;

  /**
   * 
   * @var LanguageForUPSPremiumCareType $LanguageForUPSPremiumCare
   * @access public
   */
  public $LanguageForUPSPremiumCare = null;

  /**
   * 
   * @param string $ShipmentDate
   * @param string $PageSize
   * @param string $PrintType
   * @param string $NumOfCopies
   * @param LanguageForUPSPremiumCareType $LanguageForUPSPremiumCare
   * @access public
   */
  public function __construct($ShipmentDate = null, $PageSize = null, $PrintType = null, $NumOfCopies = null, $LanguageForUPSPremiumCare = null)
  {
    $this->ShipmentDate = $ShipmentDate;
    $this->PageSize = $PageSize;
    $this->PrintType = $PrintType;
    $this->NumOfCopies = $NumOfCopies;
    $this->LanguageForUPSPremiumCare = $LanguageForUPSPremiumCare;
  }

  /**
   * 
   * @return string
   */
  public function getShipmentDate()
  {
    return $this->ShipmentDate;
  }

  /**
   * 
   * @param string $ShipmentDate
   */
  public function setShipmentDate($ShipmentDate)
  {
    $this->ShipmentDate = $ShipmentDate;
  }

  /**
   * 
   * @return string
   */
  public function getPageSize()
  {
    return $this->PageSize;
  }

  /**
   * 
   * @param string $PageSize
   */
  public function setPageSize($PageSize)
  {
    $this->PageSize = $PageSize;
  }

  /**
   * 
   * @return string
   */
  public function getPrintType()
  {
    return $this->PrintType;
  }

  /**
   * 
   * @param string $PrintType
   */
  public function setPrintType($PrintType)
  {
    $this->PrintType = $PrintType;
  }

  /**
   * 
   * @return string
   */
  public function getNumOfCopies()
  {
    return $this->NumOfCopies;
  }

  /**
   * 
   * @param string $NumOfCopies
   */
  public function setNumOfCopies($NumOfCopies)
  {
    $this->NumOfCopies = $NumOfCopies;
  }

  /**
   * 
   * @return LanguageForUPSPremiumCareType
   */
  public function getLanguageForUPSPremiumCare()
  {
    return $this->LanguageForUPSPremiumCare;
  }

  /**
   * 
   * @param LanguageForUPSPremiumCareType $LanguageForUPSPremiumCare
   */
  public function setLanguageForUPSPremiumCare($LanguageForUPSPremiumCare)
  {
    $this->LanguageForUPSPremiumCare = $LanguageForUPSPremiumCare;
  }

}
