<?php

namespace SparkLib\UPS\Ship;

class SCReportType
{

  /**
   * 
   * @var ImageType $Image
   * @access public
   */
  public $Image = null;

  /**
   * 
   * @param ImageType $Image
   * @access public
   */
  public function __construct($Image = null)
  {
    $this->Image = $Image;
  }

  /**
   * 
   * @return ImageType
   */
  public function getImage()
  {
    return $this->Image;
  }

  /**
   * 
   * @param ImageType $Image
   */
  public function setImage($Image)
  {
    $this->Image = $Image;
  }

}
