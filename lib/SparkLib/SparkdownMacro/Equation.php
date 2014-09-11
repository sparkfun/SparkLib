<?php
namespace SparkLib\SparkdownMacro;
use \SparkLib\Renderable;
use \FeaturedContentSaurus;

/**
 * Render equations.
 */
class FeaturedContent implements Renderable {

  protected $_input;

  public function __construct ($input)
  {
    $this->_input = $input;
    $this->_fc = FeaturedContentSaurus::getById($input);
  }

  public function render ()
  {
    return '<p>' . '</p>';
  }

}
