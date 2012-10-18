<?php
namespace SparkLib\HTML;

abstract class Input {

  protected $_html;

  public static function make ()
  {
    $class = get_called_class();
    return new $class;
  }

  public function __toString ()
  {
    return $this->render();
  }

  abstract public function render();

}
