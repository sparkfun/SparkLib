<?php

namespace SparkLib\UPS\Ship;

class ShipmentResultsType
{

  /**
   * 
   * @var ShipmentChargesType $ShipmentCharges
   * @access public
   */
  public $ShipmentCharges = null;

  /**
   * 
   * @var NegotiatedRateChargesType $NegotiatedRateCharges
   * @access public
   */
  public $NegotiatedRateCharges = null;

  /**
   * 
   * @var FRSShipmentDataType $FRSShipmentData
   * @access public
   */
  public $FRSShipmentData = null;

  /**
   * 
   * @var string $RatingMethod
   * @access public
   */
  public $RatingMethod = null;

  /**
   * 
   * @var string $BillableWeightCalculationMethod
   * @access public
   */
  public $BillableWeightCalculationMethod = null;

  /**
   * 
   * @var BillingWeightType $BillingWeight
   * @access public
   */
  public $BillingWeight = null;

  /**
   * 
   * @var string $ShipmentIdentificationNumber
   * @access public
   */
  public $ShipmentIdentificationNumber = null;

  /**
   * 
   * @var string $ShipmentDigest
   * @access public
   */
  public $ShipmentDigest = null;

  /**
   * 
   * @var PackageResultsType $PackageResults
   * @access public
   */
  public $PackageResults = null;

  /**
   * 
   * @var ImageType $ControlLogReceipt
   * @access public
   */
  public $ControlLogReceipt = null;

  /**
   * 
   * @var FormType $Form
   * @access public
   */
  public $Form = null;

  /**
   * 
   * @var SCReportType $CODTurnInPage
   * @access public
   */
  public $CODTurnInPage = null;

  /**
   * 
   * @var HighValueReportType $HighValueReport
   * @access public
   */
  public $HighValueReport = null;

  /**
   * 
   * @var string $LabelURL
   * @access public
   */
  public $LabelURL = null;

  /**
   * 
   * @var string $LocalLanguageLabelURL
   * @access public
   */
  public $LocalLanguageLabelURL = null;

  /**
   * 
   * @var string $ReceiptURL
   * @access public
   */
  public $ReceiptURL = null;

  /**
   * 
   * @var string $LocalLanguageReceiptURL
   * @access public
   */
  public $LocalLanguageReceiptURL = null;

  /**
   * 
   * @param ShipmentChargesType $ShipmentCharges
   * @param NegotiatedRateChargesType $NegotiatedRateCharges
   * @param FRSShipmentDataType $FRSShipmentData
   * @param string $RatingMethod
   * @param string $BillableWeightCalculationMethod
   * @param BillingWeightType $BillingWeight
   * @param string $ShipmentIdentificationNumber
   * @param string $ShipmentDigest
   * @param PackageResultsType $PackageResults
   * @param ImageType $ControlLogReceipt
   * @param FormType $Form
   * @param SCReportType $CODTurnInPage
   * @param HighValueReportType $HighValueReport
   * @param string $LabelURL
   * @param string $LocalLanguageLabelURL
   * @param string $ReceiptURL
   * @param string $LocalLanguageReceiptURL
   * @access public
   */
  public function __construct($ShipmentCharges = null, $NegotiatedRateCharges = null, $FRSShipmentData = null, $RatingMethod = null, $BillableWeightCalculationMethod = null, $BillingWeight = null, $ShipmentIdentificationNumber = null, $ShipmentDigest = null, $PackageResults = null, $ControlLogReceipt = null, $Form = null, $CODTurnInPage = null, $HighValueReport = null, $LabelURL = null, $LocalLanguageLabelURL = null, $ReceiptURL = null, $LocalLanguageReceiptURL = null)
  {
    $this->ShipmentCharges = $ShipmentCharges;
    $this->NegotiatedRateCharges = $NegotiatedRateCharges;
    $this->FRSShipmentData = $FRSShipmentData;
    $this->RatingMethod = $RatingMethod;
    $this->BillableWeightCalculationMethod = $BillableWeightCalculationMethod;
    $this->BillingWeight = $BillingWeight;
    $this->ShipmentIdentificationNumber = $ShipmentIdentificationNumber;
    $this->ShipmentDigest = $ShipmentDigest;
    $this->PackageResults = $PackageResults;
    $this->ControlLogReceipt = $ControlLogReceipt;
    $this->Form = $Form;
    $this->CODTurnInPage = $CODTurnInPage;
    $this->HighValueReport = $HighValueReport;
    $this->LabelURL = $LabelURL;
    $this->LocalLanguageLabelURL = $LocalLanguageLabelURL;
    $this->ReceiptURL = $ReceiptURL;
    $this->LocalLanguageReceiptURL = $LocalLanguageReceiptURL;
  }

  /**
   * 
   * @return ShipmentChargesType
   */
  public function getShipmentCharges()
  {
    return $this->ShipmentCharges;
  }

  /**
   * 
   * @param ShipmentChargesType $ShipmentCharges
   */
  public function setShipmentCharges($ShipmentCharges)
  {
    $this->ShipmentCharges = $ShipmentCharges;
  }

  /**
   * 
   * @return NegotiatedRateChargesType
   */
  public function getNegotiatedRateCharges()
  {
    return $this->NegotiatedRateCharges;
  }

