<?php

namespace SparkLib\UPS\Rate;

class RestrictedArticlesType
{

  /**
   * 
   * @var string $AlcoholicBeveragesIndicator
   * @access public
   */
  public $AlcoholicBeveragesIndicator = null;

  /**
   * 
   * @var string $DiagnosticSpecimensIndicator
   * @access public
   */
  public $DiagnosticSpecimensIndicator = null;

  /**
   * 
   * @var string $PerishablesIndicator
   * @access public
   */
  public $PerishablesIndicator = null;

  /**
   * 
   * @var string $PlantsIndicator
   * @access public
   */
  public $PlantsIndicator = null;

  /**
   * 
   * @var string $SeedsIndicator
   * @access public
   */
  public $SeedsIndicator = null;

  /**
   * 
   * @var string $SpecialExceptionsIndicator
   * @access public
   */
  public $SpecialExceptionsIndicator = null;

  /**
   * 
   * @var string $TobaccoIndicator
   * @access public
   */
  public $TobaccoIndicator = null;

  /**
   * 
   * @param string $AlcoholicBeveragesIndicator
   * @param string $DiagnosticSpecimensIndicator
   * @param string $PerishablesIndicator
   * @param string $PlantsIndicator
   * @param string $SeedsIndicator
   * @param string $SpecialExceptionsIndicator
   * @param string $TobaccoIndicator
   * @access public
   */
  public function __construct($AlcoholicBeveragesIndicator = null, $DiagnosticSpecimensIndicator = null, $PerishablesIndicator = null, $PlantsIndicator = null, $SeedsIndicator = null, $SpecialExceptionsIndicator = null, $TobaccoIndicator = null)
  {
    $this->AlcoholicBeveragesIndicator = $AlcoholicBeveragesIndicator;
    $this->DiagnosticSpecimensIndicator = $DiagnosticSpecimensIndicator;
    $this->PerishablesIndicator = $PerishablesIndicator;
    $this->PlantsIndicator = $PlantsIndicator;
    $this->SeedsIndicator = $SeedsIndicator;
    $this->SpecialExceptionsIndicator = $SpecialExceptionsIndicator;
    $this->TobaccoIndicator = $TobaccoIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getAlcoholicBeveragesIndicator()
  {
    return $this->AlcoholicBeveragesIndicator;
  }

  /**
   * 
   * @param string $AlcoholicBeveragesIndicator
   */
  public function setAlcoholicBeveragesIndicator($AlcoholicBeveragesIndicator)
  {
    $this->AlcoholicBeveragesIndicator = $AlcoholicBeveragesIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getDiagnosticSpecimensIndicator()
  {
    return $this->DiagnosticSpecimensIndicator;
  }

  /**
   * 
   * @param string $DiagnosticSpecimensIndicator
   */
  public function setDiagnosticSpecimensIndicator($DiagnosticSpecimensIndicator)
  {
    $this->DiagnosticSpecimensIndicator = $DiagnosticSpecimensIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getPerishablesIndicator()
  {
    return $this->PerishablesIndicator;
  }

  /**
   * 
   * @param string $PerishablesIndicator
   */
  public function setPerishablesIndicator($PerishablesIndicator)
  {
    $this->PerishablesIndicator = $PerishablesIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getPlantsIndicator()
  {
    return $this->PlantsIndicator;
  }

  /**
   * 
   * @param string $PlantsIndicator
   */
  public function setPlantsIndicator($PlantsIndicator)
  {
    $this->PlantsIndicator = $PlantsIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getSeedsIndicator()
  {
    return $this->SeedsIndicator;
  }

  /**
   * 
   * @param string $SeedsIndicator
   */
  public function setSeedsIndicator($SeedsIndicator)
  {
    $this->SeedsIndicator = $SeedsIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getSpecialExceptionsIndicator()
  {
    return $this->SpecialExceptionsIndicator;
  }

  /**
   * 
   * @param string $SpecialExceptionsIndicator
   */
  public function setSpecialExceptionsIndicator($SpecialExceptionsIndicator)
  {
    $this->SpecialExceptionsIndicator = $SpecialExceptionsIndicator;
  }

  /**
   * 
   * @return string
   */
  public function getTobaccoIndicator()
  {
    return $this->TobaccoIndicator;
  }

  /**
   * 
   * @param string $TobaccoIndicator
   */
  public function setTobaccoIndicator($TobaccoIndicator)
  {
    $this->TobaccoIndicator = $TobaccoIndicator;
  }

}
