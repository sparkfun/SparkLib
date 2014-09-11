<?php

namespace SparkLib\UPS\Rate;

include_once('UPSSecurity.php');
include_once('UsernameToken.php');
include_once('ServiceAccessToken.php');
include_once('Errors.php');
include_once('ErrorDetailType.php');
include_once('CodeType.php');
include_once('AdditionalInfoType.php');
include_once('AdditionalCodeDescType.php');
include_once('LocationType.php');
include_once('ClientInformationType.php');
include_once('Property.php');
include_once('RequestType.php');
include_once('TransactionReferenceType.php');
include_once('ResponseType.php');
include_once('CodeDescriptionType.php');
include_once('RateRequest.php');
include_once('RateResponse.php');
include_once('BillingWeightType.php');
include_once('RatedPackageType.php');
include_once('AccessorialType.php');
include_once('RatedShipmentType.php');
include_once('TotalChargeType.php');
include_once('RatedShipmentInfoType.php');
include_once('ChargesType.php');
include_once('TransportationChargesType.php');
include_once('FRSShipmentType.php');
include_once('AddressType.php');
include_once('ShipToAddressType.php');
include_once('CODType.php');
include_once('CODAmountType.php');
include_once('DeliveryConfirmationType.php');
include_once('DimensionsType.php');
include_once('InsuredValueType.php');
include_once('OnCallPickupType.php');
include_once('PackageType.php');
include_once('CommodityType.php');
include_once('NMFCCommodityType.php');
include_once('PackageServiceOptionsType.php');
include_once('DryIceType.php');
include_once('DryIceWeightType.php');
include_once('ShipperDeclaredValueType.php');
include_once('InsuranceType.php');
include_once('InsuranceValueType.php');
include_once('PackageWeightType.php');
include_once('UOMCodeDescriptionType.php');
include_once('ShipmentRatingOptionsType.php');
include_once('ScheduleType.php');
include_once('ShipFromType.php');
include_once('ShipToType.php');
include_once('ShipmentType.php');
include_once('AlternateDeliveryAddressType.php');
include_once('ADRType.php');
include_once('IndicationType.php');
include_once('ShipmentChargesType.php');
include_once('ShipmentServiceOptionsType.php');
include_once('ReturnServiceType.php');
include_once('ImportControlType.php');
include_once('RestrictedArticlesType.php');
include_once('PickupOptionsType.php');
include_once('DeliveryOptionsType.php');
include_once('ShipperType.php');
include_once('GuaranteedDeliveryType.php');
include_once('FRSPaymentInfoType.php');
include_once('PayerAddressType.php');
include_once('InvoiceLineTotalType.php');


/**
 * 
 */
class RateService extends \SoapClient
{

