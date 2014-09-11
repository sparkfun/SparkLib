<?php

namespace SparkLib\UPS\Ship;

class LabelStockSizeType
{

  /**
   * 
   * @var string $Height
   * @access public
   */
  public $Height = null;

  /**
   * 
   * @var string $Width
   * @access public
   */
  public $Width = null;

  /**
   * 
   * @param string $Height
   * @param string $Width
   * @access public
   */
  public function __construct($Height = null, $Width = null)
  {
    $this->Height = $Height;
    $this->Width = $Width;
  }

  /**
   * 
   * @return string
   */
  public function getHeight()
  {
    return $this->Height;
  }

  /**
   * 
   * @param string $Height
   */
  public function setHeight($Height)
  {
    $this->Height = $Height;
  }

  /**
   * 
   * @return string
   */
  public function getWidth()
  {
    return $this->Width;
  }

  /**
   * 
   * @param string $Width
   */
  public function setWidth($Width)
  {
    $this->Width = $Width;
  }

}
