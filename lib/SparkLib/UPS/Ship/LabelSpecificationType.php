<?php

namespace SparkLib\UPS\Ship;

class LabelSpecificationType
{

  /**
   * 
   * @var LabelImageFormatType $LabelImageFormat
   * @access public
   */
  public $LabelImageFormat = null;

  /**
   * 
   * @var string $HTTPUserAgent
   * @access public
   */
  public $HTTPUserAgent = null;

  /**
   * 
   * @var LabelStockSizeType $LabelStockSize
   * @access public
   */
  public $LabelStockSize = null;

  /**
   * 
   * @var InstructionCodeDescriptionType $Instruction
   * @access public
   */
  public $Instruction = null;

  /**
   * 
   * @param LabelImageFormatType $LabelImageFormat
   * @param string $HTTPUserAgent
   * @param LabelStockSizeType $LabelStockSize
   * @param InstructionCodeDescriptionType $Instruction
   * @access public
   */
  public function __construct($LabelImageFormat = null, $HTTPUserAgent = null, $LabelStockSize = null, $Instruction = null)
  {
    $this->LabelImageFormat = $LabelImageFormat;
    $this->HTTPUserAgent = $HTTPUserAgent;
    $this->LabelStockSize = $LabelStockSize;
    $this->Instruction = $Instruction;
  }

  /**
   * 
   * @return LabelImageFormatType
   */
  public function getLabelImageFormat()
  {
    return $this->LabelImageFormat;
  }

  /**
   * 
   * @param LabelImageFormatType $LabelImageFormat
   */
  public function setLabelImageFormat($LabelImageFormat)
  {
    $this->LabelImageFormat = $LabelImageFormat;
  }

  /**
   * 
   * @return string
   */
  public function getHTTPUserAgent()
  {
    return $this->HTTPUserAgent;
  }

  /**
   * 
   * @param string $HTTPUserAgent
   */
  public function setHTTPUserAgent($HTTPUserAgent)
  {
    $this->HTTPUserAgent = $HTTPUserAgent;
  }

  /**
   * 
   * @return LabelStockSizeType
   */
  public function getLabelStockSize()
  {
    return $this->LabelStockSize;
  }

  /**
   * 
   * @param LabelStockSizeType $LabelStockSize
   */
  public function setLabelStockSize($LabelStockSize)
  {
    $this->LabelStockSize = $LabelStockSize;
  }

  /**
   * 
   * @return InstructionCodeDescriptionType
   */
  public function getInstruction()
  {
    return $this->Instruction;
  }

  /**
   * 
   * @param InstructionCodeDescriptionType $Instruction
   */
  public function setInstruction($Instruction)
  {
    $this->Instruction = $Instruction;
  }

}
