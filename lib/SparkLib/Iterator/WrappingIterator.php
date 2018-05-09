<?php
namespace SparkLib\Iterator;

/**
 * This works kinda like SparkLib\Iterator\Wrapper did but extends IteratorIterator
 * to work with the new MongoDB cursor as the underlying Traversable.
 * 
 * Might be worth considering a CachingIterator implementation in the future
 **/


class WrappingIterator extends \IteratorIterator {

  protected $_wrapperClass;

  public function __construct(\Traversable $t, $wrapperClass = '\stdClass')
  {
    $this->_wrapperClass = $wrapperClass;
    parent::__construct($t);
    // The new new MongoDB cursor doesn't play nicely until it's rewound, but don't even think about rewinding it again!!!
    parent::rewind();
  }

  public function current ()
  {
    if (parent::valid()) {
      return new $this->_wrapperClass(parent::current());
    }
    else {
      return null;
    }
  }

/**
 * Implement the SFE convention for getNext() to work with SparkListView
 **/
  public function getNext ()
  {
    if (parent::valid()) {
      $result = parent::current();
      parent::next();
      return new $this->_wrapperClass($result);
    }
    else {
      return null;
    }
  }

}
