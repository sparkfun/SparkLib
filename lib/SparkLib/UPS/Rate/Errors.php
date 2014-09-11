<?php

namespace SparkLib\UPS\Rate;

class Errors
{

  /**
   * 
   * @var ErrorDetailType $ErrorDetail
   * @access public
   */
  public $ErrorDetail = null;

  /**
   * 
   * @param ErrorDetailType $ErrorDetail
   * @access public
   */
  public function __construct($ErrorDetail = null)
  {
    $this->ErrorDetail = $ErrorDetail;
  }

  /**
   * 
   * @return ErrorDetailType
   */
  public function getErrorDetail()
  {
    return $this->ErrorDetail;
  }

  /**
   * 
   * @param ErrorDetailType $ErrorDetail
   */
  public function setErrorDetail($ErrorDetail)
  {
    $this->ErrorDetail = $ErrorDetail;
  }

}
