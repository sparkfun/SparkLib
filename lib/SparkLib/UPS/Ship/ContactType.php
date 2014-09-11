<?php

namespace SparkLib\UPS\Ship;

class ContactType
{

  /**
   * 
   * @var ForwardAgentType $ForwardAgent
   * @access public
   */
  public $ForwardAgent = null;

  /**
   * 
   * @var UltimateConsigneeType $UltimateConsignee
   * @access public
   */
  public $UltimateConsignee = null;

  /**
   * 
   * @var IntermediateConsigneeType $IntermediateConsignee
   * @access public
   */
  public $IntermediateConsignee = null;

  /**
   * 
   * @var ProducerType $Producer
   * @access public
   */
  public $Producer = null;

  /**
   * 
   * @var SoldToType $SoldTo
   * @access public
   */
  public $SoldTo = null;

  /**
   * 
   * @param ForwardAgentType $ForwardAgent
   * @param UltimateConsigneeType $UltimateConsignee
   * @param IntermediateConsigneeType $IntermediateConsignee
   * @param ProducerType $Producer
   * @param SoldToType $SoldTo
   * @access public
   */
  public function __construct($ForwardAgent = null, $UltimateConsignee = null, $IntermediateConsignee = null, $Producer = null, $SoldTo = null)
  {
    $this->ForwardAgent = $ForwardAgent;
    $this->UltimateConsignee = $UltimateConsignee;
    $this->IntermediateConsignee = $IntermediateConsignee;
    $this->Producer = $Producer;
    $this->SoldTo = $SoldTo;
  }

  /**
   * 
   * @return ForwardAgentType
   */
  public function getForwardAgent()
  {
    return $this->ForwardAgent;
  }

  /**
   * 
   * @param ForwardAgentType $ForwardAgent
   */
  public function setForwardAgent($ForwardAgent)
  {
    $this->ForwardAgent = $ForwardAgent;
  }

  /**
   * 
   * @return UltimateConsigneeType
   */
  public function getUltimateConsignee()
  {
    return $this->UltimateConsignee;
  }

  /**
   * 
   * @param UltimateConsigneeType $UltimateConsignee
   */
  public function setUltimateConsignee($UltimateConsignee)
  {
    $this->UltimateConsignee = $UltimateConsignee;
  }

  /**
   * 
   * @return IntermediateConsigneeType
   */
  public function getIntermediateConsignee()
  {
    return $this->IntermediateConsignee;
  }

  /**
   * 
   * @param IntermediateConsigneeType $IntermediateConsignee
   */
  public function setIntermediateConsignee($IntermediateConsignee)
  {
    $this->IntermediateConsignee = $IntermediateConsignee;
  }

  /**
   * 
   * @return ProducerType
   */
  public function getProducer()
  {
    return $this->Producer;
  }

  /**
   * 
   * @param ProducerType $Producer
   */
  public function setProducer($Producer)
  {
    $this->Producer = $Producer;
  }

  /**
   * 
   * @return SoldToType
   */
  public function getSoldTo()
  {
    return $this->SoldTo;
  }

  /**
   * 
   * @param SoldToType $SoldTo
   */
  public function setSoldTo($SoldTo)
  {
    $this->SoldTo = $SoldTo;
  }

}
