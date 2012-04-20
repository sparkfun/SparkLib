<?php
namespace SparkLib\Iterator;

class Wrapper extends \SparkLib\Iterator {

  protected $_iterator;
  protected $_wrapperClass;

  public function __construct (\Iterator $iterator, $wrapper_class = '\stdClass')
  {
    $this->_iterator = $iterator;
    $this->_wrapperClass = $wrapper_class;
  }

  public function current ()
  {
    return $this->makeInstance($this->_iterator->current());
  }

  // not sure this belongs here, but...
  public function getNext ()
  {
    return $this->makeInstance($this->_iterator->getNext());
  }

  protected function makeInstance ($result)
  {
    $wclass = $this->_wrapperClass;
    return new $wclass($result);
  }

  public function key    () { return $this->_iterator->key();    }
  public function next   () { return $this->_iterator->next();   }
  public function rewind () { return $this->_iterator->rewind(); }
  public function valid  () { return $this->_iterator->valid();  }

  public function __call ($name, $arguments)
  {
    return call_user_func_array(array($this->_iterator, $name), $arguments);
  }

}
