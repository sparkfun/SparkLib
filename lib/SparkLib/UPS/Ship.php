<?php

namespace SparkLib\UPS;

use SparkLib\UPS\Ship\AddressType,
    SparkLib\UPS\Ship\BillShipperType,
    SparkLib\UPS\Ship\CodeDescriptionType,
    SparkLib\UPS\Ship\ContactType,
    SparkLib\UPS\Ship\CurrencyMonetaryType,
    SparkLib\UPS\Ship\DimensionsType,
    SparkLib\UPS\Ship\InternationalFormType,
    SparkLib\UPS\Ship\LabelImageFormatType,
    SparkLib\UPS\Ship\LabelStockSizeType,
    SparkLib\UPS\Ship\LabelSpecificationType,
    SparkLib\UPS\Ship\PackageDeclaredValueType,
    SparkLib\UPS\Ship\PackageServiceOptionsType,
    SparkLib\UPS\Ship\PackageType,
    SparkLib\UPS\Ship\PackageWeightType,
    SparkLib\UPS\Ship\PaymentInfoType,
    SparkLib\UPS\Ship\PhoneType,
    SparkLib\UPS\Ship\ProductType,
    SparkLib\UPS\Ship\ProducerType,
    SparkLib\UPS\Ship\ProductWeightType,
    SparkLib\UPS\Ship\RateInfoType,
    SparkLib\UPS\Ship\ReferenceNumberType,
    SparkLib\UPS\Ship\RequestType,
    SparkLib\UPS\Ship\ServiceAccessToken,
    SparkLib\UPS\Ship\ServiceType,
    SparkLib\UPS\Ship\ShipperType,
    SparkLib\UPS\Ship\ShipAddressType,
    SparkLib\UPS\Ship\ShipFromType,
    SparkLib\UPS\Ship\ShipToType,
    SparkLib\UPS\Ship\ShipmentChargeType,
    SparkLib\UPS\Ship\ShipmentType,
    SparkLib\UPS\Ship\ShipmentRequest,
    SparkLib\UPS\Ship\ShipmentServiceOptionsType,
    SparkLib\UPS\Ship\SoldToType,
    SparkLib\UPS\Ship\UltimateConsigneeType,
    SparkLib\UPS\Ship\UnitOfMeasurementType,
    SparkLib\UPS\Ship\UnitType,
    SparkLib\UPS\Ship\UPSSecurity,
    SparkLib\UPS\Ship\UsernameToken;

use Exception,
    SoapClient,
    SoapHeader,
    SoapFault,
    DOMDocument;

class Ship {

  private $_wsdl = '/Ship/wsdl/Ship.wsdl';
  private $_schema = 'http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0';
  private $_client;
  private $_options;
  private $_request;
  private $_response;
  private $_destination;

  private $_lineItems;
  private $_serviceType;
  private $_shipper;
  private $_international;
  private $_PAK = false;
  private $_shipFrom;
  private $_shipTo;
  private $_shipmentMethod;
  private $_payment;
  private $_label;
  private $_totalValue;
  private $_package;
  private $_packages = [];
  private $_products = [];

  private $_rates = [];

  public $upsCodes = [
    1 => 'Next Day Air',
    2 => '2nd Day Air',
    3 => 'Ground',
    7 => 'Worldwide Express',
    8 => 'Worldwide Expedited',
    11 => 'Standard',
    12 => '3 Day Select',
    13 => 'Next Day Air Saver',
    14 => 'Next Day Air Early AM',
    59 => '2nd Day Air AM',
    54 => 'Worldwide Express Plus',
    65 => 'UPS Saver'
  ];

  public function __construct() {
    $Request                  = new RequestType();
    $Shipment                 = new ShipmentType();
    $LabelSpecification       = new LabelSpecificationType();

    $this->_request = new ShipmentRequest($Request, $Shipment, $LabelSpecification);

    $this->_totalValue = 0;
  }

  public function setDestination($dest) {
    $this->_destination = $dest;
  }

