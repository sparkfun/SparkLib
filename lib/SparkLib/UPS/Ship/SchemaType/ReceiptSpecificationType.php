<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ReceiptSpecificationType
{

  /**
   *
   * @var ReceiptImageFormatType $ImageFormat
   * @access public
   */
  public $ImageFormat = null;

  /**
   *
   * @param ReceiptImageFormatType $ImageFormat
   * @access public
   */
  public function __construct($ImageFormat = null)
  {
    $this->ImageFormat = $ImageFormat;
  }

  /**
   *
   * @return ReceiptImageFormatType
   */
  public function getImageFormat()
  {
    return $this->ImageFormat;
  }

  /**
   *
   * @param ReceiptImageFormatType $ImageFormat
   */
  public function setImageFormat($ImageFormat)
  {
    $this->ImageFormat = $ImageFormat;
  }

}
