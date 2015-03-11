<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class LocaleType
{

  /**
   *
   * @var string $Language
   * @access public
   */
  public $Language = null;

  /**
   *
   * @var string $Dialect
   * @access public
   */
  public $Dialect = null;

  /**
   *
   * @param string $Language
   * @param string $Dialect
   * @access public
   */
  public function __construct($Language = null, $Dialect = null)
  {
    $this->Language = $Language;
    $this->Dialect = $Dialect;
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

  /**
   *
   * @return string
   */
  public function getDialect()
  {
    return $this->Dialect;
  }

  /**
   *
   * @param string $Dialect
   */
  public function setDialect($Dialect)
  {
    $this->Dialect = $Dialect;
  }

}
