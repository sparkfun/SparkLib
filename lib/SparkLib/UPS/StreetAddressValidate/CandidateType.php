<?php

namespace SparkLib\UPS\StreetAddressValidate;

class CandidateType
{

    /**
     * @var AddressClassificationType $AddressClassification
     * @access public
     */
    public $AddressClassification = null;

    /**
     * @var AddressKeyFormatType $AddressKeyFormat
     * @access public
     */
    public $AddressKeyFormat = null;

    /**
     * @param AddressClassificationType $AddressClassification
     * @param AddressKeyFormatType $AddressKeyFormat
     * @access public
     */
    public function __construct($AddressClassification = null, $AddressKeyFormat = null)
    {
      $this->AddressClassification = $AddressClassification;
      $this->AddressKeyFormat = $AddressKeyFormat;
    }

    /**
     * @return AddressClassificationType
     */
    public function getAddressClassification()
    {
      return $this->AddressClassification;
    }

    /**
     * @param AddressClassificationType $AddressClassification
     * @return \SparkLib\UPS\StreetAddressValidate\CandidateType
     */
    public function setAddressClassification($AddressClassification)
    {
      $this->AddressClassification = $AddressClassification;
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
     * @return \SparkLib\UPS\StreetAddressValidate\CandidateType
     */
    public function setAddressKeyFormat($AddressKeyFormat)
    {
      $this->AddressKeyFormat = $AddressKeyFormat;
      return $this;
    }

}
