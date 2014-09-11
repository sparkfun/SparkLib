<?php

namespace SparkLib\UPS\Ship;

class BillReceiverType
{

  /**
   * 
   * @var string $AccountNumber
   * @access public
   */
  public $AccountNumber = null;

  /**
   * 
   * @var BillReceiverAddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   * 
   * @param string $AccountNumber
   * @param BillReceiverAddressType $Address
   * @access public
   */
  public function __construct($AccountNumber = null, $Address = null)
  {
    $this->AccountNumber = $AccountNumber;
    $this->Address = $Address;
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
   * @return BillReceiverAddressType
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   * 
   * @param BillReceiverAddressType $Address
   */
  public function setAddress($Address)
  {
    $this->Address = $Address;
  }

}
