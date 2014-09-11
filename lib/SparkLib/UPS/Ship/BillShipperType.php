<?php

namespace SparkLib\UPS\Ship;

class BillShipperType
{

  /**
   * 
   * @var string $AccountNumber
   * @access public
   */
  public $AccountNumber = null;

  /**
   * 
   * @var CreditCardType $CreditCard
   * @access public
   */
  public $CreditCard = null;

  /**
   * 
   * @param string $AccountNumber
   * @param CreditCardType $CreditCard
   * @access public
   */
  public function __construct($AccountNumber = null, $CreditCard = null)
  {
    $this->AccountNumber = $AccountNumber;
    $this->CreditCard = $CreditCard;
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
   * @return CreditCardType
   */
  public function getCreditCard()
  {
    return $this->CreditCard;
  }

  /**
   * 
   * @param CreditCardType $CreditCard
   */
  public function setCreditCard($CreditCard)
  {
    $this->CreditCard = $CreditCard;
  }

}
