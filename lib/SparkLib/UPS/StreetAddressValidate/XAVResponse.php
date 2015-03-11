<?php

namespace SparkLib\UPS\StreetAddressValidate;

class XAVResponse
{

    /**
     * @var ResponseType $Response
     * @access public
     */
    public $Response = null;

    /**
     * @var string $ValidAddressIndicator
     * @access public
     */
    public $ValidAddressIndicator = null;

    /**
     * @var string $AmbiguousAddressIndicator
     * @access public
     */
    public $AmbiguousAddressIndicator = null;

    /**
     * @var string $NoCandidatesIndicator
     * @access public
     */
    public $NoCandidatesIndicator = null;

    /**
     * @var AddressClassificationType $AddressClassification
     * @access public
     */
    public $AddressClassification = null;

    /**
     * @var CandidateType $Candidate
     * @access public
     */
    public $Candidate = null;

    /**
     * @param ResponseType $Response
     * @param string $ValidAddressIndicator
     * @param string $AmbiguousAddressIndicator
     * @param string $NoCandidatesIndicator
     * @param AddressClassificationType $AddressClassification
     * @param CandidateType $Candidate
     * @access public
     */
    public function __construct($Response = null, $ValidAddressIndicator = null, $AmbiguousAddressIndicator = null, $NoCandidatesIndicator = null, $AddressClassification = null, $Candidate = null)
    {
      $this->Response = $Response;
      $this->ValidAddressIndicator = $ValidAddressIndicator;
      $this->AmbiguousAddressIndicator = $AmbiguousAddressIndicator;
      $this->NoCandidatesIndicator = $NoCandidatesIndicator;
      $this->AddressClassification = $AddressClassification;
      $this->Candidate = $Candidate;
    }

    /**
     * @return ResponseType
     */
    public function getResponse()
    {
      return $this->Response;
    }

    /**
     * @param ResponseType $Response
     * @return \SparkLib\UPS\StreetAddressValidate\XAVResponse
     */
    public function setResponse($Response)
    {
      $this->Response = $Response;
      return $this;
    }

    /**
     * @return string
     */
    public function getValidAddressIndicator()
    {
      return $this->ValidAddressIndicator;
    }

    /**
     * @param string $ValidAddressIndicator
     * @return \SparkLib\UPS\StreetAddressValidate\XAVResponse
     */
    public function setValidAddressIndicator($ValidAddressIndicator)
    {
      $this->ValidAddressIndicator = $ValidAddressIndicator;
      return $this;
    }

    /**
     * @return string
     */
    public function getAmbiguousAddressIndicator()
    {
      return $this->AmbiguousAddressIndicator;
    }

    /**
     * @param string $AmbiguousAddressIndicator
     * @return \SparkLib\UPS\StreetAddressValidate\XAVResponse
     */
    public function setAmbiguousAddressIndicator($AmbiguousAddressIndicator)
    {
      $this->AmbiguousAddressIndicator = $AmbiguousAddressIndicator;
      return $this;
    }

    /**
     * @return string
     */
    public function getNoCandidatesIndicator()
    {
      return $this->NoCandidatesIndicator;
    }

    /**
     * @param string $NoCandidatesIndicator
     * @return \SparkLib\UPS\StreetAddressValidate\XAVResponse
     */
    public function setNoCandidatesIndicator($NoCandidatesIndicator)
    {
      $this->NoCandidatesIndicator = $NoCandidatesIndicator;
      return $this;
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
     * @return \SparkLib\UPS\StreetAddressValidate\XAVResponse
     */
    public function setAddressClassification($AddressClassification)
    {
      $this->AddressClassification = $AddressClassification;
      return $this;
    }

    /**
     * @return CandidateType
     */
    public function getCandidate()
    {
      return $this->Candidate;
    }

    /**
     * @param CandidateType $Candidate
     * @return \SparkLib\UPS\StreetAddressValidate\XAVResponse
     */
    public function setCandidate($Candidate)
    {
      $this->Candidate = $Candidate;
      return $this;
    }

}
