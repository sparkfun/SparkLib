<?php

namespace SparkLib\UPS\StreetAddressValidate;

class CodeType
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
     * @var string $Digest
     * @access public
     */
    public $Digest = null;

    /**
     * @param string $Code
     * @param string $Description
     * @param string $Digest
     * @access public
     */
    public function __construct($Code = null, $Description = null, $Digest = null)
    {
      $this->Code = $Code;
      $this->Description = $Description;
      $this->Digest = $Digest;
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
     * @return \SparkLib\UPS\StreetAddressValidate\CodeType
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
     * @return \SparkLib\UPS\StreetAddressValidate\CodeType
     */
    public function setDescription($Description)
    {
      $this->Description = $Description;
      return $this;
    }

    /**
     * @return string
     */
    public function getDigest()
    {
      return $this->Digest;
    }

    /**
     * @param string $Digest
     * @return \SparkLib\UPS\StreetAddressValidate\CodeType
     */
    public function setDigest($Digest)
    {
      $this->Digest = $Digest;
      return $this;
    }

}
