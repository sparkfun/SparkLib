<?php
namespace SparkLib\DB;

class Field implements Literal {

  protected $_field = null;

  public function __construct ($field)
  {
    $this->_field = $field;
  }

  // You'll shoot your eye out!
  public function literal ()
  {
    return '"' . $this->_field . '"';
  }

}
