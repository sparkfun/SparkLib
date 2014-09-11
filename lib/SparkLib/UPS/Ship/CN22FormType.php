<?php

namespace SparkLib\UPS\Ship;

class CN22FormType
{

  /**
   * 
   * @var string $LabelSize
   * @access public
   */
  public $LabelSize = null;

  /**
   * 
   * @var string $PrintsPerPage
   * @access public
   */
  public $PrintsPerPage = null;

  /**
   * 
   * @var string $LabelPrintType
   * @access public
   */
  public $LabelPrintType = null;

  /**
   * 
   * @var string $CN22Type
   * @access public
   */
  public $CN22Type = null;

  /**
   * 
   * @var string $CN22OtherDescription
   * @access public
   */
  public $CN22OtherDescription = null;

  /**
   * 
   * @var string $FoldHereText
   * @access public
   */
  public $FoldHereText = null;

  /**
   * 
   * @var CN22ContentType $CN22Content
   * @access public
   */
  public $CN22Content = null;

  /**
   * 
   * @param string $LabelSize
   * @param string $PrintsPerPage
   * @param string $LabelPrintType
   * @param string $CN22Type
   * @param string $CN22OtherDescription
   * @param string $FoldHereText
   * @param CN22ContentType $CN22Content
   * @access public
   */
  public function __construct($LabelSize = null, $PrintsPerPage = null, $LabelPrintType = null, $CN22Type = null, $CN22OtherDescription = null, $FoldHereText = null, $CN22Content = null)
  {
    $this->LabelSize = $LabelSize;
    $this->PrintsPerPage = $PrintsPerPage;
    $this->LabelPrintType = $LabelPrintType;
    $this->CN22Type = $CN22Type;
    $this->CN22OtherDescription = $CN22OtherDescription;
    $this->FoldHereText = $FoldHereText;
    $this->CN22Content = $CN22Content;
  }

  /**
   * 
   * @return string
   */
  public function getLabelSize()
  {
    return $this->LabelSize;
  }

  /**
   * 
   * @param string $LabelSize
   */
  public function setLabelSize($LabelSize)
  {
    $this->LabelSize = $LabelSize;
  }

  /**
   * 
   * @return string
   */
  public function getPrintsPerPage()
  {
    return $this->PrintsPerPage;
  }

  /**
   * 
   * @param string $PrintsPerPage
   */
  public function setPrintsPerPage($PrintsPerPage)
  {
    $this->PrintsPerPage = $PrintsPerPage;
  }

  /**
   * 
   * @return string
   */
  public function getLabelPrintType()
  {
    return $this->LabelPrintType;
  }

  /**
   * 
   * @param string $LabelPrintType
   */
  public function setLabelPrintType($LabelPrintType)
  {
    $this->LabelPrintType = $LabelPrintType;
  }

  /**
   * 
   * @return string
   */
  public function getCN22Type()
  {
    return $this->CN22Type;
  }

  /**
   * 
   * @param string $CN22Type
   */
  public function setCN22Type($CN22Type)
  {
    $this->CN22Type = $CN22Type;
  }

  /**
   * 
   * @return string
   */
  public function getCN22OtherDescription()
  {
    return $this->CN22OtherDescription;
  }

  /**
   * 
   * @param string $CN22OtherDescription
   */
  public function setCN22OtherDescription($CN22OtherDescription)
  {
    $this->CN22OtherDescription = $CN22OtherDescription;
  }

  /**
   * 
   * @return string
   */
  public function getFoldHereText()
  {
    return $this->FoldHereText;
  }

  /**
   * 
   * @param string $FoldHereText
   */
  public function setFoldHereText($FoldHereText)
  {
    $this->FoldHereText = $FoldHereText;
  }

  /**
   * 
   * @return CN22ContentType
   */
  public function getCN22Content()
  {
    return $this->CN22Content;
  }

  /**
   * 
   * @param CN22ContentType $CN22Content
   */
  public function setCN22Content($CN22Content)
  {
    $this->CN22Content = $CN22Content;
  }

}
