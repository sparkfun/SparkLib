<?php

namespace SparkLib\UPS\Ship;

class VerbalConfirmationType
{

  /**
   * 
   * @var ContactInfoType $ContactInfo
   * @access public
   */
  public $ContactInfo = null;

  /**
   * 
   * @param ContactInfoType $ContactInfo
   * @access public
   */
  public function __construct($ContactInfo = null)
  {
    $this->ContactInfo = $ContactInfo;
  }

  /**
   * 
   * @return ContactInfoType
   */
  public function getContactInfo()
  {
    return $this->ContactInfo;
  }

  /**
   * 
   * @param ContactInfoType $ContactInfo
   */
  public function setContactInfo($ContactInfo)
  {
    $this->ContactInfo = $ContactInfo;
  }

}