  /**
   * 
   * @param NegotiatedRateChargesType $NegotiatedRateCharges
   */
  public function setNegotiatedRateCharges($NegotiatedRateCharges)
  {
    $this->NegotiatedRateCharges = $NegotiatedRateCharges;
  }

  /**
   * 
   * @return FRSShipmentDataType
   */
  public function getFRSShipmentData()
  {
    return $this->FRSShipmentData;
  }

  /**
   * 
   * @param FRSShipmentDataType $FRSShipmentData
   */
  public function setFRSShipmentData($FRSShipmentData)
  {
    $this->FRSShipmentData = $FRSShipmentData;
  }

  /**
   * 
   * @return string
   */
  public function getRatingMethod()
  {
    return $this->RatingMethod;
  }

  /**
   * 
   * @param string $RatingMethod
   */
  public function setRatingMethod($RatingMethod)
  {
    $this->RatingMethod = $RatingMethod;
  }

  /**
   * 
   * @return string
   */
  public function getBillableWeightCalculationMethod()
  {
    return $this->BillableWeightCalculationMethod;
  }

  /**
   * 
   * @param string $BillableWeightCalculationMethod
   */
  public function setBillableWeightCalculationMethod($BillableWeightCalculationMethod)
  {
    $this->BillableWeightCalculationMethod = $BillableWeightCalculationMethod;
  }

  /**
   * 
   * @return BillingWeightType
   */
  public function getBillingWeight()
  {
    return $this->BillingWeight;
  }

  /**
   * 
   * @param BillingWeightType $BillingWeight
   */
  public function setBillingWeight($BillingWeight)
  {
    $this->BillingWeight = $BillingWeight;
  }

  /**
   * 
   * @return string
   */
  public function getShipmentIdentificationNumber()
  {
    return $this->ShipmentIdentificationNumber;
  }

  /**
   * 
   * @param string $ShipmentIdentificationNumber
   */
  public function setShipmentIdentificationNumber($ShipmentIdentificationNumber)
  {
    $this->ShipmentIdentificationNumber = $ShipmentIdentificationNumber;
  }

  /**
   * 
   * @return string
   */
  public function getShipmentDigest()
  {
    return $this->ShipmentDigest;
  }

  /**
   * 
   * @param string $ShipmentDigest
   */
  public function setShipmentDigest($ShipmentDigest)
  {
    $this->ShipmentDigest = $ShipmentDigest;
  }

  /**
   * 
   * @return PackageResultsType
   */
  public function getPackageResults()
  {
    return $this->PackageResults;
  }

  /**
   * 
   * @param PackageResultsType $PackageResults
   */
  public function setPackageResults($PackageResults)
  {
    $this->PackageResults = $PackageResults;
  }

  /**
   * 
   * @return ImageType
   */
  public function getControlLogReceipt()
  {
    return $this->ControlLogReceipt;
  }

  /**
   * 
   * @param ImageType $ControlLogReceipt
   */
  public function setControlLogReceipt($ControlLogReceipt)
  {
    $this->ControlLogReceipt = $ControlLogReceipt;
  }

  /**
   * 
   * @return FormType
   */
  public function getForm()
  {
    return $this->Form;
  }

  /**
   * 
   * @param FormType $Form
   */
  public function setForm($Form)
  {
    $this->Form = $Form;
  }

  /**
   * 
   * @return SCReportType
   */
  public function getCODTurnInPage()
  {
    return $this->CODTurnInPage;
  }

  /**
   * 
   * @param SCReportType $CODTurnInPage
   */
  public function setCODTurnInPage($CODTurnInPage)
  {
    $this->CODTurnInPage = $CODTurnInPage;
  }

  /**
   * 
   * @return HighValueReportType
   */
  public function getHighValueReport()
  {
    return $this->HighValueReport;
  }

  /**
   * 
   * @param HighValueReportType $HighValueReport
   */
  public function setHighValueReport($HighValueReport)
  {
    $this->HighValueReport = $HighValueReport;
  }

  /**
   * 
   * @return string
   */
  public function getLabelURL()
  {
    return $this->LabelURL;
  }

  /**
   * 
   * @param string $LabelURL
   */
  public function setLabelURL($LabelURL)
  {
    $this->LabelURL = $LabelURL;
  }

  /**
   * 
   * @return string
   */
  public function getLocalLanguageLabelURL()
  {
    return $this->LocalLanguageLabelURL;
  }

  /**
   * 
   * @param string $LocalLanguageLabelURL
   */
  public function setLocalLanguageLabelURL($LocalLanguageLabelURL)
  {
    $this->LocalLanguageLabelURL = $LocalLanguageLabelURL;
  }

  /**
   * 
   * @return string
   */
  public function getReceiptURL()
  {
    return $this->ReceiptURL;
  }

  /**
   * 
   * @param string $ReceiptURL
   */
  public function setReceiptURL($ReceiptURL)
  {
    $this->ReceiptURL = $ReceiptURL;
  }

  /**
   * 
   * @return string
   */
  public function getLocalLanguageReceiptURL()
  {
    return $this->LocalLanguageReceiptURL;
  }

  /**
   * 
   * @param string $LocalLanguageReceiptURL
   */
  public function setLocalLanguageReceiptURL($LocalLanguageReceiptURL)
  {
    $this->LocalLanguageReceiptURL = $LocalLanguageReceiptURL;
  }

}
