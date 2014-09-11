<?php

namespace SparkLib\UPS\Ship;

class LabelType
{

  /**
   * 
   * @var string $InternationalSignatureGraphicImage
   * @access public
   */
  public $InternationalSignatureGraphicImage = null;

  /**
   * 
   * @var string $HTMLImage
   * @access public
   */
  public $HTMLImage = null;

  /**
   * 
   * @var string $PDF417
   * @access public
   */
  public $PDF417 = null;

  /**
   * 
   * @param string $InternationalSignatureGraphicImage
   * @param string $HTMLImage
   * @param string $PDF417
   * @access public
   */
  public function __construct($InternationalSignatureGraphicImage = null, $HTMLImage = null, $PDF417 = null)
  {
    $this->InternationalSignatureGraphicImage = $InternationalSignatureGraphicImage;
    $this->HTMLImage = $HTMLImage;
    $this->PDF417 = $PDF417;
  }

  /**
   * 
   * @return string
   */
  public function getInternationalSignatureGraphicImage()
  {
    return $this->InternationalSignatureGraphicImage;
  }

  /**
   * 
   * @param string $InternationalSignatureGraphicImage
   */
  public function setInternationalSignatureGraphicImage($InternationalSignatureGraphicImage)
  {
    $this->InternationalSignatureGraphicImage = $InternationalSignatureGraphicImage;
  }

  /**
   * 
   * @return string
   */
  public function getHTMLImage()
  {
    return $this->HTMLImage;
  }

  /**
   * 
   * @param string $HTMLImage
   */
  public function setHTMLImage($HTMLImage)
  {
    $this->HTMLImage = $HTMLImage;
  }

  /**
   * 
   * @return string
   */
  public function getPDF417()
  {
    return $this->PDF417;
  }

  /**
   * 
   * @param string $PDF417
   */
  public function setPDF417($PDF417)
  {
    $this->PDF417 = $PDF417;
  }

}
