<?php

namespace SparkLib\UPS\StreetAddressValidate;

include_once('UPSSecurity.php');
include_once('UsernameToken.php');
include_once('ServiceAccessToken.php');
include_once('ClientInformationType.php');
include_once('Property.php');
include_once('RequestType.php');
include_once('TransactionReferenceType.php');
include_once('ResponseType.php');
include_once('CodeDescriptionType.php');
include_once('Errors.php');
include_once('ErrorDetailType.php');
include_once('CodeType.php');
include_once('LocationType.php');
include_once('XAVRequest.php');
include_once('XAVResponse.php');
include_once('AddressKeyFormatType.php');
include_once('CandidateType.php');
include_once('AddressClassificationType.php');

class XAVService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     * @access private
     */
    private static $classmap = array(
      'UPSSecurity' => 'SparkLib\UPS\StreetAddressValidate\UPSSecurity',
      'UsernameToken' => 'SparkLib\UPS\StreetAddressValidate\UsernameToken',
      'ServiceAccessToken' => 'SparkLib\UPS\StreetAddressValidate\ServiceAccessToken',
      'ClientInformationType' => 'SparkLib\UPS\StreetAddressValidate\ClientInformationType',
      'Property' => 'SparkLib\UPS\StreetAddressValidate\Property',
      'RequestType' => 'SparkLib\UPS\StreetAddressValidate\RequestType',
      'TransactionReferenceType' => 'SparkLib\UPS\StreetAddressValidate\TransactionReferenceType',
      'ResponseType' => 'SparkLib\UPS\StreetAddressValidate\ResponseType',
      'CodeDescriptionType' => 'SparkLib\UPS\StreetAddressValidate\CodeDescriptionType',
      'Errors' => 'SparkLib\UPS\StreetAddressValidate\Errors',
      'ErrorDetailType' => 'SparkLib\UPS\StreetAddressValidate\ErrorDetailType',
      'CodeType' => 'SparkLib\UPS\StreetAddressValidate\CodeType',
      'LocationType' => 'SparkLib\UPS\StreetAddressValidate\LocationType',
      'XAVRequest' => 'SparkLib\UPS\StreetAddressValidate\XAVRequest',
      'XAVResponse' => 'SparkLib\UPS\StreetAddressValidate\XAVResponse',
      'AddressKeyFormatType' => 'SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType',
      'CandidateType' => 'SparkLib\UPS\StreetAddressValidate\CandidateType',
      'AddressClassificationType' => 'SparkLib\UPS\StreetAddressValidate\AddressClassificationType');

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     * @access public
     */
    public function __construct(array $options = array(), $wsdl = '/var/www/lib/classes/SparkLib/UPS/StreetAddressValidate/wsdl/XAV.wsdl')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      
      if (isset($options['wsdl_cache']) == false) {
        $options['wsdl_cache'] = WSDL_CACHE_NONE;
      }
    
      parent::__construct($wsdl, $options);
    }

    /**
     * @param XAVRequest $Body
     * @access public
     * @return XAVResponse
     */
    public function ProcessXAV(XAVRequest $Body)
    {
      return $this->__soapCall('ProcessXAV', array($Body));
    }

}
