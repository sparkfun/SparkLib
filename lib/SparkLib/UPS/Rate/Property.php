<?php

namespace SparkLib\UPS\Rate;

class Property
{

  /**
   * 
   * @var string $_
   * @access public
   */
  public $_ = null;

  /**
   * 
   * @var string $Key
   * @access public
   */
  public $Key = null;

  /**
   * 
   * @param string $_
   * @param string $Key
   * @access public
   */
  public function __construct($_ = null, $Key = null)
  {
    $this->_ = $_;
    $this->Key = $Key;
  }

  /**
   * 
   * @return string
   */
  public function get_()
  {
    return $this->_;
  }

  /**
   * 
   * @param string $_
   */
  public function set_($_)
  {
    $this->_ = $_;
  }

  /**
   * 
   * @return string
   */
  public function getKey()
  {
    return $this->Key;
  }

  /**
   * 
   * @param string $Key
   */
  public function setKey($Key)
  {
    $this->Key = $Key;
  }

}
