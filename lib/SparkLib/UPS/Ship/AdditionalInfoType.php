<?php

namespace SparkLib\UPS\Ship;

class AdditionalInfoType
{

  /**
   * 
   * @var string $Type
   * @access public
   */
  public $Type = null;

  /**
   * 
   * @var AdditionalCodeDescType $Value
   * @access public
   */
  public $Value = null;

  /**
   * 
   * @param string $Type
   * @param AdditionalCodeDescType $Value
   * @access public
   */
  public function __construct($Type = null, $Value = null)
  {
    $this->Type = $Type;
    $this->Value = $Value;
  }

  /**
   * 
   * @return string
   */
  public function getType()
  {
    return $this->Type;
  }

  /**
   * 
   * @param string $Type
   */
  public function setType($Type)
  {
    $this->Type = $Type;
  }

  /**
   * 
   * @return AdditionalCodeDescType
   */
  public function getValue()
  {
    return $this->Value;
  }

  /**
   * 
   * @param AdditionalCodeDescType $Value
   */
  public function setValue($Value)
  {
    $this->Value = $Value;
  }

}
