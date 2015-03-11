<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class EEIFilingOptionType
{

  /**
   *
   * @var string $Code
   * @access public
   */
  public $Code = null;

  /**
   *
   * @var string $EMailAddress
   * @access public
   */
  public $EMailAddress = null;

  /**
   *
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   *
   * @var UPSFiledType $UPSFiled
   * @access public
   */
  public $UPSFiled = null;

  /**
   *
   * @var ShipperFiledType $ShipperFiled
   * @access public
   */
  public $ShipperFiled = null;

  /**
   *
   * @param string $Code
   * @param string $EMailAddress
   * @param string $Description
   * @param UPSFiledType $UPSFiled
   * @param ShipperFiledType $ShipperFiled
   * @access public
   */
  public function __construct($Code = null, $EMailAddress = null, $Description = null, $UPSFiled = null, $ShipperFiled = null)
  {
    $this->Code = $Code;
    $this->EMailAddress = $EMailAddress;
    $this->Description = $Description;
    $this->UPSFiled = $UPSFiled;
    $this->ShipperFiled = $ShipperFiled;
  }

  /**
   *
   * @return string
   */
  public function getCode()
  {
    return $this->Code;
  }

  /**
   *
   * @param string $Code
   */
  public function setCode($Code)
  {
    $this->Code = $Code;
  }

  /**
   *
   * @return string
   */
  public function getEMailAddress()
  {
    return $this->EMailAddress;
  }

  /**
   *
   * @param string $EMailAddress
   */
  public function setEMailAddress($EMailAddress)
  {
    $this->EMailAddress = $EMailAddress;
  }

  /**
   *
   * @return string
   */
  public function getDescription()
  {
    return $this->Description;
  }

  /**
   *
   * @param string $Description
   */
  public function setDescription($Description)
  {
    $this->Description = $Description;
  }

  /**
   *
   * @return UPSFiledType
   */
  public function getUPSFiled()
  {
    return $this->UPSFiled;
  }

  /**
   *
   * @param UPSFiledType $UPSFiled
   */
  public function setUPSFiled($UPSFiled)
  {
    $this->UPSFiled = $UPSFiled;
  }

  /**
   *
   * @return ShipperFiledType
   */
  public function getShipperFiled()
  {
    return $this->ShipperFiled;
  }

  /**
   *
   * @param ShipperFiledType $ShipperFiled
   */
  public function setShipperFiled($ShipperFiled)
  {
    $this->ShipperFiled = $ShipperFiled;
  }

}
