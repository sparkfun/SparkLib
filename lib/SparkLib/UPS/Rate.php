<?php

namespace SparkLib\UPS;

use SparkLib\UPS\Rate\AddressType,
    SparkLib\UPS\Rate\CodeDescriptionType,
    SparkLib\UPS\Rate\DimensionsType,
    SparkLib\UPS\Rate\InvoiceLineTotalType,
    SparkLib\UPS\Rate\UsernameToken,
    SparkLib\UPS\Rate\PackageType,
    SparkLib\UPS\Rate\PackageWeightType,
    SparkLib\UPS\Rate\ServiceAccessToken,
    SparkLib\UPS\Rate\RateRequest,
    SparkLib\UPS\Rate\RequestType,
    SparkLib\UPS\Rate\ShipperType,
    SparkLib\UPS\Rate\ShipFromType,
    SparkLib\UPS\Rate\ShipmentRatingOptionsType,
    SparkLib\UPS\Rate\ShipToType,
    SparkLib\UPS\Rate\ShipmentType,
    SparkLib\UPS\Rate\UPSSecurity;

use SoapClient,
    SoapHeader,
    SoapFault,
    DOMDocument;

use SparkLib\Fail;

class Rate {

  private $_wsdl = '/Rate/wsdl/RateWS.wsdl';
  private $_schema = 'http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0';
  private $_client;
  private $_options;
  private $_request;
  private $_response;

  private $_shipper;
  private $_shipFrom;
  private $_shipTo;
  private $_shipment;
  private $_international = false;
  private $_PAK = false;
  private $_packages = [];
  private $_requestedServices = [];

  private $_rates = [];

  public $upsCodes = [
    1 => 'Next Day Air',
    2 => '2nd Day Air',
    3 => 'Ground',
    7 => 'Worldwide Express Saver',
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
    $shipmentOptions = new ShipmentRatingOptionsType("Yes", null, null);
    $this->_shipment = new ShipmentType();
    $this->_shipment->setShipmentRatingOptions($shipmentOptions);
  }

  public function addServices() {
  }

  public function allowPakRates() {
    $this->_PAK = true;
  }

  public function addPackage($l, $w, $h, $weight, $value = null, $units_length = 'IN',
                             $units_weight = 'LBS') {

    $package = new PackageType();

    $package->setPackageWeight(
      new PackageWeightType(new CodeDescriptionType($units_weight), $weight)
    );

    if ($this->_PAK && $weight <= constant('\PAK_RATE_THRESHOLD') && $this->_international) {
      $package->setPackagingType(new CodeDescriptionType('04'));
      $InvoiceLineTotal = new InvoiceLineTotalType('USD', $value);
      $this->_shipment->setInvoiceLineTotal($InvoiceLineTotal);
    } else {
      $package->setPackagingType(new CodeDescriptionType('02'));
      $package->setDimensions(
        new DimensionsType(new CodeDescriptionType($units_length), $l, $w, $h)
      );
    }

    array_push($this->_packages, $package);
  }

  public function setShipper($name, $street, $city, $state, $postal,
                             $country, $account = null) {
    $shipperAddress = new AddressType($street, $city, $state, $postal, $country);
    $this->_shipper  = new ShipperType($name, $account, $shipperAddress);
  }

  public function setShipFrom($name, $street, $city, $state, $postal,
                             $country, $account = null) {
    $shipFromAddress = new AddressType($street, $city, $state, $postal, $country);
    $this->_shipFrom  = new ShipFromType($name, $shipFromAddress);
  }

  public function setShipTo($name, $street, $city, $state, $postal,
                             $country, $account = null) {

    if ($country == 'US') {
      $postal = substr(preg_replace('/[^0-9]+/', '', $postal), 0, 5);
    } else if ($country == 'CA') {
      $postal = substr(preg_replace('/[^0-9A-Za-z]+/', '', $postal), 0, 6);
      $this->_international = true;
    } else {
      $postal = substr(preg_replace('/[^0-9A-Za-z]+/', '', $postal), 0, 9);
      $this->_international = true;
    }

    $shipToAddress = new AddressType($street, $city, $state, $postal, $country);
    $this->_shipTo  = new ShipToType($name, $shipToAddress);
  }

  public function sendRequest() {

    $this->_shipment->setShipper($this->_shipper);
    $this->_shipment->setShipFrom($this->_shipFrom);
    $this->_shipment->setShipTo($this->_shipTo);
    $this->_shipment->setPackage($this->_packages);

    $RequestType = new RequestType('Shop');
    $this->_request = new RateRequest($RequestType, new CodeDescriptionType('01'),
                                      null, $this->_shipment);

    $UsernameToken      = new UsernameToken();
    $ServiceAccessToken = new ServiceAccessToken();
    $UPSSecurity        = new UPSSecurity($UsernameToken, $ServiceAccessToken);

    $UsernameToken->setUsername(UPS_USERID);
    $UsernameToken->setPassword(UPS_USERPASS);

    $ServiceAccessToken->setAccessLicenseNumber(UPS_APIKEY);

    $header = new SoapHeader($this->_schema, 'UPSSecurity', $UPSSecurity);

    $this->_options = [
      'soap_version' => 'SOAP_1_1',
      'exceptions'   => true,
      'location'     => UPS_SERVER_RATE,
      'trace'        => true
    ];

    $wsdl = __DIR__ . $this->_wsdl;

    $this->_client = new SoapClient($wsdl, $this->_options);
    $this->_client->__setSoapHeaders($header);

    try {
      $this->_response = $this->_client->ProcessRate($this->_request, $this->_options);
    } catch (SoapFault $s) {
      if (isset($s->detail)) {
        $err = $s->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
        Fail::log("UPS API Error: $err");
      }
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
    $request = $this->_client->__getLastResponse();

    if ($request) {
      $dom = new DOMDocument;
      $dom->preserveWhiteSpace = FALSE;
      $dom->formatOutput = TRUE;
      $dom->loadXML($request);
      return $dom->saveXml();
    }
  }

  public function getRate($rate_code) {

  }

  public function getRates() {

    if ($this->_response) {
      $rates = $this->_response->RatedShipment;

      foreach ($rates as $rate) {
        $rateArr = [];

        $code = intval($rate->Service->Code);
        $rateArr['code']    = $code;
        $rateArr['service'] = $this->upsCodes[$code];
        $rateArr['charge']  = floatval($rate->TotalCharges->MonetaryValue);
        $rateArr['negotiated_charge']  = floatval($rate->NegotiatedRateCharges->TotalCharge->MonetaryValue);


        array_push($this->_rates, $rateArr);
      }
    }

    return $this->_rates;

  }

}
