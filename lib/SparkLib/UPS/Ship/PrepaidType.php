<?php

namespace SparkLib\UPS\Ship;

class PrepaidType
{

  /**
   * 
   * @var BillShipperType $BillShipper
   * @access public
   */
  public $BillShipper = null;

  /**
   * 
   * @param BillShipperType $BillShipper
   * @access public
   */
  public function __construct($BillShipper = null)
  {
    $this->BillShipper = $BillShipper;
  }

  /**
   * 
   * @return BillShipperType
   */
  public function getBillShipper()
  {
    return $this->BillShipper;
  }

  /**
   * 
   * @param BillShipperType $BillShipper
   */
  public function setBillShipper($BillShipper)
  {
    $this->BillShipper = $BillShipper;
  }

}
