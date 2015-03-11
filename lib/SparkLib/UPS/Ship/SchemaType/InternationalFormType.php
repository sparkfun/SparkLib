<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class InternationalFormType
{

  /**
   *
   * @var string $FormType
   * @access public
   */
  public $FormType = null;

  /**
   *
   * @var UserCreatedFormType $UserCreatedForm
   * @access public
   */
  public $UserCreatedForm = null;

  /**
   *
   * @var CN22FormType $CN22Form
   * @access public
   */
  public $CN22Form = null;

  /**
   *
   * @var UPSPremiumCareFormType $UPSPremiumCareForm
   * @access public
   */
  public $UPSPremiumCareForm = null;

  /**
   *
   * @var string $AdditionalDocumentIndicator
   * @access public
   */
  public $AdditionalDocumentIndicator = null;

  /**
   *
   * @var string $FormGroupIdName
   * @access public
   */
  public $FormGroupIdName = null;

  /**
   *
   * @var string $SEDFilingOption
   * @access public
   */
  public $SEDFilingOption = null;

  /**
   *
   * @var EEIFilingOptionType $EEIFilingOption
   * @access public
   */
  public $EEIFilingOption = null;

  /**
   *
   * @var ContactType $Contacts
   * @access public
   */
  public $Contacts = null;

  /**
   *
   * @var ProductType $Product
   * @access public
   */
  public $Product = null;

  /**
   *
   * @var string $InvoiceNumber
   * @access public
   */
  public $InvoiceNumber = null;

  /**
   *
   * @var string $InvoiceDate
   * @access public
   */
  public $InvoiceDate = null;

  /**
   *
   * @var string $PurchaseOrderNumber
   * @access public
   */
  public $PurchaseOrderNumber = null;

  /**
   *
   * @var string $TermsOfShipment
   * @access public
   */
  public $TermsOfShipment = null;

  /**
   *
   * @var string $ReasonForExport
   * @access public
   */
  public $ReasonForExport = null;

  /**
   *
   * @var string $Comments
   * @access public
   */
  public $Comments = null;

  /**
   *
   * @var string $DeclarationStatement
   * @access public
   */
  public $DeclarationStatement = null;

  /**
   *
   * @var IFChargesType $Discount
   * @access public
   */
  public $Discount = null;

  /**
   *
   * @var IFChargesType $FreightCharges
   * @access public
   */
  public $FreightCharges = null;

  /**
   *
   * @var IFChargesType $InsuranceCharges
   * @access public
   */
  public $InsuranceCharges = null;

  /**
   *
   * @var OtherChargesType $OtherCharges
   * @access public
   */
  public $OtherCharges = null;

  /**
   *
   * @var string $CurrencyCode
   * @access public
   */
  public $CurrencyCode = null;

  /**
   *
   * @var BlanketPeriodType $BlanketPeriod
   * @access public
   */
  public $BlanketPeriod = null;

  /**
   *
   * @var string $ExportDate
   * @access public
   */
  public $ExportDate = null;

  /**
   *
   * @var string $ExportingCarrier
   * @access public
   */
  public $ExportingCarrier = null;

  /**
   *
   * @var string $CarrierID
   * @access public
   */
  public $CarrierID = null;

  /**
   *
   * @var string $InBondCode
   * @access public
   */
  public $InBondCode = null;

  /**
   *
   * @var string $EntryNumber
   * @access public
   */
  public $EntryNumber = null;

  /**
   *
   * @var string $PointOfOrigin
   * @access public
   */
  public $PointOfOrigin = null;

  /**
   *
   * @var string $PointOfOriginType
   * @access public
   */
  public $PointOfOriginType = null;

  /**
   *
   * @var string $ModeOfTransport
   * @access public
   */
  public $ModeOfTransport = null;

  /**
   *
   * @var string $PortOfExport
   * @access public
   */
  public $PortOfExport = null;

  /**
   *
   * @var string $PortOfUnloading
   * @access public
   */
  public $PortOfUnloading = null;

  /**
   *
   * @var string $LoadingPier
   * @access public
   */
  public $LoadingPier = null;

  /**
   *
   * @var string $PartiesToTransaction
   * @access public
   */
  public $PartiesToTransaction = null;

  /**
   *
   * @var string $RoutedExportTransactionIndicator
   * @access public
   */
  public $RoutedExportTransactionIndicator = null;

  /**
   *
   * @var string $ContainerizedIndicator
   * @access public
   */
  public $ContainerizedIndicator = null;

  /**
   *
   * @var LicenseType $License
   * @access public
   */
  public $License = null;

  /**
   *
   * @var string $ECCNNumber
   * @access public
   */
  public $ECCNNumber = null;

  /**
   *
   * @var string $OverridePaperlessIndicator
   * @access public
   */
  public $OverridePaperlessIndicator = null;

  /**
   *
   * @var string $ShipperMemo
   * @access public
   */
  public $ShipperMemo = null;

  /**
   *
   * @var string $MultiCurrencyInvoiceLineTotal
   * @access public
   */
  public $MultiCurrencyInvoiceLineTotal = null;

  /**
   *
   * @param string $FormType
   * @param UserCreatedFormType $UserCreatedForm
   * @param CN22FormType $CN22Form
   * @param UPSPremiumCareFormType $UPSPremiumCareForm
   * @param string $AdditionalDocumentIndicator
   * @param string $FormGroupIdName
   * @param string $SEDFilingOption
   * @param EEIFilingOptionType $EEIFilingOption
   * @param ContactType $Contacts
   * @param ProductType $Product
   * @param string $InvoiceNumber
   * @param string $InvoiceDate
   * @param string $PurchaseOrderNumber
   * @param string $TermsOfShipment
   * @param string $ReasonForExport
   * @param string $Comments
   * @param string $DeclarationStatement
   * @param IFChargesType $Discount
   * @param IFChargesType $FreightCharges
   * @param IFChargesType $InsuranceCharges
   * @param OtherChargesType $OtherCharges
   * @param string $CurrencyCode
   * @param BlanketPeriodType $BlanketPeriod
   * @param string $ExportDate
   * @param string $ExportingCarrier
   * @param string $CarrierID
   * @param string $InBondCode
   * @param string $EntryNumber
   * @param string $PointOfOrigin
   * @param string $PointOfOriginType
   * @param string $ModeOfTransport
   * @param string $PortOfExport
   * @param string $PortOfUnloading
   * @param string $LoadingPier
   * @param string $PartiesToTransaction
   * @param string $RoutedExportTransactionIndicator
   * @param string $ContainerizedIndicator
   * @param LicenseType $License
   * @param string $ECCNNumber
   * @param string $OverridePaperlessIndicator
   * @param string $ShipperMemo
   * @param string $MultiCurrencyInvoiceLineTotal
   * @access public
   */
  public function __construct($FormType = null, $UserCreatedForm = null, $CN22Form = null, $UPSPremiumCareForm = null, $AdditionalDocumentIndicator = null, $FormGroupIdName = null, $SEDFilingOption = null, $EEIFilingOption = null, $Contacts = null, $Product = null, $InvoiceNumber = null, $InvoiceDate = null, $PurchaseOrderNumber = null, $TermsOfShipment = null, $ReasonForExport = null, $Comments = null, $DeclarationStatement = null, $Discount = null, $FreightCharges = null, $InsuranceCharges = null, $OtherCharges = null, $CurrencyCode = null, $BlanketPeriod = null, $ExportDate = null, $ExportingCarrier = null, $CarrierID = null, $InBondCode = null, $EntryNumber = null, $PointOfOrigin = null, $PointOfOriginType = null, $ModeOfTransport = null, $PortOfExport = null, $PortOfUnloading = null, $LoadingPier = null, $PartiesToTransaction = null, $RoutedExportTransactionIndicator = null, $ContainerizedIndicator = null, $License = null, $ECCNNumber = null, $OverridePaperlessIndicator = null, $ShipperMemo = null, $MultiCurrencyInvoiceLineTotal = null)
  {
    $this->FormType = $FormType;
    $this->UserCreatedForm = $UserCreatedForm;
    $this->CN22Form = $CN22Form;
    $this->UPSPremiumCareForm = $UPSPremiumCareForm;
    $this->AdditionalDocumentIndicator = $AdditionalDocumentIndicator;
    $this->FormGroupIdName = $FormGroupIdName;
    $this->SEDFilingOption = $SEDFilingOption;
    $this->EEIFilingOption = $EEIFilingOption;
    $this->Contacts = $Contacts;
    $this->Product = $Product;
    $this->InvoiceNumber = $InvoiceNumber;
    $this->InvoiceDate = $InvoiceDate;
    $this->PurchaseOrderNumber = $PurchaseOrderNumber;
    $this->TermsOfShipment = $TermsOfShipment;
    $this->ReasonForExport = $ReasonForExport;
    $this->Comments = $Comments;
    $this->DeclarationStatement = $DeclarationStatement;
    $this->Discount = $Discount;
    $this->FreightCharges = $FreightCharges;
    $this->InsuranceCharges = $InsuranceCharges;
    $this->OtherCharges = $OtherCharges;
    $this->CurrencyCode = $CurrencyCode;
    $this->BlanketPeriod = $BlanketPeriod;
    $this->ExportDate = $ExportDate;
    $this->ExportingCarrier = $ExportingCarrier;
    $this->CarrierID = $CarrierID;
    $this->InBondCode = $InBondCode;
    $this->EntryNumber = $EntryNumber;
    $this->PointOfOrigin = $PointOfOrigin;
    $this->PointOfOriginType = $PointOfOriginType;
    $this->ModeOfTransport = $ModeOfTransport;
    $this->PortOfExport = $PortOfExport;
    $this->PortOfUnloading = $PortOfUnloading;
    $this->LoadingPier = $LoadingPier;
    $this->PartiesToTransaction = $PartiesToTransaction;
    $this->RoutedExportTransactionIndicator = $RoutedExportTransactionIndicator;
    $this->ContainerizedIndicator = $ContainerizedIndicator;
    $this->License = $License;
    $this->ECCNNumber = $ECCNNumber;
    $this->OverridePaperlessIndicator = $OverridePaperlessIndicator;
    $this->ShipperMemo = $ShipperMemo;
    $this->MultiCurrencyInvoiceLineTotal = $MultiCurrencyInvoiceLineTotal;
  }

  /**
   *
   * @return string
   */
  public function getFormType()
  {
    return $this->FormType;
  }

  /**
   *
   * @param string $FormType
   */
  public function setFormType($FormType)
  {
    $this->FormType = $FormType;
  }

  /**
   *
   * @return UserCreatedFormType
   */
  public function getUserCreatedForm()
  {
    return $this->UserCreatedForm;
  }

  /**
   *
   * @param UserCreatedFormType $UserCreatedForm
   */
  public function setUserCreatedForm($UserCreatedForm)
  {
    $this->UserCreatedForm = $UserCreatedForm;
  }

  /**
   *
   * @return CN22FormType
   */
  public function getCN22Form()
  {
    return $this->CN22Form;
  }

  /**
   *
   * @param CN22FormType $CN22Form
   */
  public function setCN22Form($CN22Form)
  {
    $this->CN22Form = $CN22Form;
  }

  /**
   *
   * @return UPSPremiumCareFormType
   */
  public function getUPSPremiumCareForm()
  {
    return $this->UPSPremiumCareForm;
  }

  /**
   *
   * @param UPSPremiumCareFormType $UPSPremiumCareForm
   */
  public function setUPSPremiumCareForm($UPSPremiumCareForm)
  {
    $this->UPSPremiumCareForm = $UPSPremiumCareForm;
  }

  /**
   *
   * @return string
   */
  public function getAdditionalDocumentIndicator()
  {
    return $this->AdditionalDocumentIndicator;
  }

  /**
   *
   * @param string $AdditionalDocumentIndicator
   */
  public function setAdditionalDocumentIndicator($AdditionalDocumentIndicator)
  {
    $this->AdditionalDocumentIndicator = $AdditionalDocumentIndicator;
  }

  /**
   *
   * @return string
   */
  public function getFormGroupIdName()
  {
    return $this->FormGroupIdName;
  }

  /**
   *
   * @param string $FormGroupIdName
   */
  public function setFormGroupIdName($FormGroupIdName)
  {
    $this->FormGroupIdName = $FormGroupIdName;
  }

  /**
   *
   * @return string
   */
  public function getSEDFilingOption()
  {
    return $this->SEDFilingOption;
  }

  /**
   *
   * @param string $SEDFilingOption
   */
  public function setSEDFilingOption($SEDFilingOption)
  {
    $this->SEDFilingOption = $SEDFilingOption;
  }

  /**
   *
   * @return EEIFilingOptionType
   */
  public function getEEIFilingOption()
  {
    return $this->EEIFilingOption;
  }

  /**
   *
   * @param EEIFilingOptionType $EEIFilingOption
   */
  public function setEEIFilingOption($EEIFilingOption)
  {
    $this->EEIFilingOption = $EEIFilingOption;
  }

  /**
   *
   * @return ContactType
   */
  public function getContacts()
  {
    return $this->Contacts;
  }

  /**
   *
   * @param ContactType $Contacts
   */
  public function setContacts($Contacts)
  {
    $this->Contacts = $Contacts;
  }

  /**
   *
   * @return ProductType
   */
  public function getProduct()
  {
    return $this->Product;
  }

  /**
   *
   * @param ProductType $Product
   */
  public function setProduct($Product)
  {
    $this->Product = $Product;
  }

  /**
   *
   * @return string
   */
  public function getInvoiceNumber()
  {
    return $this->InvoiceNumber;
  }

  /**
   *
   * @param string $InvoiceNumber
   */
  public function setInvoiceNumber($InvoiceNumber)
  {
    $this->InvoiceNumber = $InvoiceNumber;
  }

  /**
   *
   * @return string
   */
  public function getInvoiceDate()
  {
    return $this->InvoiceDate;
  }

  /**
   *
   * @param string $InvoiceDate
   */
  public function setInvoiceDate($InvoiceDate)
  {
    $this->InvoiceDate = $InvoiceDate;
  }

  /**
   *
   * @return string
   */
  public function getPurchaseOrderNumber()
  {
    return $this->PurchaseOrderNumber;
  }

  /**
   *
   * @param string $PurchaseOrderNumber
   */
  public function setPurchaseOrderNumber($PurchaseOrderNumber)
  {
    $this->PurchaseOrderNumber = $PurchaseOrderNumber;
  }

  /**
   *
   * @return string
   */
  public function getTermsOfShipment()
  {
    return $this->TermsOfShipment;
  }

  /**
   *
   * @param string $TermsOfShipment
   */
  public function setTermsOfShipment($TermsOfShipment)
  {
    $this->TermsOfShipment = $TermsOfShipment;
  }

  /**
   *
   * @return string
   */
  public function getReasonForExport()
  {
    return $this->ReasonForExport;
  }

  /**
   *
   * @param string $ReasonForExport
   */
  public function setReasonForExport($ReasonForExport)
  {
    $this->ReasonForExport = $ReasonForExport;
  }

  /**
   *
   * @return string
   */
  public function getComments()
  {
    return $this->Comments;
  }

  /**
   *
   * @param string $Comments
   */
  public function setComments($Comments)
  {
    $this->Comments = $Comments;
  }

  /**
   *
   * @return string
   */
  public function getDeclarationStatement()
  {
    return $this->DeclarationStatement;
  }

  /**
   *
   * @param string $DeclarationStatement
   */
  public function setDeclarationStatement($DeclarationStatement)
  {
    $this->DeclarationStatement = $DeclarationStatement;
  }

  /**
   *
   * @return IFChargesType
   */
  public function getDiscount()
  {
    return $this->Discount;
  }

  /**
   *
   * @param IFChargesType $Discount
   */
  public function setDiscount($Discount)
  {
    $this->Discount = $Discount;
  }

  /**
   *
   * @return IFChargesType
   */
  public function getFreightCharges()
  {
    return $this->FreightCharges;
  }

  /**
   *
   * @param IFChargesType $FreightCharges
   */
  public function setFreightCharges($FreightCharges)
  {
    $this->FreightCharges = $FreightCharges;
  }

  /**
   *
   * @return IFChargesType
   */
  public function getInsuranceCharges()
  {
    return $this->InsuranceCharges;
  }

  /**
   *
   * @param IFChargesType $InsuranceCharges
   */
  public function setInsuranceCharges($InsuranceCharges)
  {
    $this->InsuranceCharges = $InsuranceCharges;
  }

  /**
   *
   * @return OtherChargesType
   */
  public function getOtherCharges()
  {
    return $this->OtherCharges;
  }

  /**
   *
   * @param OtherChargesType $OtherCharges
   */
  public function setOtherCharges($OtherCharges)
  {
    $this->OtherCharges = $OtherCharges;
  }

  /**
   *
   * @return string
   */
  public function getCurrencyCode()
  {
    return $this->CurrencyCode;
  }

  /**
   *
   * @param string $CurrencyCode
   */
  public function setCurrencyCode($CurrencyCode)
  {
    $this->CurrencyCode = $CurrencyCode;
  }

  /**
   *
   * @return BlanketPeriodType
   */
  public function getBlanketPeriod()
  {
    return $this->BlanketPeriod;
  }

  /**
   *
   * @param BlanketPeriodType $BlanketPeriod
   */
  public function setBlanketPeriod($BlanketPeriod)
  {
    $this->BlanketPeriod = $BlanketPeriod;
  }

  /**
   *
   * @return string
   */
  public function getExportDate()
  {
    return $this->ExportDate;
  }

  /**
   *
   * @param string $ExportDate
   */
  public function setExportDate($ExportDate)
  {
    $this->ExportDate = $ExportDate;
  }

  /**
   *
   * @return string
   */
  public function getExportingCarrier()
  {
    return $this->ExportingCarrier;
  }

  /**
   *
   * @param string $ExportingCarrier
   */
  public function setExportingCarrier($ExportingCarrier)
  {
    $this->ExportingCarrier = $ExportingCarrier;
  }

  /**
   *
   * @return string
   */
  public function getCarrierID()
  {
    return $this->CarrierID;
  }

  /**
   *
   * @param string $CarrierID
   */
  public function setCarrierID($CarrierID)
  {
    $this->CarrierID = $CarrierID;
  }

  /**
   *
   * @return string
   */
  public function getInBondCode()
  {
    return $this->InBondCode;
  }

  /**
   *
   * @param string $InBondCode
   */
  public function setInBondCode($InBondCode)
  {
    $this->InBondCode = $InBondCode;
  }

  /**
   *
   * @return string
   */
  public function getEntryNumber()
  {
    return $this->EntryNumber;
  }

  /**
   *
   * @param string $EntryNumber
   */
  public function setEntryNumber($EntryNumber)
  {
    $this->EntryNumber = $EntryNumber;
  }

  /**
   *
   * @return string
   */
  public function getPointOfOrigin()
  {
    return $this->PointOfOrigin;
  }

  /**
   *
   * @param string $PointOfOrigin
   */
  public function setPointOfOrigin($PointOfOrigin)
  {
    $this->PointOfOrigin = $PointOfOrigin;
  }

  /**
   *
   * @return string
   */
  public function getPointOfOriginType()
  {
    return $this->PointOfOriginType;
  }

  /**
   *
   * @param string $PointOfOriginType
   */
  public function setPointOfOriginType($PointOfOriginType)
  {
    $this->PointOfOriginType = $PointOfOriginType;
  }

  /**
   *
   * @return string
   */
  public function getModeOfTransport()
  {
    return $this->ModeOfTransport;
  }

  /**
   *
   * @param string $ModeOfTransport
   */
  public function setModeOfTransport($ModeOfTransport)
  {
    $this->ModeOfTransport = $ModeOfTransport;
  }

  /**
   *
   * @return string
   */
  public function getPortOfExport()
  {
    return $this->PortOfExport;
  }

  /**
   *
   * @param string $PortOfExport
   */
  public function setPortOfExport($PortOfExport)
  {
    $this->PortOfExport = $PortOfExport;
  }

  /**
   *
   * @return string
   */
  public function getPortOfUnloading()
  {
    return $this->PortOfUnloading;
  }

  /**
   *
   * @param string $PortOfUnloading
   */
  public function setPortOfUnloading($PortOfUnloading)
  {
    $this->PortOfUnloading = $PortOfUnloading;
  }

  /**
   *
   * @return string
   */
  public function getLoadingPier()
  {
    return $this->LoadingPier;
  }

  /**
   *
   * @param string $LoadingPier
   */
  public function setLoadingPier($LoadingPier)
  {
    $this->LoadingPier = $LoadingPier;
  }

  /**
   *
   * @return string
   */
  public function getPartiesToTransaction()
  {
    return $this->PartiesToTransaction;
  }

  /**
   *
   * @param string $PartiesToTransaction
   */
  public function setPartiesToTransaction($PartiesToTransaction)
  {
    $this->PartiesToTransaction = $PartiesToTransaction;
  }

  /**
   *
   * @return string
   */
  public function getRoutedExportTransactionIndicator()
  {
    return $this->RoutedExportTransactionIndicator;
  }

  /**
   *
   * @param string $RoutedExportTransactionIndicator
   */
  public function setRoutedExportTransactionIndicator($RoutedExportTransactionIndicator)
  {
    $this->RoutedExportTransactionIndicator = $RoutedExportTransactionIndicator;
  }

  /**
   *
   * @return string
   */
  public function getContainerizedIndicator()
  {
    return $this->ContainerizedIndicator;
  }

  /**
   *
   * @param string $ContainerizedIndicator
   */
  public function setContainerizedIndicator($ContainerizedIndicator)
  {
    $this->ContainerizedIndicator = $ContainerizedIndicator;
  }

  /**
   *
   * @return LicenseType
   */
  public function getLicense()
  {
    return $this->License;
  }

  /**
   *
   * @param LicenseType $License
   */
  public function setLicense($License)
  {
    $this->License = $License;
  }

  /**
   *
   * @return string
   */
  public function getECCNNumber()
  {
    return $this->ECCNNumber;
  }

  /**
   *
   * @param string $ECCNNumber
   */
  public function setECCNNumber($ECCNNumber)
  {
    $this->ECCNNumber = $ECCNNumber;
  }

  /**
   *
   * @return string
   */
  public function getOverridePaperlessIndicator()
  {
    return $this->OverridePaperlessIndicator;
  }

  /**
   *
   * @param string $OverridePaperlessIndicator
   */
  public function setOverridePaperlessIndicator($OverridePaperlessIndicator)
  {
    $this->OverridePaperlessIndicator = $OverridePaperlessIndicator;
  }

  /**
   *
   * @return string
   */
  public function getShipperMemo()
  {
    return $this->ShipperMemo;
  }

  /**
   *
   * @param string $ShipperMemo
   */
  public function setShipperMemo($ShipperMemo)
  {
    $this->ShipperMemo = $ShipperMemo;
  }

  /**
   *
   * @return string
   */
  public function getMultiCurrencyInvoiceLineTotal()
  {
    return $this->MultiCurrencyInvoiceLineTotal;
  }

  /**
   *
   * @param string $MultiCurrencyInvoiceLineTotal
   */
  public function setMultiCurrencyInvoiceLineTotal($MultiCurrencyInvoiceLineTotal)
  {
    $this->MultiCurrencyInvoiceLineTotal = $MultiCurrencyInvoiceLineTotal;
  }

}
