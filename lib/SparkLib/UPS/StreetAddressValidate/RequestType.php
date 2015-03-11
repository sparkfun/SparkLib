<?php

namespace SparkLib\UPS\StreetAddressValidate;

class RequestType
{

    /**
     * @var string[] $RequestOption
     * @access public
     */
    public $RequestOption = null;

    /**
     * @var TransactionReferenceType $TransactionReference
     * @access public
     */
    public $TransactionReference = null;

    /**
     * @param string[] $RequestOption
     * @param TransactionReferenceType $TransactionReference
     * @access public
     */
    public function __construct($RequestOption = null, $TransactionReference = null)
    {
      $this->RequestOption = $RequestOption;
      $this->TransactionReference = $TransactionReference;
    }

    /**
     * @return string[]
     */
    public function getRequestOption()
    {
      return $this->RequestOption;
    }

    /**
     * @param string[] $RequestOption
     * @return \SparkLib\UPS\StreetAddressValidate\RequestType
     */
    public function setRequestOption($RequestOption)
    {
      $this->RequestOption = $RequestOption;
      return $this;
    }

    /**
     * @return TransactionReferenceType
     */
    public function getTransactionReference()
    {
      return $this->TransactionReference;
    }

    /**
     * @param TransactionReferenceType $TransactionReference
     * @return \SparkLib\UPS\StreetAddressValidate\RequestType
     */
    public function setTransactionReference($TransactionReference)
    {
      $this->TransactionReference = $TransactionReference;
      return $this;
    }

}
