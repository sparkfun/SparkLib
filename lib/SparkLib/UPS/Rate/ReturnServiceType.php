<?php

namespace SparkLib\UPS\Rate;

class ReturnServiceType
{

  /**
   * 
   * @var string $Code
   * @access public
   */
  public $Code = null;

  /**
   * 
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   * 
   * @param string $Code
   * @param string $Description
   * @access public
   */
  public function __construct($Code = null, $Description = null)
  {
    $this->Code = $Code;
    $this->Description = $Description;
  }

  /**
   * 
   * @return string
   */
  public function getCode()
  {
    return $this->Code;
  }

  /**
   * 
   * @param string $Code
   */
  public function setCode($Code)
  {
    $this->Code = $Code;
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