  public function allowPakRates() {
    $this->_PAK = true;
  }

  public function createPackage() {
    if ($this->_package instanceOf PackageType)
      throw new Exception ('Add current package before creating a new one.');
    $this->_package = new PackageType();
  }

  public function setPackageSize($l, $w, $h, $units = 'IN') {
    if ($this->_package == null)
      throw new Exception ('Create package before setting size.');

    if ($this->_international === null)
      throw new Exception ('Set shipment destination before adding packages');

    $weight = $this->_package->PackageWeight->Weight;

    if (! isset($weight))
      throw new Exception ('Set package weight before setting size');

    if ($this->_PAK && $this->_international && $weight <= constant('\PAK_RATE_THRESHOLD')) {
      $this->_package->setPackaging(new CodeDescriptionType('04'));
    } else {
      $this->_package->setPackaging(new CodeDescriptionType('02'));
      $this->_package->setDimensions(
        new DimensionsType(new CodeDescriptionType($units), $l, $w, $h)
      );
    }
  }

  public function setPackageWeight($weight, $units = 'LBS') {

    if ($this->_package == null)
      throw new Exception ('Create package before setting weight.');

    $this->_package->setPackageWeight(
      new PackageWeightType(new CodeDescriptionType($units), $weight)
    );
  }

  public function setPackageValue($value = null) {

    if ($this->_package == null)
      throw new Exception ('Create package before setting value.');

    $DeclaredValue = new PackageDeclaredValueType();
    $DeclaredValue->setCurrencyCode('USD');

    if ($value)
      $DeclaredValue->setMonetaryValue($value);
    else
      $DeclaredValue->setMonetaryValue($this->_totalValue);

    $PackageServiceOptions = new PackageServiceOptionsType();
    $PackageServiceOptions->setDeclaredValue($DeclaredValue);

    $this->_package->setPackageServiceOptions($PackageServiceOptions);
  }

  public function setReferenceNumber($num) {

    $ReferenceNumber = new ReferenceNumberType();
    $ReferenceNumber->setValue($num);
    $ReferenceNumber->setBarCodeIndicator(true);

    if ($this->_international) {
      $this->_request->Shipment->setReferenceNumber($ReferenceNumber);
    } else if (count($this->_packages) == 0) {
      throw new Exception ('Add packages before setting reference number.');
    } else {
      foreach ($this->_packages as &$package)
        $package->setReferenceNumber($ReferenceNumber);
    }
  }

  public function addPackage() {
    array_push($this->_packages, $this->_package);
    $this->_package = null;
  }

  public function addItem($value, $qty = 1, $desc = 'Merchandise',
                          $tariff = '', $origin = 'US') {

    if (count($this->_products) < 50) {
      // Sanitize description
      $desc = substr(preg_replace("/[^\w\d ]/i", '', $desc), 0, 35);

      // Make sure value isn't too precise
      $value = round($value, 6);

      $this->_totalValue += $value;

      $product = new ProductType();
      $measure = new UnitOfMeasurementType('PCS');
      $units   = new UnitType($qty, $measure, $value);
      $product->setDescription($desc);
      $product->setUnit($units);
      $product->setCommodityCode($tariff);
      $product->setOriginCountryCode($origin);

      array_push($this->_products, $product);
    }
  }

  /**
   * Functions for handling Shipper node.
   */
  private function initShipper() {
    if (!isset($this->_shipper))
      $this->_shipper = new ShipperType();
  }

  public function setShipperAddress($street, $city, $state, $postal,
                                    $country, $account) {
    $this->initShipper();
    $this->initForms();

    $address = new ShipAddressType($street, $city, $state, $postal, $country);

    $this->_shipper->setAddress($address);
    $this->_shipper->setShipperNumber($account);

    $Address = new AddressType($street, $city, $state, null, $postal, $country);
    $this->_request->Shipment
                   ->ShipmentServiceOptions
                   ->InternationalForms
                   ->Contacts
                   ->Producer
                   ->setAddress($Address);
  }

