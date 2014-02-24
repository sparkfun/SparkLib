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

  public function iterator ()
  {
    return $this->_iterator;
  }

  public function current ()
  {
    if ($this->_iterator->valid()) {
      return $this->makeInstance($this->_iterator->current());
    } else {
      return $this->_iterator->current();
    }
  }

  public function getNext ()
  {
    $result = $this->_iterator->getNext();
    if ($result)
      return $this->makeInstance($result);
    else
      return $result;
  }

  protected function makeInstance ($result)
  {
    $wclass = $this->_wrapperClass;
    return new $wclass($result);
  }

  /**
   * Pass method calls through to the underlying iterator.
   */
  public function __call ($name, $arguments)
  {
    return call_user_func_array(array($this->_iterator, $name), $arguments);
  }

  /**
   * These could be handled by __call(), except we're implementing
   * the SPL Iterator interface, and it expects them to be defined.
   */
  public function key    () { return $this->_iterator->key();    }
  public function next   () { return $this->_iterator->next();   }
  public function rewind () { return $this->_iterator->rewind(); }
  public function valid  () { return $this->_iterator->valid();  }

}
