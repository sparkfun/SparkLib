<?php
namespace SparkLib;

use \MongoDBI as Mongo;
use \SparkLib\Iterator;

/**
 * Class that creates a nice interface for accessing Mongo
 */
class MongoFinder extends Iterator {

  protected $_mongo;
  protected $_mongoCursor;
  protected $_collection;
  protected $_class;
  protected $_query;
  protected $_where = [];
  protected $_sort = [];
  protected $_row;
  protected $_whereWaiting = false;
  protected $_sortWaiting = false;
  protected $_paramsChanged = false;
  protected $_resultCount;

  /**
   * Create new instance and store the collection name to be used in find()
   *
   * @param string $collection - mongo collection in which search happens
   * @param string $class - class in which to wrap mongo instance
   *
   * @return MongoFinder
   */
  public function __construct($collection, $class) {
    $this->_mongo = Mongo::getInstance();
    $this->_collection = $collection;
    $this->_class = $class;
    return $this;
  }

  /**
   * checks to see if you called either sortBy('something') or where('something')
   * without calling asc()/desc() or eq()/is() respectively
   *
   * @return void
   */
  protected function _checkWaiting() {
    if ($this->_whereWaiting !== false)
      throw new \Exception('Mongo WHERE waiting completion');

    if ($this->_sortWaiting !== false)
      throw new \Exception('Mongo SORT waiting completion');
  }

  /**
   * adds parameter to where array that will be used in find()
   *
   * @param string $key - the key in the mongodb for which you want to search
   *
   * @return MongoFinder
   */
  public function where($key) {
    $this->_checkWaiting();

    $this->_where[$key] = true;
    $this->_whereWaiting = $key;
    $this->_paramsChanged = true;
    return $this;
  }

  /**
   * adds parameter to where array that will be used in find()
   *
   * @param mixed $value - the value of the $key previously set in where()
   * @param string $comparison (optional) comparison to make between $key and $value
   *
   * @return MongoFinder
   */
  public function is($value, $comparison = false) {
    if (! $this->_where[$this->_whereWaiting])
      throw new \Exception('Mongo WHERE not called');

    if (! $comparison) {
      $comparison = '=';
    }

    switch($comparison) {
      case '=':
        $this->_where[$this->_whereWaiting] = $value;
        break;
      case '>':
        $this->_where[$this->_whereWaiting] = [ '$gt' => $value ];
        break;
      case '>=':
        $this->_where[$this->_whereWaiting] = [ '$gte' => $value ];
        break;
      case '<':
        $this->_where[$this->_whereWaiting] = [ '$lt' => $value ];
        break;
      case '<=':
        $this->_where[$this->_whereWaiting] = [ '$lte' => $value ];
        break;
      case 'in':
        $this->_where[$this->_whereWaiting] = [ '$in' => $value ];
        break;        
    }
    $this->_paramsChanged = true;
    $this->_whereWaiting = false;

    return $this;
  }

  /**
   * adds parameter to where array that will be used in find()
   *
   * @param string $regex - the regex to match the against $key previously set in where()
   * @param string $flags - optional, regex search flags
   *
   * @return MongoFinder
   */
  public function isLike($regex, $flags = '') {
    if (! $this->_where[$this->_whereWaiting])
      throw new \Exception('Mongo WHERE not called');

    $this->_where[$this->_whereWaiting] = [ '$regex' => "$regex", '$options' => "$flags" ];

    $this->_paramsChanged = true;
    $this->_whereWaiting = false;

    return $this;
  }


  /**
   * adds parameter to where array that will be used in find() use for values
   * you DO NOT want to be true
   *
   * example: 
   *   where('cat_attitude')->not('angry'); // cat_attitude != angry
   *   where('cat_weight')->not(20, '>'); // ! cat_weight > 20
   *
   * @param mixed $value - the value of the $key previously set in where()
   * @param string $comparison (optional) comparison to make between $key and $value
   *
   * @return MongoFinder
   */
  public function isNot($value, $comparison = false) {
    if (! $this->_where[$this->_whereWaiting])
      throw new \Exception('Mongo WHERE not called');

    if(! $comparison) {
      $comparison = '=';
    }

    switch($comparison) {
      case '=':
        if (is_array($value))
          $this->_where[$this->_whereWaiting] = [ '$not' =>  $value ];
        else
          $this->_where[$this->_whereWaiting] = [ '$not' =>  new MongoRegex('/^' . $value . '$/') ];
        break;
      case '>':
        $this->_where[$this->_whereWaiting] = [ '$not' =>  [ '$gt' => $value ] ];
        break;
      case '>=':
        $this->_where[$this->_whereWaiting] = [ '$not' =>  [ '$gte' => $value ] ];
        break;
      case '<':
        $this->_where[$this->_whereWaiting] = [ '$not' =>  [ '$lt' => $value ] ];
        break;
      case '<=':
        $this->_where[$this->_whereWaiting] = [ '$not' =>  [ '$lte' => $value ] ];
        break;
    }
    $this->_paramsChanged = true;
    $this->_whereWaiting = false;

    return $this;
  }

  /**
   * alias for is($value, '=')
   *
   * @param mixed $value value you're checking against $key set in where()
   *
   * @return MongoFinder
   */
  public function eq($value) {
    $this->_paramsChanged = true;
    return $this->is($value, '=');
  }

  /**
   * alias for is($value, 'in')
   *
   * @param mixed $value value you're checking against $key set in where()
   *
   * @return MongoFinder
   */
  public function in($value) {
    if(! is_array($value))
      return $this;

    $this->_paramsChanged = true;
    return $this->is($value, 'in');
  }
  
