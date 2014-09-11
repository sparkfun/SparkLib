<?php
namespace SparkLib;
use \SparkLib\Renderable;

/**
 * Sparkdown macro base class.
 *
 */
class SparkdownMacro implements Renderable {

  protected $_input;
  protected $_context = [];

  public function __construct ($input)
  {
    $this->_input = $input;
  }

  /**
   * Takes things that should be available when the macro is rendered,
   * for passing into templates or whatever.
   *
   * @return SparkdownMacro
   */
  public function setContext (array $context)
  {
    $this->_context = $context;
    return $this;
  }

  /**
   * Get the current context array.
   *
   * @return array
   */
  public function getContext ()
  {
    return $this->_context;
  }

  public function render ()
  {
    return '<p>' . $this->_input . '</p>';
  }

}
