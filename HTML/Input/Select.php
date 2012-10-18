<?php
namespace SparkLib\HTML\Input;
use \SparkLib\HTML;
use \SparkLib\Iterator;

class Select extends \SparkLib\HTML\Input {

  protected $_options;
  protected $_output;
  protected $_value;
  protected $_title;

  public function __construct ()
  {
  }

  public function options ($options)
  {
    $this->_options = $options;
    return $this;
  }

  public function value ($value)
  {
    $this->_value = $value;
    return $this;
  }

  public function title ($title)
  {
    $this->_title = $title;
    return $this;
  }

  public function render ()
  {
    if (! isset($this->_output)) {
     $this->_output = implode('', $this->_options->map(function ($thing) { return $thing->parts_tier_name; }));
    }
    return $this->_output;
  } 
}
