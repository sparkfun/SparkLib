<?php

namespace SparkLib\UPS\Rate;

class ShipmentServiceOptionsType
{

  /**
   * 
   * @var string $SaturdayPickupIndicator
   * @access public
   */
  public $SaturdayPickupIndicator = null;

  /**
   * 
   * @var string $SaturdayDeliveryIndicator
   * @access public
   */
  public $SaturdayDeliveryIndicator = null;

  /**
   * 
   * @var OnCallPickupType $OnCallPickup
   * @access public
   */
  public $OnCallPickup = null;

  /**
   * 
   * @var CODType $COD
   * @access public
   */
  public $COD = null;

  /**
   * 
   * @var DeliveryConfirmationType $DeliveryConfirmation
   * @access public
   */
  public $DeliveryConfirmation = null;

  /**
   * 
   * @var string $ReturnOfDocumentIndicator
   * @access public
   */
  public $ReturnOfDocumentIndicator = null;

  /**
   * 
   * @var string $UPScarbonneutralIndicator
   * @access public
   */
  public $UPScarbonneutralIndicator = null;

  /**
   * 
   * @var string $CertificateOfOriginIndicator
   * @access public
   */
  public $CertificateOfOriginIndicator = null;

  /**
   * 
   * @var PickupOptionsType $PickupOptions
   * @access public
   */
  public $PickupOptions = null;

  /**
   * 
   * @var DeliveryOptionsType $DeliveryOptions
   * @access public
   */
  public $DeliveryOptions = null;

  /**
   * 
   * @var RestrictedArticlesType $RestrictedArticles
   * @access public
   */
  public $RestrictedArticles = null;

  /**
   * 
   * @var string $ShipperExportDeclarationIndicator
   * @access public
   */
  public $ShipperExportDeclarationIndicator = null;

  /**
   * 
   * @var string $CommercialInvoiceRemovalIndicator
   * @access public
   */
  public $CommercialInvoiceRemovalIndicator = null;

  /**
   * 
   * @var ImportControlType $ImportControl
   * @access public
   */
  public $ImportControl = null;

  /**
   * 
   * @var ReturnServiceType $ReturnService
   * @access public
   */
  public $ReturnService = null;

  /**
   * 
   * @var string $SDLShipmentIndicator
   * @access public
   */
  public $SDLShipmentIndicator = null;

