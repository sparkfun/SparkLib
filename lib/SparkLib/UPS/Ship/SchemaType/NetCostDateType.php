<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class NetCostDateType
{

  /**
   *
   * @var string $BeginDate
   * @access public
   */
  public $BeginDate = null;

  /**
   *
   * @var string $EndDate
   * @access public
   */
  public $EndDate = null;

  /**
   *
   * @param string $BeginDate
   * @param string $EndDate
   * @access public
   */
  public function __construct($BeginDate = null, $EndDate = null)
  {
    $this->BeginDate = $BeginDate;
    $this->EndDate = $EndDate;
  }

  /**
   *
   * @return string
   */
  public function getBeginDate()
  {
    return $this->BeginDate;
  }

  /**
   *
   * @param string $BeginDate
   */
  public function setBeginDate($BeginDate)
  {
    $this->BeginDate = $BeginDate;
  }

  /**
   *
   * @return string
   */
  public function getEndDate()
  {
    return $this->EndDate;
  }

  /**
   *
   * @param string $EndDate
   */
  public function setEndDate($EndDate)
  {
    $this->EndDate = $EndDate;
  }

}