  public function setShipperPhone($phone) {
      $phone = preg_replace('/[^0-9]/', '', $phone);

      $this->initShipper();
      $this->_shipper->setPhone(new PhoneType($phone));
  }

  public function setShipperName($name, $company = null) {
    $this->initShipper();
    $this->initForms();

    if ($company) {
      $this->_shipper->setName($company);
      $this->_shipper->setAttentionName($name);
      $this->_shipper->setCompanyDisplayableName($company);

      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->Producer
                     ->setCompanyName($company);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->Producer
                     ->setAttentionName($name);
    } else {
      $this->_shipper->setName($name);
      $this->_shipper->setAttentionName($name);
      $this->_shipper->setCompanyDisplayableName($name);

      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->Producer
                     ->setCompanyName($name);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->Producer
                     ->setAttentionName($name);
    }
  }

  public function setShipperTaxID($taxId) {
    $this->initShipper();
    $this->_shipper->setTaxIdentificationNumber($taxId);
  }

  public function setShipperEmail($email) {
    $this->initShipper();
    $this->_shipper->setEMailAddress($email);
  }

  /**
   * Functions for handling ShipFrom node.
   */
  private function initShipFrom() {
    if (!isset($this->_shipFrom))
      $this->_shipFrom = new ShipFromType();
  }

  public function setShipFromAddress($street, $city, $state, $postal,
                                     $country) {
    $this->initShipFrom();
    $address = new ShipAddressType($street, $city, $state, $postal, $country);
    $this->_shipFrom->setAddress($address);
  }

  public function setShipFromPhone($phone) {
      $phone = preg_replace('/[^0-9]/', '', $phone);

      $this->initShipFrom();
      $this->_shipFrom->setPhone(new PhoneType($phone));
  }

  public function setShipFromName($name, $company = null) {
    $this->initShipFrom();

    if ($company) {
      $this->_shipFrom->setName($company);
      $this->_shipFrom->setAttentionName($name);
      $this->_shipFrom->setCompanyDisplayableName($company);
    } else {
      $this->_shipFrom->setName($name);
      $this->_shipFrom->setAttentionName($name);
      $this->_shipFrom->setCompanyDisplayableName($name);
    }
  }

  public function setShipFromTaxID($taxId) {
    $this->initShipFrom();
    $this->_shipFrom->setTaxIdentificationNumber($taxId);
  }

  /**
   * Functions for handling ShipTo node.
   */
  private function initShipTo() {
    if (!isset($this->_shipTo))
      $this->_shipTo = new ShipToType();
  }

  public function setShipToAddress($street, $city, $state, $postal, $country) {
    $this->initShipTo();
    $this->initForms();

    // Do some really basic validation on the postal code
    if ($country == 'US') {
      $postal = substr(preg_replace('/[^0-9]+/', '', $postal), 0, 5);
      $this->_international = false;
    } else if ($country == 'CA') {
      $postal = substr(preg_replace('/[^0-9A-Za-z]+/', '', $postal), 0, 6);
      $this->_international = true;
    } else {
      $postal = substr(preg_replace('/[^0-9A-Za-z]+/', '', $postal), 0, 9);
      $this->_international = true;
    }

    // Street cannot be more than 35 characters long
    if (is_array($street))
      foreach ($street as &$s)
        $s = substr($s, 0, 35);
    else
      $street = substr($street, 0, 35);

    // Only US and Canada should have the state field set.
    // Ireland should be set to IE because they don't have postal codes.
    if ($country == 'IE')
      $state = 'IE';
    else if (! ($country == 'US' || $country == 'CA'))
      $state = null;

    $ShipAddress = new ShipAddressType($street, $city, $state, $postal, $country);
    $this->_shipTo->setAddress($ShipAddress);

    $UltimateConsigneeAddress = new AddressType($street, $city, $state, null, $postal, $country);
    $this->_request->Shipment
                   ->ShipmentServiceOptions
                   ->InternationalForms
                   ->Contacts
                   ->UltimateConsignee
                   ->setAddress($UltimateConsigneeAddress);

    $SoldToAddress = new AddressType($street, $city, $state, null, $postal, $country);
    $this->_request->Shipment
                   ->ShipmentServiceOptions
                   ->InternationalForms
                   ->Contacts
                   ->SoldTo
                   ->setAddress($SoldToAddress);
  }

