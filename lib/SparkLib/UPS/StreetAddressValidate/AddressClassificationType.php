<?php

namespace SparkLib\UPS\StreetAddressValidate;

class AddressClassificationType
{

    /**
     * @var string $Code
     * @access public
     */
    public $Code = null;

    /**
     * @var string $Description
     * @access public
     */
    public $Description = null;

    /**
     * @param string $Code
     * @param string $Description
     * @access public
     */
    public function __construct($Code = null, $Description = null)
    {
      $this->Code = $Code;
      $this->Description = $Description;
    }

    /**
     * @return string
     */
    public function getCode()
    {
      return $this->Code;
    }

    /**
     * @param string $Code
     * @return \SparkLib\UPS\StreetAddressValidate\AddressClassificationType
     */
    public function setCode($Code)
    {
      $this->Code = $Code;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->Description;
    }

    /**
     * @param string $Description
     * @return \SparkLib\UPS\StreetAddressValidate\AddressClassificationType
     */
    public function setDescription($Description)
    {
      $this->Description = $Description;
      return $this;
    }

}
