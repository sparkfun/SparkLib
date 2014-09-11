<?php

namespace SparkLib\UPS\Ship;

class CodeType
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
   * @var string $Digest
   * @access public
   */
  public $Digest = null;

  /**
   * 
   * @param string $Code
   * @param string $Description
   * @param string $Digest
   * @access public
   */
  public function __construct($Code = null, $Description = null, $Digest = null)
  {
    $this->Code = $Code;
    $this->Description = $Description;
    $this->Digest = $Digest;
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

  /**
   * 
   * @return string
   */
  public function getDigest()
  {
    return $this->Digest;
  }

  /**
   * 
   * @param string $Digest
   */
  public function setDigest($Digest)
  {
    $this->Digest = $Digest;
  }

}
