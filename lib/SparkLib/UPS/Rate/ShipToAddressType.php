<?php

namespace SparkLib\UPS\Rate;

class ShipToAddressType
{

  /**
   * 
   * @var string $ResidentialAddressIndicator
   * @access public
   */
  public $ResidentialAddressIndicator = null;

  /**
   * 
   * @param string $ResidentialAddressIndicator
   * @access public
   */
  public function __construct($ResidentialAddressIndicator = null)
  {
    $this->ResidentialAddressIndicator = $ResidentialAddressIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getResidentialAddressIndicator()
  {
    return $this->ResidentialAddressIndicator;
  }

  /**
   * 
   * @param string $ResidentialAddressIndicator
   */
  public function setResidentialAddressIndicator($ResidentialAddressIndicator)
  {
    $this->ResidentialAddressIndicator = $ResidentialAddressIndicator;
  }

}
