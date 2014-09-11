<?php

namespace SparkLib\UPS\Ship;

class BillReceiverAddressType
{

  /**
   * 
   * @var string $PostalCode
   * @access public
   */
  public $PostalCode = null;

  /**
   * 
   * @param string $PostalCode
   * @access public
   */
  public function __construct($PostalCode = null)
  {
    $this->PostalCode = $PostalCode;
  }

  /**
   * 
   * @return string
   */
  public function getPostalCode()
  {
    return $this->PostalCode;
  }

  /**
   * 
   * @param string $PostalCode
   */
  public function setPostalCode($PostalCode)
  {
    $this->PostalCode = $PostalCode;
  }

}
