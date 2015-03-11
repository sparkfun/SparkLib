<?php

namespace SparkLib\UPS\StreetAddressValidate;

class TransactionReferenceType
{

    /**
     * @var string $CustomerContext
     * @access public
     */
    public $CustomerContext = null;

    /**
     * @var string $TransactionIdentifier
     * @access public
     */
    public $TransactionIdentifier = null;

    /**
     * @param string $CustomerContext
     * @param string $TransactionIdentifier
     * @access public
     */
    public function __construct($CustomerContext = null, $TransactionIdentifier = null)
    {
      $this->CustomerContext = $CustomerContext;
      $this->TransactionIdentifier = $TransactionIdentifier;
    }

    /**
     * @return string
     */
    public function getCustomerContext()
    {
      return $this->CustomerContext;
    }

    /**
     * @param string $CustomerContext
     * @return \SparkLib\UPS\StreetAddressValidate\TransactionReferenceType
     */
    public function setCustomerContext($CustomerContext)
    {
      $this->CustomerContext = $CustomerContext;
      return $this;
    }

    /**
     * @return string
     */
    public function getTransactionIdentifier()
    {
      return $this->TransactionIdentifier;
    }

    /**
     * @param string $TransactionIdentifier
     * @return \SparkLib\UPS\StreetAddressValidate\TransactionReferenceType
     */
    public function setTransactionIdentifier($TransactionIdentifier)
    {
      $this->TransactionIdentifier = $TransactionIdentifier;
      return $this;
    }

}
