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
    // We might have a tablename.columnname instead of columnname
    if (false !== strpos($this->_field, '.')) {
      list($table, $column) = explode('.', $this->_field);
      return '"' . $table . '"."' . $column . '"';
    }

    return '"' . $this->_field . '"';
  }

}
