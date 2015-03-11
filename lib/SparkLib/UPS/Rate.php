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
    SparkLib\UPS\Rate\RateException,
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

  const REQ_SHOP = 1;
  const REQ_RATE = 2;

  private $_schema    = UPS_SCHEMA;
  private $_wsdl      = UPS_RATE_WSDL;
  private $_endpoint  = UPS_RATE_SERVER;
  private $_user      = UPS_USERID;
  private $_pass      = UPS_USERPASS;
  private $_apikey    = UPS_APIKEY;

  private $_client;
  private $_request;
  private $_response;

  private $_shipper;
  private $_shipFrom;
  private $_shipTo;
  private $_shipment;

  private $_international;
  private $_pakRates;
  private $_packages;
  private $_service;

  private static $upsServices = [
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
    65 => 'UPS Saver',
    93 => 'UPS SurePost',
    82 => 'UPS Today Standard',
    83 => 'UPS Today Dedicated Courier',
    84 => 'UPS Today Intercity',
    85 => 'UPS Today Express',
    86 => 'UPS Today Express Saver',
    96 => 'UPS Worldwide Express Freight',
  ];

  public function __construct() {
    $shipmentOptions = new ShipmentRatingOptionsType("Yes", null, null);
    $this->_shipment = new ShipmentType();
    $this->_shipment->setShipmentRatingOptions($shipmentOptions);

    $this->_international = false;
    $this->_pakRatesRates = false;
    $this->_packages      = [];
  }

  public function addService($serviceCode) {
    if (! array_key_exists($serviceCode, static::$upsServices))
      throw new RateException('Invalid service code');

    $this->_service = $serviceCode;
  }

  public function allowPakRates() {
    $this->_pakRates = true;
  }

  public function addPackage($l, $w, $h, $weight, $value = null, $units_length = 'IN',
                             $units_weight = 'LBS') {

    $package = new PackageType();

    $package->setPackageWeight(
      new PackageWeightType(new CodeDescriptionType($units_weight), $weight)
    );

    if ($this->_pakRates && $this->_international) {
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

    if ($this->_service === null) {
      $RequestType = new RequestType('Shop');
    } else {
      $RequestType = new RequestType('Rate');
      $ServiceType = new CodeDescriptionType($this->_service);
      $this->_shipment->setService($ServiceType);
    }

    $this->_request = new RateRequest($RequestType, new CodeDescriptionType('01'),
                                      null, $this->_shipment);

    $UsernameToken      = new UsernameToken();
    $ServiceAccessToken = new ServiceAccessToken();
    $UPSSecurity        = new UPSSecurity($UsernameToken, $ServiceAccessToken);

    $UsernameToken->setUsername($this->_user);
    $UsernameToken->setPassword($this->_pass);

    $ServiceAccessToken->setAccessLicenseNumber($this->_apikey);

    $header = new SoapHeader($this->_schema, 'UPSSecurity', $UPSSecurity);

    $options = [
      'soap_version' => 'SOAP_1_1',
      'exceptions'   => true,
      'location'     => $this->_endpoint,
      'trace'        => true
    ];

    $this->_client = new SoapClient($this->_wsdl, $options);
    $this->_client->__setSoapHeaders($header);

    try {
      $this->_response = $this->_client->ProcessRate($this->_request, $options);
    } catch (SoapFault $s) {
      if (isset($s->detail)) {
        $err = $s->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
        throw new RateException($err);
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

  public function getRates() {

    if ($this->_service === null && $this->_response) {
      $rates = [];

      foreach ($this->_response->RatedShipment as $rate) {
        $r = [];
        $code = intval($rate->Service->Code);

        $r['code']    = $code;
        $r['service'] = static::getAPIDisplayName($code);
        $r['charge']  = floatval($rate->TotalCharges->MonetaryValue);
        $r['negotiated_charge']  = floatval($rate->NegotiatedRateCharges->TotalCharge->MonetaryValue);

        array_push($rates, $r);
      }

      return $rates;
    } else if ($this->_response) {
      return $this->getRate();
    }
  }

  public function getRate() {
    if ($this->_service !== null && $this->_response) {
      return [[
        'code' => $this->_service,
        'service' => static::getAPIDisplayName($this->_service),
        'charge' => $this->_response->RatedShipment->TotalCharges->MonetaryValue,
        'negotiated_charge' => $this->_response->RatedShipment->NegotiatedRateCharges->TotalCharge->MonetaryValue
      ]];
    }
  }

  public static function getAPIDisplayName($ups_code) {
    if (array_key_exists($ups_code, static::$upsServices))
      return static::$upsServices[$ups_code];
    return 'Unknown';
  }

}
