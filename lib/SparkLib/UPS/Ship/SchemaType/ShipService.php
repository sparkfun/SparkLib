<?php

namespace  SparkLib\UPS\Ship\SchemaType;

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
    'UPSSecurity' => '\ SparkLib\UPS\Ship\SchemaType\UPSSecurity',
    'UsernameToken' => '\ SparkLib\UPS\Ship\SchemaType\UsernameToken',
    'ServiceAccessToken' => '\ SparkLib\UPS\Ship\SchemaType\ServiceAccessToken',
    'Errors' => '\ SparkLib\UPS\Ship\SchemaType\Errors',
    'ErrorDetailType' => '\ SparkLib\UPS\Ship\SchemaType\ErrorDetailType',
    'CodeType' => '\ SparkLib\UPS\Ship\SchemaType\CodeType',
    'AdditionalInfoType' => '\ SparkLib\UPS\Ship\SchemaType\AdditionalInfoType',
    'AdditionalCodeDescType' => '\ SparkLib\UPS\Ship\SchemaType\AdditionalCodeDescType',
    'LocationType' => '\ SparkLib\UPS\Ship\SchemaType\LocationType',
    'ClientInformationType' => '\ SparkLib\UPS\Ship\SchemaType\ClientInformationType',
    'Property' => '\ SparkLib\UPS\Ship\SchemaType\Property',
    'RequestType' => '\ SparkLib\UPS\Ship\SchemaType\RequestType',
    'TransactionReferenceType' => '\ SparkLib\UPS\Ship\SchemaType\TransactionReferenceType',
    'ResponseType' => '\ SparkLib\UPS\Ship\SchemaType\ResponseType',
    'CodeDescriptionType' => '\ SparkLib\UPS\Ship\SchemaType\CodeDescriptionType',
    'InternationalFormType' => '\ SparkLib\UPS\Ship\SchemaType\InternationalFormType',
    'UPSPremiumCareFormType' => '\ SparkLib\UPS\Ship\SchemaType\UPSPremiumCareFormType',
    'LanguageForUPSPremiumCareType' => '\ SparkLib\UPS\Ship\SchemaType\LanguageForUPSPremiumCareType',
    'UserCreatedFormType' => '\ SparkLib\UPS\Ship\SchemaType\UserCreatedFormType',
    'CN22FormType' => '\ SparkLib\UPS\Ship\SchemaType\CN22FormType',
    'CN22ContentType' => '\ SparkLib\UPS\Ship\SchemaType\CN22ContentType',
    'ContactType' => '\ SparkLib\UPS\Ship\SchemaType\ContactType',
    'ForwardAgentType' => '\ SparkLib\UPS\Ship\SchemaType\ForwardAgentType',
    'AddressType' => '\ SparkLib\UPS\Ship\SchemaType\AddressType',
    'UltimateConsigneeType' => '\ SparkLib\UPS\Ship\SchemaType\UltimateConsigneeType',
    'IntermediateConsigneeType' => '\ SparkLib\UPS\Ship\SchemaType\IntermediateConsigneeType',
    'ProducerType' => '\ SparkLib\UPS\Ship\SchemaType\ProducerType',
    'ProductType' => '\ SparkLib\UPS\Ship\SchemaType\ProductType',
    'ExcludeFromFormType' => '\ SparkLib\UPS\Ship\SchemaType\ExcludeFromFormType',
    'UnitType' => '\ SparkLib\UPS\Ship\SchemaType\UnitType',
    'PackingListInfoType' => '\ SparkLib\UPS\Ship\SchemaType\PackingListInfoType',
    'PackageAssociatedType' => '\ SparkLib\UPS\Ship\SchemaType\PackageAssociatedType',
    'UnitOfMeasurementType' => '\ SparkLib\UPS\Ship\SchemaType\UnitOfMeasurementType',
    'NetCostDateType' => '\ SparkLib\UPS\Ship\SchemaType\NetCostDateType',
    'ProductWeightType' => '\ SparkLib\UPS\Ship\SchemaType\ProductWeightType',
    'ScheduleBType' => '\ SparkLib\UPS\Ship\SchemaType\ScheduleBType',
    'IFChargesType' => '\ SparkLib\UPS\Ship\SchemaType\IFChargesType',
    'OtherChargesType' => '\ SparkLib\UPS\Ship\SchemaType\OtherChargesType',
    'BlanketPeriodType' => '\ SparkLib\UPS\Ship\SchemaType\BlanketPeriodType',
    'LicenseType' => '\ SparkLib\UPS\Ship\SchemaType\LicenseType',
    'SoldToType' => '\ SparkLib\UPS\Ship\SchemaType\SoldToType',
    'PhoneType' => '\ SparkLib\UPS\Ship\SchemaType\PhoneType',
    'DDTCInformationType' => '\ SparkLib\UPS\Ship\SchemaType\DDTCInformationType',
    'EEILicenseType' => '\ SparkLib\UPS\Ship\SchemaType\EEILicenseType',
    'EEIFilingOptionType' => '\ SparkLib\UPS\Ship\SchemaType\EEIFilingOptionType',
    'UPSFiledType' => '\ SparkLib\UPS\Ship\SchemaType\UPSFiledType',
    'ShipperFiledType' => '\ SparkLib\UPS\Ship\SchemaType\ShipperFiledType',
    'EEIInformationType' => '\ SparkLib\UPS\Ship\SchemaType\EEIInformationType',
    'POAType' => '\ SparkLib\UPS\Ship\SchemaType\POAType',
    'UltimateConsigneeTypeType' => '\ SparkLib\UPS\Ship\SchemaType\UltimateConsigneeTypeType',
    'ShipmentRequest' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentRequest',
    'ShipConfirmRequest' => '\ SparkLib\UPS\Ship\SchemaType\ShipConfirmRequest',
    'ShipAcceptRequest' => '\ SparkLib\UPS\Ship\SchemaType\ShipAcceptRequest',
    'ShipmentResponse' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentResponse',
    'ShipConfirmResponse' => '\ SparkLib\UPS\Ship\SchemaType\ShipConfirmResponse',
    'ShipAcceptResponse' => '\ SparkLib\UPS\Ship\SchemaType\ShipAcceptResponse',
    'ShipmentType' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentType',
    'ShipmentServiceOptions' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentServiceOptions',
    'ReturnServiceType' => '\ SparkLib\UPS\Ship\SchemaType\ReturnServiceType',
    'ShipperType' => '\ SparkLib\UPS\Ship\SchemaType\ShipperType',
    'CompanyInfoType' => '\ SparkLib\UPS\Ship\SchemaType\CompanyInfoType',
    'ShipPhoneType' => '\ SparkLib\UPS\Ship\SchemaType\ShipPhoneType',
    'ShipAddressType' => '\ SparkLib\UPS\Ship\SchemaType\ShipAddressType',
    'ShipToType' => '\ SparkLib\UPS\Ship\SchemaType\ShipToType',
    'ShipToAddressType' => '\ SparkLib\UPS\Ship\SchemaType\ShipToAddressType',
    'ShipFromType' => '\ SparkLib\UPS\Ship\SchemaType\ShipFromType',
    'PrepaidType' => '\ SparkLib\UPS\Ship\SchemaType\PrepaidType',
    'BillShipperType' => '\ SparkLib\UPS\Ship\SchemaType\BillShipperType',
    'CreditCardType' => '\ SparkLib\UPS\Ship\SchemaType\CreditCardType',
    'CreditCardAddressType' => '\ SparkLib\UPS\Ship\SchemaType\CreditCardAddressType',
    'BillThirdPartyChargeType' => '\ SparkLib\UPS\Ship\SchemaType\BillThirdPartyChargeType',
    'AccountAddressType' => '\ SparkLib\UPS\Ship\SchemaType\AccountAddressType',
    'FreightCollectType' => '\ SparkLib\UPS\Ship\SchemaType\FreightCollectType',
    'BillReceiverType' => '\ SparkLib\UPS\Ship\SchemaType\BillReceiverType',
    'BillReceiverAddressType' => '\ SparkLib\UPS\Ship\SchemaType\BillReceiverAddressType',
    'PaymentInfoType' => '\ SparkLib\UPS\Ship\SchemaType\PaymentInfoType',
    'ShipmentChargeType' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentChargeType',
    'FRSPaymentInfoType' => '\ SparkLib\UPS\Ship\SchemaType\FRSPaymentInfoType',
    'PaymentType' => '\ SparkLib\UPS\Ship\SchemaType\PaymentType',
    'RateInfoType' => '\ SparkLib\UPS\Ship\SchemaType\RateInfoType',
    'ReferenceNumberType' => '\ SparkLib\UPS\Ship\SchemaType\ReferenceNumberType',
    'ServiceType' => '\ SparkLib\UPS\Ship\SchemaType\ServiceType',
    'CurrencyMonetaryType' => '\ SparkLib\UPS\Ship\SchemaType\CurrencyMonetaryType',
    'ShipmentServiceOptionsType' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentServiceOptionsType',
    'PreAlertNotificationType' => '\ SparkLib\UPS\Ship\SchemaType\PreAlertNotificationType',
    'PreAlertEMailMessageType' => '\ SparkLib\UPS\Ship\SchemaType\PreAlertEMailMessageType',
    'LocaleType' => '\ SparkLib\UPS\Ship\SchemaType\LocaleType',
    'PreAlertVoiceMessageType' => '\ SparkLib\UPS\Ship\SchemaType\PreAlertVoiceMessageType',
    'PreAlertTextMessageType' => '\ SparkLib\UPS\Ship\SchemaType\PreAlertTextMessageType',
    'ContactInfoType' => '\ SparkLib\UPS\Ship\SchemaType\ContactInfoType',
    'CODType' => '\ SparkLib\UPS\Ship\SchemaType\CODType',
    'NotificationType' => '\ SparkLib\UPS\Ship\SchemaType\NotificationType',
    'LabelDeliveryType' => '\ SparkLib\UPS\Ship\SchemaType\LabelDeliveryType',
    'EmailDetailsType' => '\ SparkLib\UPS\Ship\SchemaType\EmailDetailsType',
    'PackageType' => '\ SparkLib\UPS\Ship\SchemaType\PackageType',
    'PackagingType' => '\ SparkLib\UPS\Ship\SchemaType\PackagingType',
    'DimensionsType' => '\ SparkLib\UPS\Ship\SchemaType\DimensionsType',
    'ShipUnitOfMeasurementType' => '\ SparkLib\UPS\Ship\SchemaType\ShipUnitOfMeasurementType',
    'PackageWeightType' => '\ SparkLib\UPS\Ship\SchemaType\PackageWeightType',
    'PackageServiceOptionsType' => '\ SparkLib\UPS\Ship\SchemaType\PackageServiceOptionsType',
    'PackageDeclaredValueType' => '\ SparkLib\UPS\Ship\SchemaType\PackageDeclaredValueType',
    'DeclaredValueType' => '\ SparkLib\UPS\Ship\SchemaType\DeclaredValueType',
    'DeliveryConfirmationType' => '\ SparkLib\UPS\Ship\SchemaType\DeliveryConfirmationType',
    'LabelMethodType' => '\ SparkLib\UPS\Ship\SchemaType\LabelMethodType',
    'VerbalConfirmationType' => '\ SparkLib\UPS\Ship\SchemaType\VerbalConfirmationType',
    'PSOCODType' => '\ SparkLib\UPS\Ship\SchemaType\PSOCODType',
    'PSONotificationType' => '\ SparkLib\UPS\Ship\SchemaType\PSONotificationType',
    'LabelSpecificationType' => '\ SparkLib\UPS\Ship\SchemaType\LabelSpecificationType',
    'InstructionCodeDescriptionType' => '\ SparkLib\UPS\Ship\SchemaType\InstructionCodeDescriptionType',
    'LabelImageFormatType' => '\ SparkLib\UPS\Ship\SchemaType\LabelImageFormatType',
    'LabelStockSizeType' => '\ SparkLib\UPS\Ship\SchemaType\LabelStockSizeType',
    'CommodityType' => '\ SparkLib\UPS\Ship\SchemaType\CommodityType',
    'NMFCType' => '\ SparkLib\UPS\Ship\SchemaType\NMFCType',
    'ShipmentResultsType' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentResultsType',
    'ShipmentChargesType' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentChargesType',
    'NegotiatedRateChargesType' => '\ SparkLib\UPS\Ship\SchemaType\NegotiatedRateChargesType',
    'ShipChargeType' => '\ SparkLib\UPS\Ship\SchemaType\ShipChargeType',
    'FRSShipmentDataType' => '\ SparkLib\UPS\Ship\SchemaType\FRSShipmentDataType',
    'TransportationChargeType' => '\ SparkLib\UPS\Ship\SchemaType\TransportationChargeType',
    'BillingWeightType' => '\ SparkLib\UPS\Ship\SchemaType\BillingWeightType',
    'BillingUnitOfMeasurementType' => '\ SparkLib\UPS\Ship\SchemaType\BillingUnitOfMeasurementType',
    'PackageResultsType' => '\ SparkLib\UPS\Ship\SchemaType\PackageResultsType',
    'AccessorialType' => '\ SparkLib\UPS\Ship\SchemaType\AccessorialType',
    'LabelType' => '\ SparkLib\UPS\Ship\SchemaType\LabelType',
    'ReceiptType' => '\ SparkLib\UPS\Ship\SchemaType\ReceiptType',
    'ImageType' => '\ SparkLib\UPS\Ship\SchemaType\ImageType',
    'FormType' => '\ SparkLib\UPS\Ship\SchemaType\FormType',
    'FormImageType' => '\ SparkLib\UPS\Ship\SchemaType\FormImageType',
    'ImageFormatType' => '\ SparkLib\UPS\Ship\SchemaType\ImageFormatType',
    'SCReportType' => '\ SparkLib\UPS\Ship\SchemaType\SCReportType',
    'HighValueReportType' => '\ SparkLib\UPS\Ship\SchemaType\HighValueReportType',
    'DryIceType' => '\ SparkLib\UPS\Ship\SchemaType\DryIceType',
    'DryIceWeightType' => '\ SparkLib\UPS\Ship\SchemaType\DryIceWeightType',
    'ReceiptSpecificationType' => '\ SparkLib\UPS\Ship\SchemaType\ReceiptSpecificationType',
    'ReceiptImageFormatType' => '\ SparkLib\UPS\Ship\SchemaType\ReceiptImageFormatType',
    'TaxIDCodeDescType' => '\ SparkLib\UPS\Ship\SchemaType\TaxIDCodeDescType',
    'IndicationType' => '\ SparkLib\UPS\Ship\SchemaType\IndicationType',
    'AlternateDeliveryAddressType' => '\ SparkLib\UPS\Ship\SchemaType\AlternateDeliveryAddressType',
    'ShipmentServiceOptionsNotificationVoiceMessageType' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentServiceOptionsNotificationVoiceMessageType',
    'ShipmentServiceOptionsNotificationTextMessageType' => '\ SparkLib\UPS\Ship\SchemaType\ShipmentServiceOptionsNotificationTextMessageType',
    'ADLAddressType' => '\ SparkLib\UPS\Ship\SchemaType\ADLAddressType');

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
