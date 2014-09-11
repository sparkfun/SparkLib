<?php

namespace SparkLib\UPS\Ship;

class OtherChargesType
{

  /**
   * 
   * @var string $MonetaryValue
   * @access public
   */
  public $MonetaryValue = null;

  /**
   * 
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   * 
   * @param string $MonetaryValue
   * @param string $Description
   * @access public
   */
  public function __construct($MonetaryValue = null, $Description = null)
  {
    $this->MonetaryValue = $MonetaryValue;
    $this->Description = $Description;
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

  /**
   * 
   * @return string
   */
  public function getDescription()
  {
    return $this->Description;
  }

  /**
   * 
   * @param string $Description
   */
  public function setDescription($Description)
  {
    $this->Description = $Description;
  }

}
