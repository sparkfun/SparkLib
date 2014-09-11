<?php

namespace SparkLib\UPS\Ship;

class ShipPhoneType
{

  /**
   * 
   * @var string $Number
   * @access public
   */
  public $Number = null;

  /**
   * 
   * @var string $Extension
   * @access public
   */
  public $Extension = null;

  /**
   * 
   * @param string $Number
   * @param string $Extension
   * @access public
   */
  public function __construct($Number = null, $Extension = null)
  {
    $this->Number = $Number;
    $this->Extension = $Extension;
  }

  /**
   * 
   * @return string
   */
  public function getNumber()
  {
    return $this->Number;
  }

  /**
   * 
   * @param string $Number
   */
  public function setNumber($Number)
  {
    $this->Number = $Number;
  }

  /**
   * 
   * @return string
   */
  public function getExtension()
  {
    return $this->Extension;
  }

  /**
   * 
   * @param string $Extension
   */
  public function setExtension($Extension)
  {
    $this->Extension = $Extension;
  }

}
