<?php

namespace SparkLib\UPS\Ship;

class AlternateDeliveryAddressType
{

  /**
   * 
   * @var string $Name
   * @access public
   */
  public $Name = null;

  /**
   * 
   * @var string $AttentionName
   * @access public
   */
  public $AttentionName = null;

  /**
   * 
   * @var string $UPSAccessPointID
   * @access public
   */
  public $UPSAccessPointID = null;

  /**
   * 
   * @var ADLAddressType $Address
   * @access public
   */
  public $Address = null;

  /**
   * 
   * @param string $Name
   * @param string $AttentionName
   * @param string $UPSAccessPointID
   * @param ADLAddressType $Address
   * @access public
   */
  public function __construct($Name = null, $AttentionName = null, $UPSAccessPointID = null, $Address = null)
  {
    $this->Name = $Name;
    $this->AttentionName = $AttentionName;
    $this->UPSAccessPointID = $UPSAccessPointID;
    $this->Address = $Address;
  }

  /**
   * 
   * @return string
   */
  public function getName()
  {
    return $this->Name;
  }

  /**
   * 
   * @param string $Name
   */
  public function setName($Name)
  {
    $this->Name = $Name;
  }

  /**
   * 
   * @return string
   */
  public function getAttentionName()
  {
    return $this->AttentionName;
  }

  /**
   * 
   * @param string $AttentionName
   */
  public function setAttentionName($AttentionName)
  {
    $this->AttentionName = $AttentionName;
  }

  /**
   * 
   * @return string
   */
  public function getUPSAccessPointID()
  {
    return $this->UPSAccessPointID;
  }

  /**
   * 
   * @param string $UPSAccessPointID
   */
  public function setUPSAccessPointID($UPSAccessPointID)
  {
    $this->UPSAccessPointID = $UPSAccessPointID;
  }

  /**
   * 
   * @return ADLAddressType
   */
  public function getAddress()
  {
    return $this->Address;
  }

  /**
   * 
   * @param ADLAddressType $Address
   */
  public function setAddress($Address)
  {
    $this->Address = $Address;
  }

}
