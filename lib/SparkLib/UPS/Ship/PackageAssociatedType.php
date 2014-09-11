<?php

namespace SparkLib\UPS\Ship;

class PackageAssociatedType
{

  /**
   * 
   * @var string $PackageNumber
   * @access public
   */
  public $PackageNumber = null;

  /**
   * 
   * @var string $ProductAmount
   * @access public
   */
  public $ProductAmount = null;

  /**
   * 
   * @param string $PackageNumber
   * @param string $ProductAmount
   * @access public
   */
  public function __construct($PackageNumber = null, $ProductAmount = null)
  {
    $this->PackageNumber = $PackageNumber;
    $this->ProductAmount = $ProductAmount;
  }

  /**
   * 
   * @return string
   */
  public function getPackageNumber()
  {
    return $this->PackageNumber;
  }

  /**
   * 
   * @param string $PackageNumber
   */
  public function setPackageNumber($PackageNumber)
  {
    $this->PackageNumber = $PackageNumber;
  }

  /**
   * 
   * @return string
   */
  public function getProductAmount()
  {
    return $this->ProductAmount;
  }

  /**
   * 
   * @param string $ProductAmount
   */
  public function setProductAmount($ProductAmount)
  {
    $this->ProductAmount = $ProductAmount;
  }

}
