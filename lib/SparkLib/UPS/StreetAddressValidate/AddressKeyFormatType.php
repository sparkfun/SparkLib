<?php

namespace SparkLib\UPS\StreetAddressValidate;

class AddressKeyFormatType
{

    /**
     * @var string $ConsigneeName
     * @access public
     */
    public $ConsigneeName = null;

    /**
     * @var string $AttentionName
     * @access public
     */
    public $AttentionName = null;

    /**
     * @var string[] $AddressLine
     * @access public
     */
    public $AddressLine = null;

    /**
     * @var string $PoliticalDivision2
     * @access public
     */
    public $PoliticalDivision2 = null;

    /**
     * @var string $PoliticalDivision1
     * @access public
     */
    public $PoliticalDivision1 = null;

    /**
     * @var string $PostcodePrimaryLow
     * @access public
     */
    public $PostcodePrimaryLow = null;

    /**
     * @var string $PostcodeExtendedLow
     * @access public
     */
    public $PostcodeExtendedLow = null;

    /**
     * @var string $Region
     * @access public
     */
    public $Region = null;

    /**
     * @var string $Urbanization
     * @access public
     */
    public $Urbanization = null;

    /**
     * @var string $CountryCode
     * @access public
     */
    public $CountryCode = null;

    /**
     * @param string $ConsigneeName
     * @param string $AttentionName
     * @param string[] $AddressLine
     * @param string $PoliticalDivision2
     * @param string $PoliticalDivision1
     * @param string $PostcodePrimaryLow
     * @param string $PostcodeExtendedLow
     * @param string $Region
     * @param string $Urbanization
     * @param string $CountryCode
     * @access public
     */
    public function __construct($ConsigneeName = null, $AttentionName = null, $AddressLine = null, $PoliticalDivision2 = null, $PoliticalDivision1 = null, $PostcodePrimaryLow = null, $PostcodeExtendedLow = null, $Region = null, $Urbanization = null, $CountryCode = null)
    {
      $this->ConsigneeName = $ConsigneeName;
      $this->AttentionName = $AttentionName;
      $this->AddressLine = $AddressLine;
      $this->PoliticalDivision2 = $PoliticalDivision2;
      $this->PoliticalDivision1 = $PoliticalDivision1;
      $this->PostcodePrimaryLow = $PostcodePrimaryLow;
      $this->PostcodeExtendedLow = $PostcodeExtendedLow;
      $this->Region = $Region;
      $this->Urbanization = $Urbanization;
      $this->CountryCode = $CountryCode;
    }

    /**
     * @return string
     */
    public function getConsigneeName()
    {
      return $this->ConsigneeName;
    }

    /**
     * @param string $ConsigneeName
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setConsigneeName($ConsigneeName)
    {
      $this->ConsigneeName = $ConsigneeName;
      return $this;
    }

    /**
     * @return string
     */
    public function getAttentionName()
    {
      return $this->AttentionName;
    }

    /**
     * @param string $AttentionName
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setAttentionName($AttentionName)
    {
      $this->AttentionName = $AttentionName;
      return $this;
    }

    /**
     * @return string[]
     */
    public function getAddressLine()
    {
      return $this->AddressLine;
    }

    /**
     * @param string[] $AddressLine
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setAddressLine($AddressLine)
    {
      $this->AddressLine = $AddressLine;
      return $this;
    }

    /**
     * @return string
     */
    public function getPoliticalDivision2()
    {
      return $this->PoliticalDivision2;
    }

    /**
     * @param string $PoliticalDivision2
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setPoliticalDivision2($PoliticalDivision2)
    {
      $this->PoliticalDivision2 = $PoliticalDivision2;
      return $this;
    }

    /**
     * @return string
     */
    public function getPoliticalDivision1()
    {
      return $this->PoliticalDivision1;
    }

    /**
     * @param string $PoliticalDivision1
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setPoliticalDivision1($PoliticalDivision1)
    {
      $this->PoliticalDivision1 = $PoliticalDivision1;
      return $this;
    }

    /**
     * @return string
     */
    public function getPostcodePrimaryLow()
    {
      return $this->PostcodePrimaryLow;
    }

    /**
     * @param string $PostcodePrimaryLow
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setPostcodePrimaryLow($PostcodePrimaryLow)
    {
      $this->PostcodePrimaryLow = $PostcodePrimaryLow;
      return $this;
    }

    /**
     * @return string
     */
    public function getPostcodeExtendedLow()
    {
      return $this->PostcodeExtendedLow;
    }

    /**
     * @param string $PostcodeExtendedLow
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setPostcodeExtendedLow($PostcodeExtendedLow)
    {
      $this->PostcodeExtendedLow = $PostcodeExtendedLow;
      return $this;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
      return $this->Region;
    }

    /**
     * @param string $Region
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setRegion($Region)
    {
      $this->Region = $Region;
      return $this;
    }

    /**
     * @return string
     */
    public function getUrbanization()
    {
      return $this->Urbanization;
    }

    /**
     * @param string $Urbanization
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setUrbanization($Urbanization)
    {
      $this->Urbanization = $Urbanization;
      return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
      return $this->CountryCode;
    }

    /**
     * @param string $CountryCode
     * @return \SparkLib\UPS\StreetAddressValidate\AddressKeyFormatType
     */
    public function setCountryCode($CountryCode)
    {
      $this->CountryCode = $CountryCode;
      return $this;
    }

}
