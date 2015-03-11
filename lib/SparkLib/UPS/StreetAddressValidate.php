<?php

namespace SparkLib\UPS;

use SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType,
    SparkLib\UPS\StreetAddressValidate\RequestType,
    SparkLib\UPS\StreetAddressValidate\ServiceAccessToken,
    SparkLib\UPS\StreetAddressValidate\StreetAddressValidateException,
    SparkLib\UPS\StreetAddressValidate\UPSSecurity,
    SparkLib\UPS\StreetAddressValidate\UsernameToken,
    SparkLib\UPS\StreetAddressValidate\XAVRequest;

use DOMDocument,
    SoapClient,
    SoapHeader,
    SoapFault;

class StreetAddressValidate {

  const UNKNOWN     = 0;
  const COMMERCIAL  = 1;
  const RESIDENTIAL = 2;

  const INVALID   = 0;
  const VALID     = 1;
  const AMBIGUOUS = 2;

  const OPTION_VALIDATE = 1;
  const OPTION_CLASSIFY = 2;
  const OPTION_BOTH     = 3;

  private $_wsdl      = UPS_XAV_WSDL;
  private $_endpoint  = UPS_XAV_SERVER;
  private $_schema    = UPS_SCHEMA;
  private $_user      = UPS_USERID;
  private $_pass      = UPS_USERPASS;
  private $_key       = UPS_APIKEY;

  private $_client;
  private $_response;
  private $_requestOption;

  private $_streetAddress;

  public function __construct($countryCode = 'US') {
    $this->initAddress();
    $this->setCountryCode($countryCode);
  }

  private function initAddress() {
    if (! isset($this->_streetAddress))
      $this->_streetAddress = new AddressKeyFormatType();
  }

  public function setName($name) {
    $name = $name;
    $this->_streetAddress->setConsigneeName($name);
    return $this;
  }

  public function setAddressLine($address) {
    if (! is_array($address))
      $address = [ $address ];

    $this->_streetAddress->setAddressLine($address);
    return $this;
  }

  public function setProvince($province) {
    $province = $province;
    $this->_streetAddress->setPoliticalDivision1($province);
    return $this;
  }

  public function setState($state) {
    $state = $state;
    return $this->setProvince($state);
  }

  public function setCity($city) {
    $city = $city;
    $this->_streetAddress->setPoliticalDivision2($city);
    return $this;
  }

  public function setZipcode($zip) {
    $parts = [];

    if (preg_match('/([a-zA-Z0-9]{5})[\-\+_\s]?(\d{4})?/', trim($zip), $parts)) {
      $this->setPostcode($parts[1]);
      if(isset($parts[2]))
        $this->setPlusFour($parts[2]);
    }

    return $this;
  }

  public function setPostcode($postcode) {
    $this->_streetAddress->setPostcodePrimaryLow($postcode);
    return $this;
  }

  public function setPlusFour($plusFour) {
    $plusFour = trim($plusFour);

    $code = $this->getCountryCode();

    if (! $code) {
      throw new StreetAddressValidateException('Must set country code before setting plus four zip code.');
    } else if ($code != 'US') {
      throw new StreetAddressValidateException('Plus four can only be used for U.S. addresses.');
    } else if (! preg_match('/\d{4}/', $plusFour)) {
      throw new StreetAddressValidateException('Plus four must be exactly four digits.');
    } else {
      $this->_streetAddress->setPostcodeExtendedLow($plusFour);
    }

    return $this;
  }

  private function getCountryCode() {
    if (isset($this->_streetAddress) && isset($this->_streetAddress->CountryCode))
      return $this->_streetAddress->CountryCode;
  }

  public function setCountryCode($code = 'US') {

    if ($code == 'US') {
      $this->_requestOption = self::OPTION_BOTH;
    } else if ($code == 'PR') {
      $this->_requestOption = self::OPTION_VALIDATE;
    } else if ($code == 'CA') {
      $this->_requestOption = self::OPTION_CLASSIFY;
    } else {
      throw new StreetAddressValidateException(
        'Street address validation can only be performed for addresses in ' .
        'the U.S., Puerto Rico, and Canada.'
      );
    }

    $this->_streetAddress->setCountryCode($code);
    return $this;
  }

  public function send() {
    $RequestType = new RequestType(self::OPTION_BOTH);
    $request     = new XAVRequest($RequestType, null, null, $this->_streetAddress);

    $UsernameToken      = new UsernameToken();
    $ServiceAccessToken = new ServiceAccessToken();
    $UPSSecurity        = new UPSSecurity($UsernameToken, $ServiceAccessToken);

    $UsernameToken->setUsername($this->_user);
    $UsernameToken->setPassword($this->_pass);

    $ServiceAccessToken->setAccessLicenseNumber($this->_key);

    $header = new SoapHeader($this->_schema, 'UPSSecurity', $UPSSecurity);

    $options = [
      'soap_version' => 'SOAP_1_1',
      'exceptions'   => true,
      'location'     => $this->_endpoint,
      'trace'        => true
    ];

    $wsdl = $this->_wsdl;

    $this->_client = new SoapClient($wsdl, $options);
    $this->_client->__setSoapHeaders($header);

    try {
      $this->_response = $this->_client->ProcessXAV($request, $options);
    } catch (SoapFault $s) {
      if (isset($s->detail)) {
        $err = $s->detail->Errors->ErrorDetail->PrimaryErrorCode->Description;
        throw new StreetAddressValidateException($err);
      }
    }

    return $this;
  }

  public function getAddressClassification() {
    if (! isset($this->_response))
      throw new StreetAddressValidateException('No server response has been set.');

    if ($this->getCountryCode() == 'PR')
      throw new StreetAddressValidateException('Cannot validate Puerto Rico addresses.');

    if (isset($this->_response->ValidAddressIndicator))
      return intval($this->_response->AddressClassification->Code);

    return static::UNKNOWN;
  }

  public function isResidential() {
    return $this->getAddressClassification() == static::RESIDENTIAL;
  }

  public function isCommercial() {
    return $this->getAddressClassification() == static::COMMERCIAL;
  }

  public function getAddressValidity() {
    if (! isset($this->_response))
      throw new StreetAddressValidateException('No server response has been set.');

    if (isset($this->_response->ValidAddressIndicator))
      return static::VALID;
    else if (isset($this->_response->NoCandidates))
      return static::INVALID;
    else if (isset($this->_response->AmbiguousAddressIndicator))
      return static::AMBIGUOUS;
  }

  public function valid() {
    return $this->getAddressValidity() == static::VALID;
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

}
