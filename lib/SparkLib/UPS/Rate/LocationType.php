<?php

namespace SparkLib\UPS\Rate;

class LocationType
{

  /**
   * 
   * @var string $LocationElementName
   * @access public
   */
  public $LocationElementName = null;

  /**
   * 
   * @var string $XPathOfElement
   * @access public
   */
  public $XPathOfElement = null;

  /**
   * 
   * @var string $OriginalValue
   * @access public
   */
  public $OriginalValue = null;

  /**
   * 
   * @param string $LocationElementName
   * @param string $XPathOfElement
   * @param string $OriginalValue
   * @access public
   */
  public function __construct($LocationElementName = null, $XPathOfElement = null, $OriginalValue = null)
  {
    $this->LocationElementName = $LocationElementName;
    $this->XPathOfElement = $XPathOfElement;
    $this->OriginalValue = $OriginalValue;
  }

  /**
   * 
   * @return string
   */
  public function getLocationElementName()
  {
    return $this->LocationElementName;
  }

  /**
   * 
   * @param string $LocationElementName
   */
  public function setLocationElementName($LocationElementName)
  {
    $this->LocationElementName = $LocationElementName;
  }

  /**
   * 
   * @return string
   */
  public function getXPathOfElement()
  {
    return $this->XPathOfElement;
  }

  /**
   * 
   * @param string $XPathOfElement
   */
  public function setXPathOfElement($XPathOfElement)
  {
    $this->XPathOfElement = $XPathOfElement;
  }

  /**
   * 
   * @return string
   */
  public function getOriginalValue()
  {
    return $this->OriginalValue;
  }

  /**
   * 
   * @param string $OriginalValue
   */
  public function setOriginalValue($OriginalValue)
  {
    $this->OriginalValue = $OriginalValue;
  }

}
