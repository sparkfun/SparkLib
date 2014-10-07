<?php
use \SparkLib\DB;

/**
 * SparkFinder
 *
 * A simple iterator to query the database and return SparkRecord objects
 * based on the results.
 *
 * Get one like so:
 *
 *   $things = new SparkFinder('RecordClass', 'SELECT * FROM record_table');
 *
 * You may then do
 *
 *   while ($record_instance = $things->getNext()) {
 *     // Do something with $record_instance
 *   }
 *
 * which will (in general) safely run until results are exhausted, or iterate
 * over the results using foreach(), like so:
 *
 *   foreach ($things as $id => $record_instance) {
 *     // Do something with $record_instance
 *   }
 *
 * ...but don't do that, since foreach() is quite likely to eat all of your
 * available memory if you have very many results, as it will try to build
 * the entire array before it ever starts iterating. If you find a way around
 * this, I'd love to hear about it.
 */
class SparkFinder extends \SparkLib\Iterator {

  protected $_recordClass;
  protected $_table     = null;
  protected $_tableKey  = null;
  protected $_params    = null;
  protected $_resultSet = null;
  protected $_query;

  // We'll track the iterator's position and store results with these:
  protected $_position = 0;
  protected $_row      = null;

  /**
   * Get a new finder. Takes a string containing the class of dinosaur
   * to instantiate, and a query to find the dinosaurs with. Optionally
   * takes an array of parameters for bound queries.
   */
  public function __construct ($record_class, $querystring = null, $params = null)
  {
    $this->_recordClass = $record_class;

    /* Careful here - this will usually do the right thing, but class_exists()
       invokes the autoloader, which is sometimes dumb enough to go after a
       file that doesn't exist: */

    if (! class_exists($this->_recordClass))
      throw new InvalidArgumentException("No such record class: {$this->_recordClass}");

    // Pull in some metadata from the record class:
    $this->handleClass();

    // Try for a sane default query, if we know about a table
    // (we might not know about a table if we're dealing with
    // something other than a child of SparkRecord, like a SparkRecordGeneric.
    if (is_null($querystring) && (! is_null($this->_table)))
      $querystring = 'SELECT * FROM ' . $this->_table;

    $this->_query = $querystring;

    if (is_array($params))
      $this->_params = $params;

    $this->doQuery();
  }

  /**
   * Start over with a fresh run of the query.  Here for compatibility with the
   * Iterator interface, and works, but if you're actually using it much there's
   * a better-than-even chance you need to rethink your code.
   */
  public function rewind ()
  {
    // Reset, if we need to:
    if ($this->_position !== 0) {
      $this->_position = 0;
      $this->doQuery();
    }
  }

  public function key ()         { return $this->_row[$this->_tableKey]; }
  public function recordClass () { return $this->_recordClass; }
  public function tableKey ()    { return $this->_tableKey; }
  public function valid ()       { return is_array($this->_row); }
  public function position()     { return $this->_position; }

  /**
   * How many rows in the current statement results?
   */
  public function count ()
  {
    if (! $this->_resultSet)
      return false;

    return $this->_resultSet->rowCount();
  }

  /**
   * Advance to the next record.
   */
  public function next ()
  {
    if (! isset($this->_resultSet))
      throw new Exception('No current results - something bad happened here.');

    ++$this->_position;

    // Use the next thing from the resultset:
    if ($row = $this->_resultSet->fetch(\PDO::FETCH_ASSOC))
      $this->_row = $row;
    else
      $this->_row = null;
  }

  /**
   * Return an object for the current record.
   */
  public function current ()
  {
    // Do we have a record array? Return false if not.
    if (! $this->valid())
      return false;

    // We've got a record array; make it into a dinosaur.
    $class = $this->_recordClass;
    return new $class($this->_row);
  }

  /**
   * Load the next record and return an object for it.
   */
  public function getNext ()
  {
    // Will be a record object or false;
    $result = $this->current();

    // If we got an object, we'll advance to the next record.
    if (false !== $result)
      $this->next();

    return $result;
  }

  /**
   * @return string current query
   */
  public function getQuery ()
  {
    return $this->_query;
  }

  /**
   * Set up some useful local state based on the dinosaur/record class
   * we're working with.
   */
  protected function handleClass ()
  {
    // Hack our way around some PHP fail:
    $rc = $this->_recordClass;

    // If these methods exist, we're probably dealing with a SparkRecord.
    // Otherwise, it's something else.
    if (method_exists($rc, 'getTableKey')) {
      $this->_tableKey    = $rc::getDefaultTableKey();
      $this->_table       = $rc::getDefaultTableName();
      $this->_tableRecord = $rc::getDefaults();
    }
  }

  /**
   * Talk to our friend, the database, and stash results appropriately.
   */
  protected function doQuery ()
  {
    if (constant('DB_LOGQUERIES')) {
      \SparkLib\Fail::log($this->_query);
      if (is_array($this->_params)) {
        \SparkLib\Fail::log($this->_params);
      }
    }

    try {
      // Get a resultset and stash it:

      if (is_array($this->_params)) {
        $this->_resultSet = $this->getDBH()->prepare($this->_query);
        $this->_resultSet->execute($this->_params);
      } else {
        // If we have no parameters, there's no real purpose to prepping
        // the query, so we may as well spare ourselves the performance hit:
        $this->_resultSet = $this->getDBH()->query($this->_query);
      }

    } catch (\PDOException $e) {
      $param_str = '';
      if (isset($this->_params)) {
        $param_str = "Params: " . implode(', ', $this->_params) . "\n";
      }
      $message = 'Query failed in SparkFinder: ' . $e->getMessage() . "\n" . $param_str . "\nQuery: " . $this->_query;
      throw new Exception($message);
    }

    // Pre-load our first result:
    $this->_row = $this->_resultSet->fetch(\PDO::FETCH_ASSOC);
  }

  protected function getDBH ()
  {
    return DB::getInstance();
  }

}
