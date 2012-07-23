<?php
namespace SparkLib;
use InvalidArgumentException;

abstract class Iterator implements \Iterator {

  protected $_useCache = false;

  /**
   * Require that children of this class implement a getNext()
   */
  abstract public function getNext ();

  /**
   * Should child classes attempt to use cached return values?
   *
   * It's up to a child to decide what, if anything, this means.
   */
  public function useCache ($value = true)
  {
    $this->_useCache = $value;
    return $this;
  }

  /**
   * Calls $function() on each remaining element in the iterator.
   *
   * @param callback $function
   * @return SparkFriendFinder the finder
   */
  public function each ($function)
  {
    if (! \is_callable($function) )
      throw new InvalidArgumentException('each(): parameter is not a callback');

    // handle first/current result
    $rec = $this->getNext();
    if (! $rec)
      return $this;
    call_user_func($function, $rec);

    // handle the rest, if any
    while ($this->valid()) {
      $rec = $this->getNext();
      if ($rec) {
        call_user_func($function, $rec);
      }
    }

    return $this;
  }

  /**
   * Map iterator results to an array, using a callback function.
   *
   * @param callback $function
   * @return array $results
   */
  public function map ($function)
  {
    if (! \is_callable($function))
      throw new InvalidArgumentException('map(): parameter is not a callback.');

    $results = array();

    // handle first/current result
    $rec = $this->getNext();
    if (! $rec)
      return $results;
    $results[] = call_user_func($function, $rec);

    // handle the rest, if any
    while ($this->valid()) {
      $rec = $this->getNext();
      if ($rec) {
        $results[] = call_user_func($function, $rec);
      }
    }

    return $results;
  }

}
