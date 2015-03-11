<?php

namespace SparkLib\UPS\StreetAddressValidate;

class XAVRequest
{

    /**
     * @var RequestType $Request
     * @access public
     */
    public $Request = null;

    /**
     * @var string $RegionalRequestIndicator
     * @access public
     */
    public $RegionalRequestIndicator = null;

    /**
     * @var string $MaximumCandidateListSize
     * @access public
     */
    public $MaximumCandidateListSize = null;

    /**
     * @var AddressKeyFormatType $AddressKeyFormat
     * @access public
     */
    public $AddressKeyFormat = null;

    /**
     * @param RequestType $Request
     * @param string $RegionalRequestIndicator
     * @param string $MaximumCandidateListSize
     * @param AddressKeyFormatType $AddressKeyFormat
     * @access public
     */
    public function __construct($Request = null, $RegionalRequestIndicator = null, $MaximumCandidateListSize = null, $AddressKeyFormat = null)
    {
      $this->Request = $Request;
      $this->RegionalRequestIndicator = $RegionalRequestIndicator;
      $this->MaximumCandidateListSize = $MaximumCandidateListSize;
      $this->AddressKeyFormat = $AddressKeyFormat;
    }

    /**
     * @return RequestType
     */
    public function getRequest()
    {
      return $this->Request;
    }

    /**
     * @param RequestType $Request
     * @return \SparkLib\UPS\StreetAddressValidate\XAVRequest
     */
    public function setRequest($Request)
    {
      $this->Request = $Request;
      return $this;
    }

    /**
     * @return string
     */
    public function getRegionalRequestIndicator()
    {
      return $this->RegionalRequestIndicator;
    }

    /**
     * @param string $RegionalRequestIndicator
     * @return \SparkLib\UPS\StreetAddressValidate\XAVRequest
     */
    public function setRegionalRequestIndicator($RegionalRequestIndicator)
    {
      $this->RegionalRequestIndicator = $RegionalRequestIndicator;
      return $this;
    }

    /**
     * @return string
     */
    public function getMaximumCandidateListSize()
    {
      return $this->MaximumCandidateListSize;
    }

    /**
     * @param string $MaximumCandidateListSize
     * @return \SparkLib\UPS\StreetAddressValidate\XAVRequest
     */
    public function setMaximumCandidateListSize($MaximumCandidateListSize)
    {
      $this->MaximumCandidateListSize = $MaximumCandidateListSize;
      return $this;
    }

    /**
     * @return AddressKeyFormatType
     */
    public function getAddressKeyFormat()
    {
      return $this->AddressKeyFormat;
    }

    /**
     * @param AddressKeyFormatType $AddressKeyFormat
     * @return \SparkLib\UPS\StreetAddressValidate\XAVRequest
     */
    public function setAddressKeyFormat($AddressKeyFormat)
    {
      $this->AddressKeyFormat = $AddressKeyFormat;
      return $this;
    }

}
