<?php

namespace SparkLib\UPS\Ship;

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
include_once('InternationalFormType.php');
include_once('UPSPremiumCareFormType.php');
include_once('LanguageForUPSPremiumCareType.php');
include_once('UserCreatedFormType.php');
include_once('CN22FormType.php');
include_once('CN22ContentType.php');
include_once('ContactType.php');
include_once('ForwardAgentType.php');
include_once('AddressType.php');
include_once('UltimateConsigneeType.php');
include_once('IntermediateConsigneeType.php');
include_once('ProducerType.php');
include_once('ProductType.php');
include_once('ExcludeFromFormType.php');
include_once('UnitType.php');
include_once('PackingListInfoType.php');
include_once('PackageAssociatedType.php');
include_once('UnitOfMeasurementType.php');
include_once('NetCostDateType.php');
include_once('ProductWeightType.php');
include_once('ScheduleBType.php');
include_once('IFChargesType.php');
include_once('OtherChargesType.php');
include_once('BlanketPeriodType.php');
include_once('LicenseType.php');
include_once('SoldToType.php');
include_once('PhoneType.php');
include_once('DDTCInformationType.php');
include_once('EEILicenseType.php');
include_once('EEIFilingOptionType.php');
include_once('UPSFiledType.php');
include_once('ShipperFiledType.php');
include_once('EEIInformationType.php');
include_once('POAType.php');
include_once('UltimateConsigneeTypeType.php');
include_once('ShipmentRequest.php');
include_once('ShipConfirmRequest.php');
include_once('ShipAcceptRequest.php');
include_once('ShipmentResponse.php');
include_once('ShipConfirmResponse.php');
include_once('ShipAcceptResponse.php');
include_once('ShipmentType.php');
include_once('ShipmentServiceOptions.php');
include_once('ReturnServiceType.php');
include_once('ShipperType.php');
include_once('CompanyInfoType.php');
include_once('ShipPhoneType.php');
include_once('ShipAddressType.php');
include_once('ShipToType.php');
include_once('ShipToAddressType.php');
include_once('ShipFromType.php');
include_once('PrepaidType.php');
include_once('BillShipperType.php');
include_once('CreditCardType.php');
include_once('CreditCardAddressType.php');
include_once('BillThirdPartyChargeType.php');
include_once('AccountAddressType.php');
include_once('FreightCollectType.php');
include_once('BillReceiverType.php');
include_once('BillReceiverAddressType.php');
include_once('PaymentInfoType.php');
include_once('ShipmentChargeType.php');
include_once('FRSPaymentInfoType.php');
include_once('PaymentType.php');
include_once('RateInfoType.php');
include_once('ReferenceNumberType.php');
include_once('ServiceType.php');
include_once('CurrencyMonetaryType.php');
include_once('ShipmentServiceOptionsType.php');
include_once('PreAlertNotificationType.php');
include_once('PreAlertEMailMessageType.php');
include_once('LocaleType.php');
include_once('PreAlertVoiceMessageType.php');
include_once('PreAlertTextMessageType.php');
include_once('ContactInfoType.php');
include_once('CODType.php');
include_once('NotificationType.php');
include_once('LabelDeliveryType.php');
include_once('EmailDetailsType.php');
include_once('PackageType.php');
include_once('PackagingType.php');
include_once('DimensionsType.php');
include_once('ShipUnitOfMeasurementType.php');
include_once('PackageWeightType.php');
include_once('PackageServiceOptionsType.php');
include_once('PackageDeclaredValueType.php');
include_once('DeclaredValueType.php');
include_once('DeliveryConfirmationType.php');
include_once('LabelMethodType.php');
include_once('VerbalConfirmationType.php');
include_once('PSOCODType.php');
include_once('PSONotificationType.php');
include_once('LabelSpecificationType.php');
include_once('InstructionCodeDescriptionType.php');
include_once('LabelImageFormatType.php');
include_once('LabelStockSizeType.php');
include_once('CommodityType.php');
include_once('NMFCType.php');
include_once('ShipmentResultsType.php');
include_once('ShipmentChargesType.php');
include_once('NegotiatedRateChargesType.php');
include_once('ShipChargeType.php');
include_once('FRSShipmentDataType.php');
include_once('TransportationChargeType.php');
include_once('BillingWeightType.php');
include_once('BillingUnitOfMeasurementType.php');
include_once('PackageResultsType.php');
include_once('AccessorialType.php');
include_once('LabelType.php');
include_once('ReceiptType.php');
include_once('ImageType.php');
include_once('FormType.php');
include_once('FormImageType.php');
include_once('ImageFormatType.php');
include_once('SCReportType.php');
include_once('HighValueReportType.php');
include_once('DryIceType.php');
include_once('DryIceWeightType.php');
include_once('ReceiptSpecificationType.php');
include_once('ReceiptImageFormatType.php');
include_once('TaxIDCodeDescType.php');
include_once('IndicationType.php');
include_once('AlternateDeliveryAddressType.php');
include_once('ShipmentServiceOptionsNotificationVoiceMessageType.php');
include_once('ShipmentServiceOptionsNotificationTextMessageType.php');
include_once('ADLAddressType.php');


