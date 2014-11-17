<?php

namespace SparkLib\UPS\StreetAddressValidate;

class ErrorDetailType
{

    /**
     * @var string $Severity
     * @access public
     */
    public $Severity = null;

    /**
     * @var CodeType $PrimaryErrorCode
     * @access public
     */
    public $PrimaryErrorCode = null;

    /**
     * @var string $MinimumRetrySeconds
     * @access public
     */
    public $MinimumRetrySeconds = null;

    /**
     * @var LocationType $Location
     * @access public
     */
    public $Location = null;

    /**
     * @var CodeType[] $SubErrorCode
     * @access public
     */
    public $SubErrorCode = null;

    /**
     * @param string $Severity
     * @param CodeType $PrimaryErrorCode
     * @param string $MinimumRetrySeconds
     * @param LocationType $Location
     * @param CodeType[] $SubErrorCode
     * @access public
     */
    public function __construct($Severity = null, $PrimaryErrorCode = null, $MinimumRetrySeconds = null, $Location = null, $SubErrorCode = null)
    {
      $this->Severity = $Severity;
      $this->PrimaryErrorCode = $PrimaryErrorCode;
      $this->MinimumRetrySeconds = $MinimumRetrySeconds;
      $this->Location = $Location;
      $this->SubErrorCode = $SubErrorCode;
    }

    /**
     * @return string
     */
    public function getSeverity()
    {
      return $this->Severity;
    }

    /**
     * @param string $Severity
     * @return \SparkLib\UPS\StreetAddressValidate\ErrorDetailType
     */
    public function setSeverity($Severity)
    {
      $this->Severity = $Severity;
      return $this;
    }

    /**
     * @return CodeType
     */
    public function getPrimaryErrorCode()
    {
      return $this->PrimaryErrorCode;
    }

    /**
     * @param CodeType $PrimaryErrorCode
     * @return \SparkLib\UPS\StreetAddressValidate\ErrorDetailType
     */
    public function setPrimaryErrorCode($PrimaryErrorCode)
    {
      $this->PrimaryErrorCode = $PrimaryErrorCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getMinimumRetrySeconds()
    {
      return $this->MinimumRetrySeconds;
    }

    /**
     * @param string $MinimumRetrySeconds
     * @return \SparkLib\UPS\StreetAddressValidate\ErrorDetailType
     */
    public function setMinimumRetrySeconds($MinimumRetrySeconds)
    {
      $this->MinimumRetrySeconds = $MinimumRetrySeconds;
      return $this;
    }

    /**
     * @return LocationType
     */
    public function getLocation()
    {
      return $this->Location;
    }

    /**
     * @param LocationType $Location
     * @return \SparkLib\UPS\StreetAddressValidate\ErrorDetailType
     */
    public function setLocation($Location)
    {
      $this->Location = $Location;
      return $this;
    }

    /**
     * @return CodeType[]
     */
    public function getSubErrorCode()
    {
      return $this->SubErrorCode;
    }

    /**
     * @param CodeType[] $SubErrorCode
     * @return \SparkLib\UPS\StreetAddressValidate\ErrorDetailType
     */
    public function setSubErrorCode($SubErrorCode)
    {
      $this->SubErrorCode = $SubErrorCode;
      return $this;
    }

}
