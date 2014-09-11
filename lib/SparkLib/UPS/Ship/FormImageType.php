<?php

namespace SparkLib\UPS\Ship;

class FormImageType
{

  /**
   * 
   * @var ImageFormatType $ImageFormat
   * @access public
   */
  public $ImageFormat = null;

  /**
   * 
   * @var string $GraphicImage
   * @access public
   */
  public $GraphicImage = null;

  /**
   * 
   * @param ImageFormatType $ImageFormat
   * @param string $GraphicImage
   * @access public
   */
  public function __construct($ImageFormat = null, $GraphicImage = null)
  {
    $this->ImageFormat = $ImageFormat;
    $this->GraphicImage = $GraphicImage;
  }

  /**
   * 
   * @return ImageFormatType
   */
  public function getImageFormat()
  {
    return $this->ImageFormat;
  }

  /**
   * 
   * @param ImageFormatType $ImageFormat
   */
  public function setImageFormat($ImageFormat)
  {
    $this->ImageFormat = $ImageFormat;
  }

  /**
   * 
   * @return string
   */
  public function getGraphicImage()
  {
    return $this->GraphicImage;
  }

  /**
   * 
   * @param string $GraphicImage
   */
  public function setGraphicImage($GraphicImage)
  {
    $this->GraphicImage = $GraphicImage;
  }

}