  /**
   * 
   * @var array $classmap The defined classes
   * @access private
   */
  private static $classmap = array(
    'UPSSecurity' => '\SparkLib\UPS\Rate\UPSSecurity',
    'UsernameToken' => '\SparkLib\UPS\Rate\UsernameToken',
    'ServiceAccessToken' => '\SparkLib\UPS\Rate\ServiceAccessToken',
    'Errors' => '\SparkLib\UPS\Rate\Errors',
    'ErrorDetailType' => '\SparkLib\UPS\Rate\ErrorDetailType',
    'CodeType' => '\SparkLib\UPS\Rate\CodeType',
    'AdditionalInfoType' => '\SparkLib\UPS\Rate\AdditionalInfoType',
    'AdditionalCodeDescType' => '\SparkLib\UPS\Rate\AdditionalCodeDescType',
    'LocationType' => '\SparkLib\UPS\Rate\LocationType',
    'ClientInformationType' => '\SparkLib\UPS\Rate\ClientInformationType',
    'Property' => '\SparkLib\UPS\Rate\Property',
    'RequestType' => '\SparkLib\UPS\Rate\RequestType',
    'TransactionReferenceType' => '\SparkLib\UPS\Rate\TransactionReferenceType',
    'ResponseType' => '\SparkLib\UPS\Rate\ResponseType',
    'CodeDescriptionType' => '\SparkLib\UPS\Rate\CodeDescriptionType',
    'RateRequest' => '\SparkLib\UPS\Rate\RateRequest',
    'RateResponse' => '\SparkLib\UPS\Rate\RateResponse',
    'BillingWeightType' => '\SparkLib\UPS\Rate\BillingWeightType',
    'RatedPackageType' => '\SparkLib\UPS\Rate\RatedPackageType',
    'AccessorialType' => '\SparkLib\UPS\Rate\AccessorialType',
    'RatedShipmentType' => '\SparkLib\UPS\Rate\RatedShipmentType',
    'TotalChargeType' => '\SparkLib\UPS\Rate\TotalChargeType',
    'RatedShipmentInfoType' => '\SparkLib\UPS\Rate\RatedShipmentInfoType',
    'ChargesType' => '\SparkLib\UPS\Rate\ChargesType',
    'TransportationChargesType' => '\SparkLib\UPS\Rate\TransportationChargesType',
    'FRSShipmentType' => '\SparkLib\UPS\Rate\FRSShipmentType',
    'AddressType' => '\SparkLib\UPS\Rate\AddressType',
    'ShipToAddressType' => '\SparkLib\UPS\Rate\ShipToAddressType',
    'CODType' => '\SparkLib\UPS\Rate\CODType',
    'CODAmountType' => '\SparkLib\UPS\Rate\CODAmountType',
    'DeliveryConfirmationType' => '\SparkLib\UPS\Rate\DeliveryConfirmationType',
    'DimensionsType' => '\SparkLib\UPS\Rate\DimensionsType',
    'InsuredValueType' => '\SparkLib\UPS\Rate\InsuredValueType',
    'OnCallPickupType' => '\SparkLib\UPS\Rate\OnCallPickupType',
    'PackageType' => '\SparkLib\UPS\Rate\PackageType',
    'CommodityType' => '\SparkLib\UPS\Rate\CommodityType',
    'NMFCCommodityType' => '\SparkLib\UPS\Rate\NMFCCommodityType',
    'PackageServiceOptionsType' => '\SparkLib\UPS\Rate\PackageServiceOptionsType',
    'DryIceType' => '\SparkLib\UPS\Rate\DryIceType',
    'DryIceWeightType' => '\SparkLib\UPS\Rate\DryIceWeightType',
    'ShipperDeclaredValueType' => '\SparkLib\UPS\Rate\ShipperDeclaredValueType',
    'InsuranceType' => '\SparkLib\UPS\Rate\InsuranceType',
    'InsuranceValueType' => '\SparkLib\UPS\Rate\InsuranceValueType',
    'PackageWeightType' => '\SparkLib\UPS\Rate\PackageWeightType',
    'UOMCodeDescriptionType' => '\SparkLib\UPS\Rate\UOMCodeDescriptionType',
    'CodeDescriptionType' => '\SparkLib\UPS\Rate\CodeDescriptionType',
    'ShipmentRatingOptionsType' => '\SparkLib\UPS\Rate\ShipmentRatingOptionsType',
    'ScheduleType' => '\SparkLib\UPS\Rate\ScheduleType',
    'ShipFromType' => '\SparkLib\UPS\Rate\ShipFromType',
    'ShipToType' => '\SparkLib\UPS\Rate\ShipToType',
    'ShipmentType' => '\SparkLib\UPS\Rate\ShipmentType',
    'AlternateDeliveryAddressType' => '\SparkLib\UPS\Rate\AlternateDeliveryAddressType',
    'ADRType' => '\SparkLib\UPS\Rate\ADRType',
    'IndicationType' => '\SparkLib\UPS\Rate\IndicationType',
    'ShipmentChargesType' => '\SparkLib\UPS\Rate\ShipmentChargesType',
    'ShipmentServiceOptionsType' => '\SparkLib\UPS\Rate\ShipmentServiceOptionsType',
    'ReturnServiceType' => '\SparkLib\UPS\Rate\ReturnServiceType',
    'ImportControlType' => '\SparkLib\UPS\Rate\ImportControlType',
    'RestrictedArticlesType' => '\SparkLib\UPS\Rate\RestrictedArticlesType',
    'PickupOptionsType' => '\SparkLib\UPS\Rate\PickupOptionsType',
    'DeliveryOptionsType' => '\SparkLib\UPS\Rate\DeliveryOptionsType',
    'ShipperType' => '\SparkLib\UPS\Rate\ShipperType',
    'GuaranteedDeliveryType' => '\SparkLib\UPS\Rate\GuaranteedDeliveryType',
    'FRSPaymentInfoType' => '\SparkLib\UPS\Rate\FRSPaymentInfoType',
    'PayerAddressType' => '\SparkLib\UPS\Rate\PayerAddressType',
    'InvoiceLineTotalType' => '\SparkLib\UPS\Rate\InvoiceLineTotalType');

  /**
   * 
   * @param array $options A array of config values
   * @param string $wsdl The wsdl file to use
   * @access public
   */
  public function __construct(array $options = array(), $wsdl = 'lib/classes/SparkLib/UPS/Rate/wsdl/RateWS.wsdl')
  {
    foreach (self::$classmap as $key => $value) {
      if (!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }
    
    parent::__construct($wsdl, $options);
  }

  /**
   * 
   * @param RateRequest $Body
   * @access public
   * @return RateResponse
   */
  public function ProcessRate(RateRequest $Body)
  {
    return $this->__soapCall('ProcessRate', array($Body));
  }

}
