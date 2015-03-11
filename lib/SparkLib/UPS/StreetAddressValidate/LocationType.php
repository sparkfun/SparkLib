<?php

namespace SparkLib\UPS\StreetAddressValidate;

class LocationType
{

    /**
     * @var string $LocationElementName
     * @access public
     */
    public $LocationElementName = null;

    /**
     * @var string $XPathOfElement
     * @access public
     */
    public $XPathOfElement = null;

    /**
     * @var string $OriginalValue
     * @access public
     */
    public $OriginalValue = null;

    /**
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
     * @return string
     */
    public function getLocationElementName()
    {
      return $this->LocationElementName;
    }

    /**
     * @param string $LocationElementName
     * @return \SparkLib\UPS\StreetAddressValidate\LocationType
     */
    public function setLocationElementName($LocationElementName)
    {
      $this->LocationElementName = $LocationElementName;
      return $this;
    }

    /**
     * @return string
     */
    public function getXPathOfElement()
    {
      return $this->XPathOfElement;
    }

    /**
     * @param string $XPathOfElement
     * @return \SparkLib\UPS\StreetAddressValidate\LocationType
     */
    public function setXPathOfElement($XPathOfElement)
    {
      $this->XPathOfElement = $XPathOfElement;
      return $this;
    }

    /**
     * @return string
     */
    public function getOriginalValue()
    {
      return $this->OriginalValue;
    }

    /**
     * @param string $OriginalValue
     * @return \SparkLib\UPS\StreetAddressValidate\LocationType
     */
    public function setOriginalValue($OriginalValue)
    {
      $this->OriginalValue = $OriginalValue;
      return $this;
    }

}
