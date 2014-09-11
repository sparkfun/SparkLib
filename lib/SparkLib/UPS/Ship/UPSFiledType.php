<?php

namespace SparkLib\UPS\Ship;

class UPSFiledType
{

  /**
   * 
   * @var POAType $POA
   * @access public
   */
  public $POA = null;

  /**
   * 
   * @param POAType $POA
   * @access public
   */
  public function __construct($POA = null)
  {
    $this->POA = $POA;
  }

  /**
   * 
   * @return POAType
   */
  public function getPOA()
  {
    return $this->POA;
  }

  /**
   * 
   * @param POAType $POA
   */
  public function setPOA($POA)
  {
    $this->POA = $POA;
  }

}
