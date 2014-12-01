<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class DeliveryConfirmationType
{

  /**
   *
   * @var string $DCISType
   * @access public
   */
  public $DCISType = null;

  /**
   *
   * @var string $DCISNumber
   * @access public
   */
  public $DCISNumber = null;

  /**
   *
   * @param string $DCISType
   * @param string $DCISNumber
   * @access public
   */
  public function __construct($DCISType = null, $DCISNumber = null)
  {
    $this->DCISType = $DCISType;
    $this->DCISNumber = $DCISNumber;
  }

  /**
   *
   * @return string
   */
  public function getDCISType()
  {
    return $this->DCISType;
  }

  /**
   *
   * @param string $DCISType
   */
  public function setDCISType($DCISType)
  {
    $this->DCISType = $DCISType;
  }

  /**
   *
   * @return string
   */
  public function getDCISNumber()
  {
    return $this->DCISNumber;
  }

  /**
   *
   * @param string $DCISNumber
   */
  public function setDCISNumber($DCISNumber)
  {
    $this->DCISNumber = $DCISNumber;
  }

}
