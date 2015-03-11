<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class FRSPaymentInfoType
{

  /**
   *
   * @var PaymentType $Type
   * @access public
   */
  public $Type = null;

  /**
   *
   * @var string $AccountNumber
   * @access public
   */
  public $AccountNumber = null;

  /**
   *
   * @var AccountAddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   *
   * @param PaymentType $Type
   * @param string $AccountNumber
   * @param AccountAddressType $Address
   * @access public
   */
  public function __construct($Type = null, $AccountNumber = null, $Address = null)
  {
    $this->Type = $Type;
    $this->AccountNumber = $AccountNumber;
    $this->Address = $Address;
  }

  /**
   *
   * @return PaymentType
   */
  public function getType()
  {
    return $this->Type;
  }

  /**
   *
   * @param PaymentType $Type
   */
  public function setType($Type)
  {
    $this->Type = $Type;
  }

  /**
   *
   * @return string
   */
  public function getAccountNumber()
  {
    return $this->AccountNumber;
  }

  /**
   *
   * @param string $AccountNumber
   */
  public function setAccountNumber($AccountNumber)
  {
    $this->AccountNumber = $AccountNumber;
  }

  /**
   *
   * @return AccountAddressType
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   *
   * @param AccountAddressType $Address
   */
  public function setAddress($Address)
  {
    $this->Address = $Address;
  }

}
