<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ShipmentType
{

  /**
   *
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   *
   * @var ReturnServiceType $ReturnService
   * @access public
   */
  public $ReturnService = null;

  /**
   *
   * @var string $DocumentsOnlyIndicator
   * @access public
   */
  public $DocumentsOnlyIndicator = null;

  /**
   *
   * @var ShipperType $Shipper
   * @access public
   */
  public $Shipper = null;

  /**
   *
   * @var ShipToType $ShipTo
   * @access public
   */
  public $ShipTo = null;

  /**
   *
   * @var AlternateDeliveryAddressType $AlternateDeliveryAddress
   * @access public
   */
  public $AlternateDeliveryAddress = null;

  /**
   *
   * @var ShipFromType $ShipFrom
   * @access public
   */
  public $ShipFrom = null;

  /**
   *
   * @var PaymentInfoType $PaymentInformation
   * @access public
   */
  public $PaymentInformation = null;

  /**
   *
   * @var FRSPaymentInfoType $FRSPaymentInformation
   * @access public
   */
  public $FRSPaymentInformation = null;

  /**
   *
   * @var string $GoodsNotInFreeCirculationIndicator
   * @access public
   */
  public $GoodsNotInFreeCirculationIndicator = null;

  /**
   *
   * @var RateInfoType $ShipmentRatingOptions
   * @access public
   */
  public $ShipmentRatingOptions = null;

  /**
   *
   * @var string $MovementReferenceNumber
   * @access public
   */
  public $MovementReferenceNumber = null;

  /**
   *
   * @var ReferenceNumberType $ReferenceNumber
   * @access public
   */
  public $ReferenceNumber = null;

  /**
   *
   * @var ServiceType $Service
   * @access public
   */
  public $Service = null;

  /**
   *
   * @var CurrencyMonetaryType $InvoiceLineTotal
   * @access public
   */
  public $InvoiceLineTotal = null;

  /**
   *
   * @var string $NumOfPiecesInShipment
   * @access public
   */
  public $NumOfPiecesInShipment = null;

  /**
   *
   * @var string $USPSEndorsement
   * @access public
   */
  public $USPSEndorsement = null;

  /**
   *
   * @var string $MILabelCN22Indicator
   * @access public
   */
  public $MILabelCN22Indicator = null;

  /**
   *
   * @var string $SubClassification
   * @access public
   */
  public $SubClassification = null;

  /**
   *
   * @var string $CostCenter
   * @access public
   */
  public $CostCenter = null;

  /**
   *
   * @var string $PackageID
   * @access public
   */
  public $PackageID = null;

  /**
   *
   * @var string $IrregularIndicator
   * @access public
   */
  public $IrregularIndicator = null;

  /**
   *
   * @var string $ItemizedChargesRequestedIndicator
   * @access public
   */
  public $ItemizedChargesRequestedIndicator = null;

  /**
   *
   * @var IndicationType $ShipmentIndicationType
   * @access public
   */
  public $ShipmentIndicationType = null;

  /**
   *
   * @var string $RatingMethodRequestedIndicator
   * @access public
   */
  public $RatingMethodRequestedIndicator = null;

  /**
   *
   * @var ShipmentServiceOptions $ShipmentServiceOptions
   * @access public
   */
  public $ShipmentServiceOptions = null;

  /**
   *
   * @var PackageType $Package
   * @access public
   */
  public $Package = null;

  /**
   *
   * @param string $Description
   * @param ReturnServiceType $ReturnService
   * @param string $DocumentsOnlyIndicator
   * @param ShipperType $Shipper
   * @param ShipToType $ShipTo
   * @param AlternateDeliveryAddressType $AlternateDeliveryAddress
   * @param ShipFromType $ShipFrom
   * @param PaymentInfoType $PaymentInformation
   * @param FRSPaymentInfoType $FRSPaymentInformation
   * @param string $GoodsNotInFreeCirculationIndicator
   * @param RateInfoType $ShipmentRatingOptions
   * @param string $MovementReferenceNumber
   * @param ReferenceNumberType $ReferenceNumber
   * @param ServiceType $Service
   * @param CurrencyMonetaryType $InvoiceLineTotal
   * @param string $NumOfPiecesInShipment
   * @param string $USPSEndorsement
   * @param string $MILabelCN22Indicator
   * @param string $SubClassification
   * @param string $CostCenter
   * @param string $PackageID
   * @param string $IrregularIndicator
   * @param string $ItemizedChargesRequestedIndicator
   * @param IndicationType $ShipmentIndicationType
   * @param string $RatingMethodRequestedIndicator
   * @param ShipmentServiceOptions $ShipmentServiceOptions
   * @param PackageType $Package
   * @access public
   */
  public function __construct($Description = null, $ReturnService = null, $DocumentsOnlyIndicator = null, $Shipper = null, $ShipTo = null, $AlternateDeliveryAddress = null, $ShipFrom = null, $PaymentInformation = null, $FRSPaymentInformation = null, $GoodsNotInFreeCirculationIndicator = null, $ShipmentRatingOptions = null, $MovementReferenceNumber = null, $ReferenceNumber = null, $Service = null, $InvoiceLineTotal = null, $NumOfPiecesInShipment = null, $USPSEndorsement = null, $MILabelCN22Indicator = null, $SubClassification = null, $CostCenter = null, $PackageID = null, $IrregularIndicator = null, $ItemizedChargesRequestedIndicator = null, $ShipmentIndicationType = null, $RatingMethodRequestedIndicator = null, $ShipmentServiceOptions = null, $Package = null)
  {
    $this->Description = $Description;
    $this->ReturnService = $ReturnService;
    $this->DocumentsOnlyIndicator = $DocumentsOnlyIndicator;
    $this->Shipper = $Shipper;
    $this->ShipTo = $ShipTo;
    $this->AlternateDeliveryAddress = $AlternateDeliveryAddress;
    $this->ShipFrom = $ShipFrom;
    $this->PaymentInformation = $PaymentInformation;
    $this->FRSPaymentInformation = $FRSPaymentInformation;
    $this->GoodsNotInFreeCirculationIndicator = $GoodsNotInFreeCirculationIndicator;
    $this->ShipmentRatingOptions = $ShipmentRatingOptions;
    $this->MovementReferenceNumber = $MovementReferenceNumber;
    $this->ReferenceNumber = $ReferenceNumber;
    $this->Service = $Service;
    $this->InvoiceLineTotal = $InvoiceLineTotal;
    $this->NumOfPiecesInShipment = $NumOfPiecesInShipment;
    $this->USPSEndorsement = $USPSEndorsement;
    $this->MILabelCN22Indicator = $MILabelCN22Indicator;
    $this->SubClassification = $SubClassification;
    $this->CostCenter = $CostCenter;
    $this->PackageID = $PackageID;
    $this->IrregularIndicator = $IrregularIndicator;
    $this->ItemizedChargesRequestedIndicator = $ItemizedChargesRequestedIndicator;
    $this->ShipmentIndicationType = $ShipmentIndicationType;
    $this->RatingMethodRequestedIndicator = $RatingMethodRequestedIndicator;
    $this->ShipmentServiceOptions = $ShipmentServiceOptions;
    $this->Package = $Package;
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
   * @return ReturnServiceType
   */
  public function getReturnService()
  {
    return $this->ReturnService;
  }

  /**
   *
   * @param ReturnServiceType $ReturnService
   */
  public function setReturnService($ReturnService)
  {
    $this->ReturnService = $ReturnService;
  }

  /**
   *
   * @return string
   */
  public function getDocumentsOnlyIndicator()
  {
    return $this->DocumentsOnlyIndicator;
  }

  /**
   *
   * @param string $DocumentsOnlyIndicator
   */
  public function setDocumentsOnlyIndicator($DocumentsOnlyIndicator)
  {
    $this->DocumentsOnlyIndicator = $DocumentsOnlyIndicator;
  }

  /**
   *
   * @return ShipperType
   */
  public function getShipper()
  {
    return $this->Shipper;
  }

  /**
   *
   * @param ShipperType $Shipper
   */
  public function setShipper($Shipper)
  {
    $this->Shipper = $Shipper;
  }

  /**
   *
   * @return ShipToType
   */
  public function getShipTo()
  {
    return $this->ShipTo;
  }

  /**
   *
   * @param ShipToType $ShipTo
   */
  public function setShipTo($ShipTo)
  {
    $this->ShipTo = $ShipTo;
  }

  /**
   *
   * @return AlternateDeliveryAddressType
   */
  public function getAlternateDeliveryAddress()
  {
    return $this->AlternateDeliveryAddress;
  }

  /**
   *
   * @param AlternateDeliveryAddressType $AlternateDeliveryAddress
   */
  public function setAlternateDeliveryAddress($AlternateDeliveryAddress)
  {
    $this->AlternateDeliveryAddress = $AlternateDeliveryAddress;
  }

  /**
   *
   * @return ShipFromType
   */
  public function getShipFrom()
  {
    return $this->ShipFrom;
  }

  /**
   *
   * @param ShipFromType $ShipFrom
   */
  public function setShipFrom($ShipFrom)
  {
    $this->ShipFrom = $ShipFrom;
  }

  /**
   *
   * @return PaymentInfoType
   */
  public function getPaymentInformation()
  {
    return $this->PaymentInformation;
  }

  /**
   *
   * @param PaymentInfoType $PaymentInformation
   */
  public function setPaymentInformation($PaymentInformation)
  {
    $this->PaymentInformation = $PaymentInformation;
  }

  /**
   *
   * @return FRSPaymentInfoType
   */
  public function getFRSPaymentInformation()
  {
    return $this->FRSPaymentInformation;
  }

  /**
   *
   * @param FRSPaymentInfoType $FRSPaymentInformation
   */
  public function setFRSPaymentInformation($FRSPaymentInformation)
  {
    $this->FRSPaymentInformation = $FRSPaymentInformation;
  }

  /**
   *
   * @return string
   */
  public function getGoodsNotInFreeCirculationIndicator()
  {
    return $this->GoodsNotInFreeCirculationIndicator;
  }

  /**
   *
   * @param string $GoodsNotInFreeCirculationIndicator
   */
  public function setGoodsNotInFreeCirculationIndicator($GoodsNotInFreeCirculationIndicator)
  {
    $this->GoodsNotInFreeCirculationIndicator = $GoodsNotInFreeCirculationIndicator;
  }

  /**
   *
   * @return RateInfoType
   */
  public function getShipmentRatingOptions()
  {
    return $this->ShipmentRatingOptions;
  }

  /**
   *
   * @param RateInfoType $ShipmentRatingOptions
   */
  public function setShipmentRatingOptions($ShipmentRatingOptions)
  {
    $this->ShipmentRatingOptions = $ShipmentRatingOptions;
  }

  /**
   *
   * @return string
   */
  public function getMovementReferenceNumber()
  {
    return $this->MovementReferenceNumber;
  }

  /**
   *
   * @param string $MovementReferenceNumber
   */
  public function setMovementReferenceNumber($MovementReferenceNumber)
  {
    $this->MovementReferenceNumber = $MovementReferenceNumber;
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
   * @return ServiceType
   */
  public function getService()
  {
    return $this->Service;
  }

  /**
   *
   * @param ServiceType $Service
   */
  public function setService($Service)
  {
    $this->Service = $Service;
  }

  /**
   *
   * @return CurrencyMonetaryType
   */
  public function getInvoiceLineTotal()
  {
    return $this->InvoiceLineTotal;
  }

  /**
   *
   * @param CurrencyMonetaryType $InvoiceLineTotal
   */
  public function setInvoiceLineTotal($InvoiceLineTotal)
  {
    $this->InvoiceLineTotal = $InvoiceLineTotal;
  }

  /**
   *
   * @return string
   */
  public function getNumOfPiecesInShipment()
  {
    return $this->NumOfPiecesInShipment;
  }

  /**
   *
   * @param string $NumOfPiecesInShipment
   */
  public function setNumOfPiecesInShipment($NumOfPiecesInShipment)
  {
    $this->NumOfPiecesInShipment = $NumOfPiecesInShipment;
  }

  /**
   *
   * @return string
   */
  public function getUSPSEndorsement()
  {
    return $this->USPSEndorsement;
  }

  /**
   *
   * @param string $USPSEndorsement
   */
  public function setUSPSEndorsement($USPSEndorsement)
  {
    $this->USPSEndorsement = $USPSEndorsement;
  }

  /**
   *
   * @return string
   */
  public function getMILabelCN22Indicator()
  {
    return $this->MILabelCN22Indicator;
  }

  /**
   *
   * @param string $MILabelCN22Indicator
   */
  public function setMILabelCN22Indicator($MILabelCN22Indicator)
  {
    $this->MILabelCN22Indicator = $MILabelCN22Indicator;
  }

  /**
   *
   * @return string
   */
  public function getSubClassification()
  {
    return $this->SubClassification;
  }

  /**
   *
   * @param string $SubClassification
   */
  public function setSubClassification($SubClassification)
  {
    $this->SubClassification = $SubClassification;
  }

  /**
   *
   * @return string
   */
  public function getCostCenter()
  {
    return $this->CostCenter;
  }

  /**
   *
   * @param string $CostCenter
   */
  public function setCostCenter($CostCenter)
  {
    $this->CostCenter = $CostCenter;
  }

  /**
   *
   * @return string
   */
  public function getPackageID()
  {
    return $this->PackageID;
  }

  /**
   *
   * @param string $PackageID
   */
  public function setPackageID($PackageID)
  {
    $this->PackageID = $PackageID;
  }

  /**
   *
   * @return string
   */
  public function getIrregularIndicator()
  {
    return $this->IrregularIndicator;
  }

  /**
   *
   * @param string $IrregularIndicator
   */
  public function setIrregularIndicator($IrregularIndicator)
  {
    $this->IrregularIndicator = $IrregularIndicator;
  }

  /**
   *
   * @return string
   */
  public function getItemizedChargesRequestedIndicator()
  {
    return $this->ItemizedChargesRequestedIndicator;
  }

  /**
   *
   * @param string $ItemizedChargesRequestedIndicator
   */
  public function setItemizedChargesRequestedIndicator($ItemizedChargesRequestedIndicator)
  {
    $this->ItemizedChargesRequestedIndicator = $ItemizedChargesRequestedIndicator;
  }

  /**
   *
   * @return IndicationType
   */
  public function getShipmentIndicationType()
  {
    return $this->ShipmentIndicationType;
  }

  /**
   *
   * @param IndicationType $ShipmentIndicationType
   */
  public function setShipmentIndicationType($ShipmentIndicationType)
  {
    $this->ShipmentIndicationType = $ShipmentIndicationType;
  }

  /**
   *
   * @return string
   */
  public function getRatingMethodRequestedIndicator()
  {
    return $this->RatingMethodRequestedIndicator;
  }

  /**
   *
   * @param string $RatingMethodRequestedIndicator
   */
  public function setRatingMethodRequestedIndicator($RatingMethodRequestedIndicator)
  {
    $this->RatingMethodRequestedIndicator = $RatingMethodRequestedIndicator;
  }

  /**
   *
   * @return ShipmentServiceOptions
   */
  public function getShipmentServiceOptions()
  {
    return $this->ShipmentServiceOptions;
  }

  /**
   *
   * @param ShipmentServiceOptions $ShipmentServiceOptions
   */
  public function setShipmentServiceOptions($ShipmentServiceOptions)
  {
    $this->ShipmentServiceOptions = $ShipmentServiceOptions;
  }

  /**
   *
   * @return PackageType
   */
  public function getPackage()
  {
    return $this->Package;
  }

  /**
   *
   * @param PackageType $Package
   */
  public function setPackage($Package)
  {
    $this->Package = $Package;
  }

}
