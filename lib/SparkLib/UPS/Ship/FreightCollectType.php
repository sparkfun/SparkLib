<?php

namespace SparkLib\UPS\Ship;

class FreightCollectType
{

  /**
   * 
   * @var BillReceiverType $BillReceiver
   * @access public
   */
  public $BillReceiver = null;

  /**
   * 
   * @param BillReceiverType $BillReceiver
   * @access public
   */
  public function __construct($BillReceiver = null)
  {
    $this->BillReceiver = $BillReceiver;
  }

  /**
   * 
   * @return BillReceiverType
   */
  public function getBillReceiver()
  {
    return $this->BillReceiver;
  }

  /**
   * 
   * @param BillReceiverType $BillReceiver
   */
  public function setBillReceiver($BillReceiver)
  {
    $this->BillReceiver = $BillReceiver;
  }

}
