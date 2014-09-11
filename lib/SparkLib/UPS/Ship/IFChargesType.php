<?php

namespace SparkLib\UPS\Ship;

class IFChargesType
{

  /**
   * 
   * @var string $MonetaryValue
   * @access public
   */
  public $MonetaryValue = null;

  /**
   * 
   * @param string $MonetaryValue
   * @access public
   */
  public function __construct($MonetaryValue = null)
  {
    $this->MonetaryValue = $MonetaryValue;
  }

  /**
   * 
   * @return string
   */
  public function getMonetaryValue()
  {
    return $this->MonetaryValue;
  }

  /**
   * 
   * @param string $MonetaryValue
   */
  public function setMonetaryValue($MonetaryValue)
  {
    $this->MonetaryValue = $MonetaryValue;
  }

}