  public function setShipToPhone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if ($phone) {
      $this->initShipTo();
      $this->_shipTo->setPhone(new PhoneType($phone));
    }
  }

  public function setShipToName($name, $company = null) {
    $this->initShipTo();
    $this->initForms();

    $name = substr($name, 0, 35);

    if ($company) {
      $company = substr($company, 0, 35);

      $this->_shipTo->setName($company);
      $this->_shipTo->setAttentionName($name);
      $this->_shipTo->setCompanyDisplayableName($company);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->UltimateConsignee
                     ->setCompanyName($company);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->SoldTo
                     ->setName($company);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->SoldTo
                     ->setAttentionName($name);
    } else {
      $this->_shipTo->setName($name);
      $this->_shipTo->setAttentionName($name);
      $this->_shipTo->setCompanyDisplayableName($name);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->UltimateConsignee
                     ->setCompanyName($name);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->SoldTo
                     ->setName($name);
      $this->_request->Shipment
                     ->ShipmentServiceOptions
                     ->InternationalForms
                     ->Contacts
                     ->SoldTo
                     ->setAttentionName($name);
    }
  }

  public function setShipToEmail($email) {
    $this->initShipTo();
    $this->_shipTo->setEMailAddress($email);
  }

  public function addShipmentAccount($account) {
    $transportation = new ShipmentChargeType();
    $transportation->setType('01');
    $transportation->setBillShipper(new BillShipperType($account));

    $this->_payment = new PaymentInfoType($transportation);
  }

  public function setShippingMethod($serviceCode) {
    $this->_serviceType = new ServiceType($serviceCode);
  }

  private function initForms() {
    if (!isset($this->_request->Shipment->ShipmentServiceOptions->InternationalForms)) {

      $Producer           = new ProducerType();
      $UltimateConsignee  = new UltimateConsigneeType();
      $SoldTo             = new SoldToType();

      $Contacts = new ContactType();
      $Contacts->setProducer($Producer);
      $Contacts->setUltimateConsignee($UltimateConsignee);
      $Contacts->setSoldTo($SoldTo);

      $InternationalForm = new InternationalFormType();
      $InternationalForm->setFormType('01');
      $InternationalForm->setReasonForExport('SALE');
      $InternationalForm->setCurrencyCode('USD');
      $InternationalForm->setContacts($Contacts);

      $ShipmentServiceOptions = new ShipmentServiceOptionsType();
      $ShipmentServiceOptions->setInternationalForms($InternationalForm);

      $this->_request->Shipment->setShipmentServiceOptions($ShipmentServiceOptions);
    }
  }

  public function setInvoice($date = null, $number = '') {
    $this->initForms();

    if ($date == null)
      $date = date('Ymd');
    else if (is_string($date))
      $date = date('Ymd', strtotime($date));
    else
      $date = date('Ymd', $date);


    $InternationalForm = new InternationalFormType();
    $InternationalForm->setFormType('01');

    $ShipmentServiceOptions = new ShipmentServiceOptionsType();
    $ShipmentServiceOptions->setInternationalForms($InternationalForm);

    $this->_request->Shipment
                   ->ShipmentServiceOptions
                   ->InternationalForms
                   ->setInvoiceDate($date);
    $this->_request->Shipment
                   ->ShipmentServiceOptions
                   ->InternationalForms
                   ->setInvoiceNumber($number);
  }

  public function useNegotiatedRates() {
    $rateInfo = new RateInfoType();
    $rateInfo->setNegotiatedRatesIndicator(true);
    $this->_request->Shipment->setShipmentRatingOptions($rateInfo);
  }

  private function setTotal() {
    if ($this->_destination == 'CA') {
      $invoiceLineTotal = new CurrencyMonetaryType();
      $invoiceLineTotal->setCurrencyCode('USD');
      $invoiceLineTotal->setMonetaryValue(ceil($this->_totalValue));
      $this->_request->Shipment->setInvoiceLineTotal($invoiceLineTotal);
    }
  }

  public function ship() {

    $this->_request->Request->setRequestOption('validate');

    $this->initForms();

    $this->_request->Shipment->setService($this->_serviceType);
    $this->_request->Shipment->setDescription('Electronics');
    $this->_request->Shipment->setShipper($this->_shipper);
    $this->_request->Shipment->setShipFrom($this->_shipFrom);
    $this->_request->Shipment->setShipTo($this->_shipTo);
    $this->_request->Shipment->setPackage($this->_packages);
    $this->_request->Shipment->setPaymentInformation($this->_payment);
    $this->_request->Shipment
                   ->ShipmentServiceOptions
                   ->InternationalForms
                   ->setProduct($this->_products);

    $this->setTotal();

    $UsernameToken      = new UsernameToken();
    $ServiceAccessToken = new ServiceAccessToken();
    $UPSSecurity        = new UPSSecurity($UsernameToken, $ServiceAccessToken);

    $UsernameToken->setUsername(UPS_USERID);
    $UsernameToken->setPassword(UPS_USERPASS);

    $ServiceAccessToken->setAccessLicenseNumber(UPS_APIKEY);

    $header = new SoapHeader($this->_schema, 'UPSSecurity', $UPSSecurity);

    $this->_options = [
      'soap_version'  => 'SOAP_1_1',
      'exceptions'    => true,
      'trace'         => true,
      'location'      => UPS_SERVER_SHIP
    ];

    $wsdl = __DIR__ . $this->_wsdl;

    $this->_client = new SoapClient($wsdl, $this->_options);
    $this->_client->__setSoapHeaders($header);

    try {
      $this->_response = $this->_client->ProcessShipment($this->_request, $this->_options);
    } catch (SoapFault $s) {
      if (isset($s->detail)) {
        $err = $s->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
        throw new Exception($err);
      }
    }
  }

  public function setLabelFormat($formatCode = 'ZPL') {
    // This is _required_, with these specific values, but has no effect
    $LabelStockSize = new LabelStockSizeType('6', '4');
    $LabelImageFormat = new LabelImageFormatType($formatCode);

    $this->_request->LabelSpecification->setLabelImageFormat($LabelImageFormat);
    $this->_request->LabelSpecification->setLabelStockSize($LabelStockSize);
  }

  public function getLabelImage() {
    if ($this->_response) {
      $img = $this->_response->ShipmentResults->PackageResults->ShippingLabel->GraphicImage;
      return base64_decode($img);
    }
  }

  public function getTrackingNumber() {
    if ($this->_response)
      return $this->_response->ShipmentResults->PackageResults->TrackingNumber;
  }

  public function getCharge() {
    if ($this->_response)
      return $this->_response->ShipmentResults->PackageResults->ServiceOptionsCharges->MonetaryValue;
  }

  public function getInvoice() {
    if ($this->_response) {
      $img = $this->_response->ShipmentResults->Form->Image->GraphicImage;
      return base64_decode($img);
    }
  }

  public function getLastRequest() {
    $request = $this->_client->__getLastRequest();

    if ($request) {
      $dom = new DOMDocument;
      $dom->preserveWhiteSpace = FALSE;
      $dom->formatOutput = TRUE;
      $dom->loadXML($request);
      return $dom->saveXml();
    }
  }

  public function getLastResponse() {
    $response = $this->_client->__getLastResponse();

    if ($response) {
      $dom = new DOMDocument;
      $dom->preserveWhiteSpace = FALSE;
      $dom->formatOutput = TRUE;
      $dom->loadXML($response);
      return $dom->saveXml();
    }
  }

}
