<?php

namespace SparkLib\UPS\Ship;

class EEIInformationType
{

  /**
   * 
   * @var string $ExportInformation
   * @access public
   */
  public $ExportInformation = null;

  /**
   * 
   * @var EEILicenseType $License
   * @access public
   */
  public $License = null;

  /**
   * 
   * @var DDTCInformationType $DDTCInformation
   * @access public
   */
  public $DDTCInformation = null;

  /**
   * 
   * @param string $ExportInformation
   * @param EEILicenseType $License
   * @param DDTCInformationType $DDTCInformation
   * @access public
   */
  public function __construct($ExportInformation = null, $License = null, $DDTCInformation = null)
  {
    $this->ExportInformation = $ExportInformation;
    $this->License = $License;
    $this->DDTCInformation = $DDTCInformation;
  }

  /**
   * 
   * @return string
   */
  public function getExportInformation()
  {
    return $this->ExportInformation;
  }

  /**
   * 
   * @param string $ExportInformation
   */
  public function setExportInformation($ExportInformation)
  {
    $this->ExportInformation = $ExportInformation;
  }

  /**
   * 
   * @return EEILicenseType
   */
  public function getLicense()
  {
    return $this->License;
  }

  /**
   * 
   * @param EEILicenseType $License
   */
  public function setLicense($License)
  {
    $this->License = $License;
  }

  /**
   * 
   * @return DDTCInformationType
   */
  public function getDDTCInformation()
  {
    return $this->DDTCInformation;
  }

  /**
   * 
   * @param DDTCInformationType $DDTCInformation
   */
  public function setDDTCInformation($DDTCInformation)
  {
    $this->DDTCInformation = $DDTCInformation;
  }

}
