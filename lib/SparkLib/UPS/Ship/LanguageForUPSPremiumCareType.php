<?php

namespace SparkLib\UPS\Ship;

class LanguageForUPSPremiumCareType
{

  /**
   * 
   * @var string $Language
   * @access public
   */
  public $Language = null;

  /**
   * 
   * @param string $Language
   * @access public
   */
  public function __construct($Language = null)
  {
    $this->Language = $Language;
  }

  /**
   * 
   * @return string
   */
  public function getLanguage()
  {
    return $this->Language;
  }

  /**
   * 
   * @param string $Language
   */
  public function setLanguage($Language)
  {
    $this->Language = $Language;
  }

}
