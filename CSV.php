<?php
namespace SparkLib;

use \Exception;

/**
 * CSV - A simple tool to generate a CSV string, ideally
 * to be sent back to users as text/csv
 *
 * This probably exists in thousands of PEAR modules and equally
 * many other places. But really, it's only a few lines of code.
 *
 * This is cheesy and probably fails in common cases, but so far
 * it has worked well enough for our purposes.
 */
class CSV {

  private $_data   = array();
  private $_header = array();

  /**
   * Add named header fields to the top of the file.
   */
  public function addHeader (array $header)
  {
    if (! is_array($header))
      throw new Exception('SparkLib\CSV expects an array as a header');

    $this->_header = $header;
  }

  /**
   * Add a row of data.
   */
  public function addRow (array $row)
  {
    $this->_data[] = $row;
  }

  /**
   * Spit out a string containing the entire CSV.
   */
  public function render()
  {
    $ret = '';

    if(!empty($this->_header)) {
      foreach($this->_header as $field) {
        $ret .= '"' . str_replace('"', '""', addslashes($field)) . '",';
      }
      $ret[strlen($ret) - 1] = "\n";
    }

    foreach($this->_data as $row) {
      foreach($row as $field) {
        $ret .= '"' . str_replace('"', '""', addslashes($field)) . '",';
      }
      $ret[strlen($ret) - 1] = "\n";
    }
    return $ret;
  }

}
