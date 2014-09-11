<?php

namespace SparkLib\UPS\Ship;

class FormType
{

  /**
   * 
   * @var string $Code
   * @access public
   */
  public $Code = null;

  /**
   * 
   * @var string $Description
   * @access public
   */
  public $Description = null;

  /**
   * 
   * @var FormImageType $Image
   * @access public
   */
  public $Image = null;

  /**
   * 
   * @var string $FormGroupId
   * @access public
   */
  public $FormGroupId = null;

  /**
   * 
   * @var string $FormGroupIdName
   * @access public
   */
  public $FormGroupIdName = null;

  /**
   * 
   * @param string $Code
   * @param string $Description
   * @param FormImageType $Image
   * @param string $FormGroupId
   * @param string $FormGroupIdName
   * @access public
   */
  public function __construct($Code = null, $Description = null, $Image = null, $FormGroupId = null, $FormGroupIdName = null)
  {
    $this->Code = $Code;
    $this->Description = $Description;
    $this->Image = $Image;
    $this->FormGroupId = $FormGroupId;
    $this->FormGroupIdName = $FormGroupIdName;
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
   * @return FormImageType
   */
  public function getImage()
  {
    return $this->Image;
  }

  /**
   * 
   * @param FormImageType $Image
   */
  public function setImage($Image)
  {
    $this->Image = $Image;
  }

  /**
   * 
   * @return string
   */
  public function getFormGroupId()
  {
    return $this->FormGroupId;
  }

  /**
   * 
   * @param string $FormGroupId
   */
  public function setFormGroupId($FormGroupId)
  {
    $this->FormGroupId = $FormGroupId;
  }

  /**
   * 
   * @return string
   */
  public function getFormGroupIdName()
  {
    return $this->FormGroupIdName;
  }

  /**
   * 
   * @param string $FormGroupIdName
   */
  public function setFormGroupIdName($FormGroupIdName)
  {
    $this->FormGroupIdName = $FormGroupIdName;
  }

}
