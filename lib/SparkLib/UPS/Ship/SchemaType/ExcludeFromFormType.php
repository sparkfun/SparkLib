<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class ExcludeFromFormType
{

  /**
   *
   * @var string $FormType
   * @access public
   */
  public $FormType = null;

  /**
   *
   * @param string $FormType
   * @access public
   */
  public function __construct($FormType = null)
  {
    $this->FormType = $FormType;
  }

  /**
   *
   * @return string
   */
  public function getFormType()
  {
    return $this->FormType;
  }

  /**
   *
   * @param string $FormType
   */
  public function setFormType($FormType)
  {
    $this->FormType = $FormType;
  }

}