  /**
   * 
   * @param string $SaturdayPickupIndicator
   * @param string $SaturdayDeliveryIndicator
   * @param OnCallPickupType $OnCallPickup
   * @param CODType $COD
   * @param DeliveryConfirmationType $DeliveryConfirmation
   * @param string $ReturnOfDocumentIndicator
   * @param string $UPScarbonneutralIndicator
   * @param string $CertificateOfOriginIndicator
   * @param PickupOptionsType $PickupOptions
   * @param DeliveryOptionsType $DeliveryOptions
   * @param RestrictedArticlesType $RestrictedArticles
   * @param string $ShipperExportDeclarationIndicator
   * @param string $CommercialInvoiceRemovalIndicator
   * @param ImportControlType $ImportControl
   * @param ReturnServiceType $ReturnService
   * @param string $SDLShipmentIndicator
   * @access public
   */
  public function __construct($SaturdayPickupIndicator = null, $SaturdayDeliveryIndicator = null, $OnCallPickup = null, $COD = null, $DeliveryConfirmation = null, $ReturnOfDocumentIndicator = null, $UPScarbonneutralIndicator = null, $CertificateOfOriginIndicator = null, $PickupOptions = null, $DeliveryOptions = null, $RestrictedArticles = null, $ShipperExportDeclarationIndicator = null, $CommercialInvoiceRemovalIndicator = null, $ImportControl = null, $ReturnService = null, $SDLShipmentIndicator = null)
  {
    $this->SaturdayPickupIndicator = $SaturdayPickupIndicator;
    $this->SaturdayDeliveryIndicator = $SaturdayDeliveryIndicator;
    $this->OnCallPickup = $OnCallPickup;
    $this->COD = $COD;
    $this->DeliveryConfirmation = $DeliveryConfirmation;
    $this->ReturnOfDocumentIndicator = $ReturnOfDocumentIndicator;
    $this->UPScarbonneutralIndicator = $UPScarbonneutralIndicator;
    $this->CertificateOfOriginIndicator = $CertificateOfOriginIndicator;
    $this->PickupOptions = $PickupOptions;
    $this->DeliveryOptions = $DeliveryOptions;
    $this->RestrictedArticles = $RestrictedArticles;
    $this->ShipperExportDeclarationIndicator = $ShipperExportDeclarationIndicator;
    $this->CommercialInvoiceRemovalIndicator = $CommercialInvoiceRemovalIndicator;
    $this->ImportControl = $ImportControl;
    $this->ReturnService = $ReturnService;
    $this->SDLShipmentIndicator = $SDLShipmentIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getSaturdayPickupIndicator()
  {
    return $this->SaturdayPickupIndicator;
  }

  /**
   * 
   * @param string $SaturdayPickupIndicator
   */
  public function setSaturdayPickupIndicator($SaturdayPickupIndicator)
  {
    $this->SaturdayPickupIndicator = $SaturdayPickupIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getSaturdayDeliveryIndicator()
  {
    return $this->SaturdayDeliveryIndicator;
  }

  /**
   * 
   * @param string $SaturdayDeliveryIndicator
   */
  public function setSaturdayDeliveryIndicator($SaturdayDeliveryIndicator)
  {
    $this->SaturdayDeliveryIndicator = $SaturdayDeliveryIndicator;
  }

  /**
   * 
   * @return OnCallPickupType
   */
  public function getOnCallPickup()
  {
    return $this->OnCallPickup;
  }

  /**
   * 
   * @param OnCallPickupType $OnCallPickup
   */
  public function setOnCallPickup($OnCallPickup)
  {
    $this->OnCallPickup = $OnCallPickup;
  }

  /**
   * 
   * @return CODType
   */
  public function getCOD()
  {
    return $this->COD;
  }

  /**
   * 
   * @param CODType $COD
   */
  public function setCOD($COD)
  {
    $this->COD = $COD;
  }

  /**
   * 
   * @return DeliveryConfirmationType
   */
  public function getDeliveryConfirmation()
  {
    return $this->DeliveryConfirmation;
  }

  /**
   * 
   * @param DeliveryConfirmationType $DeliveryConfirmation
   */
  public function setDeliveryConfirmation($DeliveryConfirmation)
  {
    $this->DeliveryConfirmation = $DeliveryConfirmation;
  }

  /**
   * 
   * @return string
   */
  public function getReturnOfDocumentIndicator()
  {
    return $this->ReturnOfDocumentIndicator;
  }

  /**
   * 
   * @param string $ReturnOfDocumentIndicator
   */
  public function setReturnOfDocumentIndicator($ReturnOfDocumentIndicator)
  {
    $this->ReturnOfDocumentIndicator = $ReturnOfDocumentIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getUPScarbonneutralIndicator()
  {
    return $this->UPScarbonneutralIndicator;
  }

  /**
   * 
   * @param string $UPScarbonneutralIndicator
   */
  public function setUPScarbonneutralIndicator($UPScarbonneutralIndicator)
  {
    $this->UPScarbonneutralIndicator = $UPScarbonneutralIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getCertificateOfOriginIndicator()
  {
    return $this->CertificateOfOriginIndicator;
  }

  /**
   * 
   * @param string $CertificateOfOriginIndicator
   */
  public function setCertificateOfOriginIndicator($CertificateOfOriginIndicator)
  {
    $this->CertificateOfOriginIndicator = $CertificateOfOriginIndicator;
  }

  /**
   * 
   * @return PickupOptionsType
   */
  public function getPickupOptions()
  {
    return $this->PickupOptions;
  }

  /**
   * 
   * @param PickupOptionsType $PickupOptions
   */
  public function setPickupOptions($PickupOptions)
  {
    $this->PickupOptions = $PickupOptions;
  }

  /**
   * 
   * @return DeliveryOptionsType
   */
  public function getDeliveryOptions()
  {
    return $this->DeliveryOptions;
  }

  /**
   * 
   * @param DeliveryOptionsType $DeliveryOptions
   */
  public function setDeliveryOptions($DeliveryOptions)
  {
    $this->DeliveryOptions = $DeliveryOptions;
  }

  /**
   * 
   * @return RestrictedArticlesType
   */
  public function getRestrictedArticles()
  {
    return $this->RestrictedArticles;
  }

  /**
   * 
   * @param RestrictedArticlesType $RestrictedArticles
   */
  public function setRestrictedArticles($RestrictedArticles)
  {
    $this->RestrictedArticles = $RestrictedArticles;
  }

  /**
   * 
   * @return string
   */
  public function getShipperExportDeclarationIndicator()
  {
    return $this->ShipperExportDeclarationIndicator;
  }

  /**
   * 
   * @param string $ShipperExportDeclarationIndicator
   */
  public function setShipperExportDeclarationIndicator($ShipperExportDeclarationIndicator)
  {
    $this->ShipperExportDeclarationIndicator = $ShipperExportDeclarationIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getCommercialInvoiceRemovalIndicator()
  {
    return $this->CommercialInvoiceRemovalIndicator;
  }

  /**
   * 
   * @param string $CommercialInvoiceRemovalIndicator
   */
  public function setCommercialInvoiceRemovalIndicator($CommercialInvoiceRemovalIndicator)
  {
    $this->CommercialInvoiceRemovalIndicator = $CommercialInvoiceRemovalIndicator;
  }

  /**
   * 
   * @return ImportControlType
   */
  public function getImportControl()
  {
    return $this->ImportControl;
  }

  /**
   * 
   * @param ImportControlType $ImportControl
   */
  public function setImportControl($ImportControl)
  {
    $this->ImportControl = $ImportControl;
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
  public function getSDLShipmentIndicator()
  {
    return $this->SDLShipmentIndicator;
  }

  /**
   * 
   * @param string $SDLShipmentIndicator
   */
  public function setSDLShipmentIndicator($SDLShipmentIndicator)
  {
    $this->SDLShipmentIndicator = $SDLShipmentIndicator;
  }

}
