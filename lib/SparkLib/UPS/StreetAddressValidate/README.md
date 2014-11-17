This set of classes is designed to wrap UPS's street-level address validation
API, that they call XAV.

It consists of this class, which has methods to access the most common
functions of the API, as well as a set of generated classes for describing
the SOAP request.

The WSDL class files were generated using
[wsdl2phpgenerator](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator),
with the following command:

    php wsdl2php --createAccessors --constructorNull --cacheNone \
    --namespace="SparkLib\UPS\StreetAddressValidate" \
    -i /var/www/lib/classes/SparkLib/UPS/StreetAddressValidate/wsdl/XAV.wsdl
