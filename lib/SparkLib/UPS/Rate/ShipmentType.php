<?php

namespace SparkLib\UPS\Rate;

class ShipmentType
{

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
   * @var ShipFromType $ShipFrom
   * @access public
   */
  public $ShipFrom = null;

  /**
   * 
   * @var AlternateDeliveryAddressType $AlternateDeliveryAddress
   * @access public
   */
  public $AlternateDeliveryAddress = null;

  /**
   * 
   * @var IndicationType $ShipmentIndicationType
   * @access public
   */
  public $ShipmentIndicationType = null;

  /**
   * 
   * @var FRSPaymentInfoType $FRSPaymentInformation
   * @access public
   */
  public $FRSPaymentInformation = null;

  /**
   * 
   * @var CodeDescriptionType $Service
   * @access public
   */
  public $Service = null;

  /**
   * 
   * @var string $DocumentsOnlyIndicator
   * @access public
   */
  public $DocumentsOnlyIndicator = null;

  /**
   * 
   * @var string $NumOfPieces
   * @access public
   */
  public $NumOfPieces = null;

  /**
   * 
   * @var PackageType $Package
   * @access public
   */
  public $Package = null;

  /**
   * 
   * @var ShipmentServiceOptionsType $ShipmentServiceOptions
   * @access public
   */
  public $ShipmentServiceOptions = null;

  /**
   * 
   * @var ShipmentRatingOptionsType $ShipmentRatingOptions
   * @access public
   */
  public $ShipmentRatingOptions = null;

  /**
   * 
   * @var InvoiceLineTotalType $InvoiceLineTotal
   * @access public
   */
  public $InvoiceLineTotal = null;

  /**
   * 
   * @var string $ItemizedChargesRequestedIndicator
   * @access public
   */
  public $ItemizedChargesRequestedIndicator = null;

  /**
   * 
   * @param ShipperType $Shipper
   * @param ShipToType $ShipTo
   * @param ShipFromType $ShipFrom
   * @param AlternateDeliveryAddressType $AlternateDeliveryAddress
   * @param IndicationType $ShipmentIndicationType
   * @param FRSPaymentInfoType $FRSPaymentInformation
   * @param CodeDescriptionType $Service
   * @param string $DocumentsOnlyIndicator
   * @param string $NumOfPieces
   * @param PackageType $Package
   * @param ShipmentServiceOptionsType $ShipmentServiceOptions
   * @param ShipmentRatingOptionsType $ShipmentRatingOptions
   * @param InvoiceLineTotalType $InvoiceLineTotal
   * @param string $ItemizedChargesRequestedIndicator
   * @access public
   */
  public function __construct($Shipper = null, $ShipTo = null, $ShipFrom = null, $AlternateDeliveryAddress = null, $ShipmentIndicationType = null, $FRSPaymentInformation = null, $Service = null, $DocumentsOnlyIndicator = null, $NumOfPieces = null, $Package = null, $ShipmentServiceOptions = null, $ShipmentRatingOptions = null, $InvoiceLineTotal = null, $ItemizedChargesRequestedIndicator = null)
  {
    $this->Shipper = $Shipper;
    $this->ShipTo = $ShipTo;
    $this->ShipFrom = $ShipFrom;
    $this->AlternateDeliveryAddress = $AlternateDeliveryAddress;
    $this->ShipmentIndicationType = $ShipmentIndicationType;
    $this->FRSPaymentInformation = $FRSPaymentInformation;
    $this->Service = $Service;
    $this->DocumentsOnlyIndicator = $DocumentsOnlyIndicator;
    $this->NumOfPieces = $NumOfPieces;
    $this->Package = $Package;
    $this->ShipmentServiceOptions = $ShipmentServiceOptions;
    $this->ShipmentRatingOptions = $ShipmentRatingOptions;
    $this->InvoiceLineTotal = $InvoiceLineTotal;
    $this->ItemizedChargesRequestedIndicator = $ItemizedChargesRequestedIndicator;
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
   * @return CodeDescriptionType
   */
  public function getService()
  {
    return $this->Service;
  }

  /**
   * 
   * @param CodeDescriptionType $Service
   */
  public function setService($Service)
  {
    $this->Service = $Service;
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
   * @return string
   */
  public function getNumOfPieces()
  {
    return $this->NumOfPieces;
  }

  /**
   * 
   * @param string $NumOfPieces
   */
  public function setNumOfPieces($NumOfPieces)
  {
    $this->NumOfPieces = $NumOfPieces;
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

  /**
   * 
   * @return ShipmentServiceOptionsType
   */
  public function getShipmentServiceOptions()
  {
    return $this->ShipmentServiceOptions;
  }

  /**
   * 
   * @param ShipmentServiceOptionsType $ShipmentServiceOptions
   */
  public function setShipmentServiceOptions($ShipmentServiceOptions)
  {
    $this->ShipmentServiceOptions = $ShipmentServiceOptions;
  }

  /**
   * 
   * @return ShipmentRatingOptionsType
   */
  public function getShipmentRatingOptions()
  {
    return $this->ShipmentRatingOptions;
  }

  /**
   * 
   * @param ShipmentRatingOptionsType $ShipmentRatingOptions
   */
  public function setShipmentRatingOptions($ShipmentRatingOptions)
  {
    $this->ShipmentRatingOptions = $ShipmentRatingOptions;
  }

  /**
   * 
   * @return InvoiceLineTotalType
   */
  public function getInvoiceLineTotal()
  {
    return $this->InvoiceLineTotal;
  }

  /**
   * 
   * @param InvoiceLineTotalType $InvoiceLineTotal
   */
  public function setInvoiceLineTotal($InvoiceLineTotal)
  {
    $this->InvoiceLineTotal = $InvoiceLineTotal;
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

}