/**
 * 
 */
class ShipService extends \SoapClient
{

  /**
   * 
   * @var array $classmap The defined classes
   * @access private
   */
  private static $classmap = array(
    'UPSSecurity' => '\SparkLib\UPS\Ship\UPSSecurity',
    'UsernameToken' => '\SparkLib\UPS\Ship\UsernameToken',
    'ServiceAccessToken' => '\SparkLib\UPS\Ship\ServiceAccessToken',
    'Errors' => '\SparkLib\UPS\Ship\Errors',
    'ErrorDetailType' => '\SparkLib\UPS\Ship\ErrorDetailType',
    'CodeType' => '\SparkLib\UPS\Ship\CodeType',
    'AdditionalInfoType' => '\SparkLib\UPS\Ship\AdditionalInfoType',
    'AdditionalCodeDescType' => '\SparkLib\UPS\Ship\AdditionalCodeDescType',
    'LocationType' => '\SparkLib\UPS\Ship\LocationType',
    'ClientInformationType' => '\SparkLib\UPS\Ship\ClientInformationType',
    'Property' => '\SparkLib\UPS\Ship\Property',
    'RequestType' => '\SparkLib\UPS\Ship\RequestType',
    'TransactionReferenceType' => '\SparkLib\UPS\Ship\TransactionReferenceType',
    'ResponseType' => '\SparkLib\UPS\Ship\ResponseType',
    'CodeDescriptionType' => '\SparkLib\UPS\Ship\CodeDescriptionType',
    'InternationalFormType' => '\SparkLib\UPS\Ship\InternationalFormType',
    'UPSPremiumCareFormType' => '\SparkLib\UPS\Ship\UPSPremiumCareFormType',
    'LanguageForUPSPremiumCareType' => '\SparkLib\UPS\Ship\LanguageForUPSPremiumCareType',
    'UserCreatedFormType' => '\SparkLib\UPS\Ship\UserCreatedFormType',
    'CN22FormType' => '\SparkLib\UPS\Ship\CN22FormType',
    'CN22ContentType' => '\SparkLib\UPS\Ship\CN22ContentType',
    'ContactType' => '\SparkLib\UPS\Ship\ContactType',
    'ForwardAgentType' => '\SparkLib\UPS\Ship\ForwardAgentType',
    'AddressType' => '\SparkLib\UPS\Ship\AddressType',
    'UltimateConsigneeType' => '\SparkLib\UPS\Ship\UltimateConsigneeType',
    'IntermediateConsigneeType' => '\SparkLib\UPS\Ship\IntermediateConsigneeType',
    'ProducerType' => '\SparkLib\UPS\Ship\ProducerType',
    'ProductType' => '\SparkLib\UPS\Ship\ProductType',
    'ExcludeFromFormType' => '\SparkLib\UPS\Ship\ExcludeFromFormType',
    'UnitType' => '\SparkLib\UPS\Ship\UnitType',
    'PackingListInfoType' => '\SparkLib\UPS\Ship\PackingListInfoType',
    'PackageAssociatedType' => '\SparkLib\UPS\Ship\PackageAssociatedType',
    'UnitOfMeasurementType' => '\SparkLib\UPS\Ship\UnitOfMeasurementType',
    'NetCostDateType' => '\SparkLib\UPS\Ship\NetCostDateType',
    'ProductWeightType' => '\SparkLib\UPS\Ship\ProductWeightType',
    'ScheduleBType' => '\SparkLib\UPS\Ship\ScheduleBType',
    'IFChargesType' => '\SparkLib\UPS\Ship\IFChargesType',
    'OtherChargesType' => '\SparkLib\UPS\Ship\OtherChargesType',
    'BlanketPeriodType' => '\SparkLib\UPS\Ship\BlanketPeriodType',
    'LicenseType' => '\SparkLib\UPS\Ship\LicenseType',
    'SoldToType' => '\SparkLib\UPS\Ship\SoldToType',
    'PhoneType' => '\SparkLib\UPS\Ship\PhoneType',
    'DDTCInformationType' => '\SparkLib\UPS\Ship\DDTCInformationType',
    'EEILicenseType' => '\SparkLib\UPS\Ship\EEILicenseType',
    'EEIFilingOptionType' => '\SparkLib\UPS\Ship\EEIFilingOptionType',
    'UPSFiledType' => '\SparkLib\UPS\Ship\UPSFiledType',
    'ShipperFiledType' => '\SparkLib\UPS\Ship\ShipperFiledType',
    'EEIInformationType' => '\SparkLib\UPS\Ship\EEIInformationType',
    'POAType' => '\SparkLib\UPS\Ship\POAType',
    'UltimateConsigneeTypeType' => '\SparkLib\UPS\Ship\UltimateConsigneeTypeType',
    'ShipmentRequest' => '\SparkLib\UPS\Ship\ShipmentRequest',
    'ShipConfirmRequest' => '\SparkLib\UPS\Ship\ShipConfirmRequest',
    'ShipAcceptRequest' => '\SparkLib\UPS\Ship\ShipAcceptRequest',
    'ShipmentResponse' => '\SparkLib\UPS\Ship\ShipmentResponse',
    'ShipConfirmResponse' => '\SparkLib\UPS\Ship\ShipConfirmResponse',
    'ShipAcceptResponse' => '\SparkLib\UPS\Ship\ShipAcceptResponse',
    'ShipmentType' => '\SparkLib\UPS\Ship\ShipmentType',
    'ShipmentServiceOptions' => '\SparkLib\UPS\Ship\ShipmentServiceOptions',
    'ReturnServiceType' => '\SparkLib\UPS\Ship\ReturnServiceType',
    'ShipperType' => '\SparkLib\UPS\Ship\ShipperType',
    'CompanyInfoType' => '\SparkLib\UPS\Ship\CompanyInfoType',
    'ShipPhoneType' => '\SparkLib\UPS\Ship\ShipPhoneType',
    'ShipAddressType' => '\SparkLib\UPS\Ship\ShipAddressType',
    'ShipToType' => '\SparkLib\UPS\Ship\ShipToType',
    'ShipToAddressType' => '\SparkLib\UPS\Ship\ShipToAddressType',
    'ShipFromType' => '\SparkLib\UPS\Ship\ShipFromType',
    'PrepaidType' => '\SparkLib\UPS\Ship\PrepaidType',
    'BillShipperType' => '\SparkLib\UPS\Ship\BillShipperType',
    'CreditCardType' => '\SparkLib\UPS\Ship\CreditCardType',
    'CreditCardAddressType' => '\SparkLib\UPS\Ship\CreditCardAddressType',
    'BillThirdPartyChargeType' => '\SparkLib\UPS\Ship\BillThirdPartyChargeType',
    'AccountAddressType' => '\SparkLib\UPS\Ship\AccountAddressType',
    'FreightCollectType' => '\SparkLib\UPS\Ship\FreightCollectType',
    'BillReceiverType' => '\SparkLib\UPS\Ship\BillReceiverType',
    'BillReceiverAddressType' => '\SparkLib\UPS\Ship\BillReceiverAddressType',
    'PaymentInfoType' => '\SparkLib\UPS\Ship\PaymentInfoType',
    'ShipmentChargeType' => '\SparkLib\UPS\Ship\ShipmentChargeType',
    'FRSPaymentInfoType' => '\SparkLib\UPS\Ship\FRSPaymentInfoType',
    'PaymentType' => '\SparkLib\UPS\Ship\PaymentType',
    'RateInfoType' => '\SparkLib\UPS\Ship\RateInfoType',
    'ReferenceNumberType' => '\SparkLib\UPS\Ship\ReferenceNumberType',
    'ServiceType' => '\SparkLib\UPS\Ship\ServiceType',
    'CurrencyMonetaryType' => '\SparkLib\UPS\Ship\CurrencyMonetaryType',
    'ShipmentServiceOptionsType' => '\SparkLib\UPS\Ship\ShipmentServiceOptionsType',
    'PreAlertNotificationType' => '\SparkLib\UPS\Ship\PreAlertNotificationType',
    'PreAlertEMailMessageType' => '\SparkLib\UPS\Ship\PreAlertEMailMessageType',
    'LocaleType' => '\SparkLib\UPS\Ship\LocaleType',
    'PreAlertVoiceMessageType' => '\SparkLib\UPS\Ship\PreAlertVoiceMessageType',
    'PreAlertTextMessageType' => '\SparkLib\UPS\Ship\PreAlertTextMessageType',
    'ContactInfoType' => '\SparkLib\UPS\Ship\ContactInfoType',
    'CODType' => '\SparkLib\UPS\Ship\CODType',
    'NotificationType' => '\SparkLib\UPS\Ship\NotificationType',
    'LabelDeliveryType' => '\SparkLib\UPS\Ship\LabelDeliveryType',
    'EmailDetailsType' => '\SparkLib\UPS\Ship\EmailDetailsType',
    'PackageType' => '\SparkLib\UPS\Ship\PackageType',
    'PackagingType' => '\SparkLib\UPS\Ship\PackagingType',
    'DimensionsType' => '\SparkLib\UPS\Ship\DimensionsType',
    'ShipUnitOfMeasurementType' => '\SparkLib\UPS\Ship\ShipUnitOfMeasurementType',
    'PackageWeightType' => '\SparkLib\UPS\Ship\PackageWeightType',
    'PackageServiceOptionsType' => '\SparkLib\UPS\Ship\PackageServiceOptionsType',
    'PackageDeclaredValueType' => '\SparkLib\UPS\Ship\PackageDeclaredValueType',
    'DeclaredValueType' => '\SparkLib\UPS\Ship\DeclaredValueType',
    'DeliveryConfirmationType' => '\SparkLib\UPS\Ship\DeliveryConfirmationType',
    'LabelMethodType' => '\SparkLib\UPS\Ship\LabelMethodType',
    'VerbalConfirmationType' => '\SparkLib\UPS\Ship\VerbalConfirmationType',
    'PSOCODType' => '\SparkLib\UPS\Ship\PSOCODType',
    'PSONotificationType' => '\SparkLib\UPS\Ship\PSONotificationType',
    'LabelSpecificationType' => '\SparkLib\UPS\Ship\LabelSpecificationType',
    'InstructionCodeDescriptionType' => '\SparkLib\UPS\Ship\InstructionCodeDescriptionType',
    'LabelImageFormatType' => '\SparkLib\UPS\Ship\LabelImageFormatType',
    'LabelStockSizeType' => '\SparkLib\UPS\Ship\LabelStockSizeType',
    'CommodityType' => '\SparkLib\UPS\Ship\CommodityType',
    'NMFCType' => '\SparkLib\UPS\Ship\NMFCType',
    'ShipmentResultsType' => '\SparkLib\UPS\Ship\ShipmentResultsType',
    'ShipmentChargesType' => '\SparkLib\UPS\Ship\ShipmentChargesType',
    'NegotiatedRateChargesType' => '\SparkLib\UPS\Ship\NegotiatedRateChargesType',
    'ShipChargeType' => '\SparkLib\UPS\Ship\ShipChargeType',
    'FRSShipmentDataType' => '\SparkLib\UPS\Ship\FRSShipmentDataType',
    'TransportationChargeType' => '\SparkLib\UPS\Ship\TransportationChargeType',
    'BillingWeightType' => '\SparkLib\UPS\Ship\BillingWeightType',
    'BillingUnitOfMeasurementType' => '\SparkLib\UPS\Ship\BillingUnitOfMeasurementType',
    'PackageResultsType' => '\SparkLib\UPS\Ship\PackageResultsType',
    'AccessorialType' => '\SparkLib\UPS\Ship\AccessorialType',
    'LabelType' => '\SparkLib\UPS\Ship\LabelType',
    'ReceiptType' => '\SparkLib\UPS\Ship\ReceiptType',
    'ImageType' => '\SparkLib\UPS\Ship\ImageType',
    'FormType' => '\SparkLib\UPS\Ship\FormType',
    'FormImageType' => '\SparkLib\UPS\Ship\FormImageType',
    'ImageFormatType' => '\SparkLib\UPS\Ship\ImageFormatType',
    'SCReportType' => '\SparkLib\UPS\Ship\SCReportType',
    'HighValueReportType' => '\SparkLib\UPS\Ship\HighValueReportType',
    'DryIceType' => '\SparkLib\UPS\Ship\DryIceType',
    'DryIceWeightType' => '\SparkLib\UPS\Ship\DryIceWeightType',
    'ReceiptSpecificationType' => '\SparkLib\UPS\Ship\ReceiptSpecificationType',
    'ReceiptImageFormatType' => '\SparkLib\UPS\Ship\ReceiptImageFormatType',
    'TaxIDCodeDescType' => '\SparkLib\UPS\Ship\TaxIDCodeDescType',
    'IndicationType' => '\SparkLib\UPS\Ship\IndicationType',
    'AlternateDeliveryAddressType' => '\SparkLib\UPS\Ship\AlternateDeliveryAddressType',
    'ShipmentServiceOptionsNotificationVoiceMessageType' => '\SparkLib\UPS\Ship\ShipmentServiceOptionsNotificationVoiceMessageType',
    'ShipmentServiceOptionsNotificationTextMessageType' => '\SparkLib\UPS\Ship\ShipmentServiceOptionsNotificationTextMessageType',
    'ADLAddressType' => '\SparkLib\UPS\Ship\ADLAddressType');

  /**
   * 
   * @param array $options A array of config values
   * @param string $wsdl The wsdl file to use
   * @access public
   */
  public function __construct(array $options = array(), $wsdl = 'lib/classes/SparkLib/UPS/Ship/wsdl/Ship.wsdl')
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
   * @param ShipmentRequest $Body
   * @access public
   * @return ShipmentResponse
   */
  public function ProcessShipment(ShipmentRequest $Body)
  {
    return $this->__soapCall('ProcessShipment', array($Body));
  }

  /**
   * 
   * @param ShipConfirmRequest $Body
   * @access public
   * @return ShipConfirmResponse
   */
  public function ProcessShipConfirm(ShipConfirmRequest $Body)
  {
    return $this->__soapCall('ProcessShipConfirm', array($Body));
  }

  /**
   * 
   * @param ShipAcceptRequest $Body
   * @access public
   * @return ShipAcceptResponse
   */
  public function ProcessShipAccept(ShipAcceptRequest $Body)
  {
    return $this->__soapCall('ProcessShipAccept', array($Body));
  }

}
