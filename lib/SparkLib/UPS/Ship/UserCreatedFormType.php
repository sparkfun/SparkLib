<?php

namespace SparkLib\UPS\Ship;

class UserCreatedFormType
{

  /**
   * 
   * @var string $DocumentID
   * @access public
   */
  public $DocumentID = null;

  /**
   * 
   * @param string $DocumentID
   * @access public
   */
  public function __construct($DocumentID = null)
  {
    $this->DocumentID = $DocumentID;
  }

  /**
   * 
   * @return string
   */
  public function getDocumentID()
  {
    return $this->DocumentID;
  }

  /**
   * 
   * @param string $DocumentID
   */
  public function setDocumentID($DocumentID)
  {
    $this->DocumentID = $DocumentID;
  }

}
