<?php

namespace SparkLib\UPS\StreetAddressValidate;

class Errors
{

    /**
     * @var ErrorDetailType $ErrorDetail
     * @access public
     */
    public $ErrorDetail = null;

    /**
     * @var TransactionReferenceType $TransactionReference
     * @access public
     */
    public $TransactionReference = null;

    /**
     * @param ErrorDetailType $ErrorDetail
     * @param TransactionReferenceType $TransactionReference
     * @access public
     */
    public function __construct($ErrorDetail = null, $TransactionReference = null)
    {
      $this->ErrorDetail = $ErrorDetail;
      $this->TransactionReference = $TransactionReference;
    }

    /**
     * @return ErrorDetailType
     */
    public function getErrorDetail()
    {
      return $this->ErrorDetail;
    }

    /**
     * @param ErrorDetailType $ErrorDetail
     * @return \SparkLib\UPS\StreetAddressValidate\Errors
     */
    public function setErrorDetail($ErrorDetail)
    {
      $this->ErrorDetail = $ErrorDetail;
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
     * @return \SparkLib\UPS\StreetAddressValidate\Errors
     */
    public function setTransactionReference($TransactionReference)
    {
      $this->TransactionReference = $TransactionReference;
      return $this;
    }

}
