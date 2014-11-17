<?php

namespace SparkLib\UPS\StreetAddressValidate;

class ClientInformationType
{

    /**
     * @var Property[] $Property
     * @access public
     */
    public $Property = null;

    /**
     * @param Property[] $Property
     * @access public
     */
    public function __construct($Property = null)
    {
      $this->Property = $Property;
    }

    /**
     * @return Property[]
     */
    public function getProperty()
    {
      return $this->Property;
    }

    /**
     * @param Property[] $Property
     * @return \SparkLib\UPS\StreetAddressValidate\ClientInformationType
     */
    public function setProperty($Property)
    {
      $this->Property = $Property;
      return $this;
    }

}