  /**
   * alias for is($value, [ '$exists' => false ])
   *
   * @return MongoFinder
   */
  public function isNull() {
    $this->_paramsChanged = true;
    return $this->is([ '$exists' => false ], '=');
  }

  /**
   * alias for is($value, [ '$exists' => true ])
   *
   * @return MongoFinder
   */
  public function isNotNull() {
    $this->_paramsChanged = true;
    return $this->is([ '$exists' => true ], '=');
  }

  /**
   * how to sort results of search
   *
   * @param mixed $order - if it's an array format: [ $sortKey => 1 ] if it
   *                       is a string then format: sortkey
   *
   * @return MongoFinder
   */
  public function orderBy($order) {
    $this->_checkWaiting();

    if (is_array($order)) {
      foreach($order as $k => $v) {
        switch($v) {
            case 1:
            case -1:
              $this->_sort[$k] = $v;
              break;
            case 'ASC':
            case 'asc':
              $this->_sort[$k] = -1;
              break;
            case 'DESC':
            case 'desc':
              $this->_sort[$k] = 1;
              break;
        }
      }
    } else {
      $this->_sort[$order] = true;
      $this->_sortWaiting = $order;
    }

    $this->_paramsChanged = true;
    return $this;
  }

  /**
   * sort by asc, should be proceeded with a call to sort()
   *
   * @return MongoFinder
   */
  public function asc() {
    if (! $this->_sort[$this->_sortWaiting])
      throw new \Exception('Mongo SORT not called');

    $this->_sort[$this->_sortWaiting] = -1;

    $this->_sortWaiting = false;
    $this->_paramsChanged = true;
    return $this;
  }

  /**
   * sort by desc, should be proceeded with a call to sort()
   *
   * @return MongoFinder
   */
  public function desc() {
    if (! $this->_sort[$this->_sortWaiting])
      throw new \Exception('Mongo SORT not called');

    $this->_sort[$this->_sortWaiting] = 1;

    $this->_sortWaiting = false;
    $this->_paramsChanged = true;
    return $this;
  }

  /**
   * Moves internal pointer forward once
   *
   * @return MongoFinder
   */
  public function next() {
    $this->_checkWaiting();

    if (! isset($this->_mongoCursor) || $this->_paramsChanged)
      $this->find();

    $this->_mongoCursor->next();

    return $this;
  }

  /**
   * Moves internal pointer forward by $int
   *
   * @param int $int - number of times to skip the internal pointer
   *
   * @return MongoFinder
   */
  public function skip($int) {
    $this->_checkWaiting();

    if (! isset($this->_mongoCursor) || $this->_paramsChanged)
      $this->find();

    $this->_mongoCursor->skip($int);

    return $this;
  }

  /**
   * Moves internal pointer to beginning
   *
   * @return MongoFinder
   */
  public function rewind() {
    $this->_checkWaiting();

    if (! isset($this->_mongoCursor) || $this->_paramsChanged)
      $this->find();

    $this->_mongoCursor->rewind();
    return $this;
  }

  /**
   * alias for getNext
   *
   * @return \Spark\$collection-wrapped Mongo thing
   */
  public function getOne() {
    return $this->getNext();
  }

  /**
   * Returns the current result and iterates the pointer
   *
   * @return \Spark\$collection-wrapped mongo-thing
   */
  public function getNext () {
    $this->_checkWaiting();

    if (! isset($this->_mongoCursor) || $this->_paramsChanged)
      $this->find();

    $result = $this->current();

    if (false !== $result)
      $this->next();

    return $result;
  }

  /**
   * Returns the current result at pointer
   *
   * @return \Spark\$collection-wrapped mongo-thing
   */
  public function current() {
    $this->_checkWaiting();

    if (! isset($this->_mongoCursor) || $this->_paramsChanged)
      $this->find();

    if (! $this->_mongoCursor->current())
      return false;

    return new $this->_class($this->_mongoCursor->current());
  }

  /**
   * get a count of the result ste
   *
   * @return int
   */
  public function count() {
    if (! isset($this->_mongoCursor) || $this->_paramsChanged) {
      $this->find();
      $this->_resultCount = null;
    }

    if (! isset($this->_resultCount))
      $this->_resultCount = $this->_mongoCursor->count();

    return $this->_resultCount;
  }

  /**
   * Actually does the search on mongo and iterates the pointer so it's on a result
   *
   * @return MongoFinder
   */
  public function find() {
    $this->_checkWaiting();

    $collection = $this->_collection;

    $this->_mongoCursor = $this->_mongo->$collection->find($this->_where)->sort($this->_sort);
    $this->_mongoCursor->next();

    // Reset params so no new find runs
    $this->_paramsChanged = false;

    return $this;
  }

  /**
   * Resets all query info
   */
  public function reset() {
    $this->_where = [];
    $this->_sort = [];
    $this->_whereWaiting = false;
    $this->_sortWaiting = false;
    $this->_paramsChanged = false;
    $this->_resultCount = null;
    $this->_row = null;
    $this->_query = null;
    $this->_mongoCursor = null;
  }

  /**
   * Dumps mongo query as string
   *
   * @return string
   */
  public function getQuery() {
    return 'db.' . $this->_collection . '.find(' . json_encode($this->_where) . ').sort(' . json_encode($this->_sort) . ').pretty()';
  }

  /**
   * Makes sure the current result is an instance of the class passed in
   *
   * @return boolean
   */
  public function valid () {
    return $this->_mongoCursor->current() instanceof $this->_class;
  }

  /**
   * Returns the mongo id of the mongo entity currently under the pointer
   *
   * @return string
   */
  public function key () { 
    if (! isset($this->_mongoCursor) || $this->_paramsChanged)
      $this->find();

    return (string) $this->current()->id();
  }
}
