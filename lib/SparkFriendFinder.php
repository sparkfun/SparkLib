<?php
use \SparkLib\DB;
use \SparkLib\Fail;

/**
 * This is a modified SparkFinder for use with generated relationships.  It
 * is automatically available through __get magic on dinosaurs with a
 * corresponding has_many defined in configuration/records.php.  For now it
 * uses a blanket 's' on the end of the class name for plurals, like Orders,
 * Customers, or OrdersStatusHistorys =[
 *
 * See the last section of this file for the available SQL operations.
 *
 * EXAMPLE 1: Find a customer's 5 most recent orders.
 *
 * $customer = new CustomerSaurus(id);
 * $orders = $customer->Orders->orderBy('date_purchased', 'DESC')->limit(5)->find();
 * while($order = $orders->getNext())
 *   // whatever
 *
 * It should be noted that while a foreach() on the return of find() will
 * also work, it loads everything into memory first and is thus a lot more
 * costly than the above while() example, as that iterates over one result at
 * a time.  So, use while().
 *
 * EXAMPLE 2: Find a single storefront product by SKU:
 *
 * $product = StorefrontProductSaurus::finder()
 *   ->where('products_model')->eq('DEV-00666')
 *   ->find()->current();
 *
 * This uses the static finder() method available to all generated records.
 * So, find() returns a SparkFriendFinder with the first result (the only
 * one, in this case) preloaded, and current() returns it.
 */
class SparkFriendFinder extends \SparkLib\Iterator {

  const NULLS_LAST  = 'LAST';
  const NULLS_FIRST = 'FIRST';

  protected $_recordClass;
  protected $_relationships;

  // A class to instantiate with the record instance as its only
  // parameter and return
  protected $_wrapperClass = null;

  // Table and primary key of the record class we're searching for.
  protected $_table       = null;
  protected $_tableKey    = null;
  protected $_tableRecord = null;

  protected $_sparkfinder = null;
  protected $_total = null;

  // Initial SELECT and WHERE.
  protected $_default_query = '';
  // Full query with constraints.
  protected $_query      = '';

  // Those constraints:
  protected $_distinctOn = '';
  protected $_join       = '';
  protected $_with       = '';
  protected $_where      = '';
  protected $_orderBy    = '';
  protected $_groupBy    = '';
  protected $_limit      = '';
  protected $_forUpdate  = '';

  // For the time being these two will only get set in child classes of this one.
  protected $_left_join = '';
  protected $_extraselects = '';

  protected $_key;
  protected $_id;

  protected $_buffered = true;

  protected $_selectIdOnly = false;

  /**
   * Get a new finder. Takes a string containing the classname of dinosaur
   * to instantiate, and an optional key and id.
   *
   * If a key and id are passed, we are looking for records in the context of
   * another one, e.g. getting a customer's orders.  Otherwise, we are
   * (probably) using the static SomeRecord::finder() method.
   */
  public function __construct ($record_class, $key = null, $id = null)
  {
    $this->_recordClass = $record_class;
    $this->_key         = $key;
    $this->_id          = $id;

    // It's worth noting that class_exists() probably invokes the Autoloader here
    if (! class_exists($this->_recordClass))
      throw new InvalidArgumentException("No such record class: {$this->_recordClass}");

    // Pull in some metadata from the record class:
    $this->handleClass();
  }

  /**
   * Re-run the previous query, starting over from the first record.
   */
  public function rewind ()
  {
    if (! $this->_sparkfinder)
      return false;
    $this->getResults();
  }

  // Simple getters
  public function key ()         { return $this->current()->getId(); }
  public function recordClass () { return $this->_recordClass; }
  public function tableKey ()    { return $this->_tableKey; }
  public function tableRecord () { return $this->_tableRecord; }

  /**
   * Return current position within the resultset.
   */
  public function position()
  {
    if (isset($this->_sparkfinder))
      return $this->_sparkfinder->position();
    else
      return 0;
  }

  /**
   * Check if there's a currently available record.
   *
   * @return bool - yay or nay
   */
  public function valid ()
  {
    return $this->_sparkfinder->valid();
  }

  /**
   * How many rows in the current statement results?
   */
  public function count ()
  {
    if (! $this->_sparkfinder)
      return false;
    return $this->_sparkfinder->count();
  }

  /**
   * How many rows total with these params?
   *
   * Keeps the joins, as they may affect the total; drops the _with because
   * that's just overhead.
   */
  public function total ()
  {
    $dbi = SparkDBI::getInstance();

    if($this->_total)
      return $this->_total;

    $q = 'SELECT COUNT(' . $this->_table . '.' . $this->_tableKey . ') AS total ' .
        ' FROM ' . $this->_table .
          $this->_join .
          $this->_left_join .
        ' WHERE true ' .
          $this->_where;

    $totalArray = $dbi->fetchRow($q);
    $this->_total = (int)$totalArray['total'];

    return $this->_total;
  }

  /**
   * How many rows total with these params?
   *
   * use this if you have a group by statement in your query
   */
  public function group_total ()
  {
    $dbi = SparkDBI::getInstance();

    if ($this->_total)
      return $this->_total;

    $q = 'SELECT COUNT(0) AS total FROM (SELECT ' . $this->_table . '.' . $this->_tableKey .
        ' FROM "' . $this->_table . '"' .
          $this->_join .
          $this->_left_join .
        ' WHERE true ' .
          $this->_where .
          $this->_groupBy .
         ') g';

    $totalArray = $dbi->fetchRow($q);
    $this->_total = $totalArray['total'];

    return $this->_total;
  }

  /**
   * Advance to the next record.
   */
  public function next ()
  {
    if (! $this->_sparkfinder)
      throw new Exception('No current results - find() not called?');
    return $this->_sparkfinder->next();
  }

  /**
   * Return an object for the current record.
   *
   * @return SomeSaurus - a $this->_recordClass
   */
  public function current ()
  {
    if (! $this->valid())
      return false;

    if ($this->_wrapperClass) {
      $wrapper = $this->_wrapperClass;
      // yo dawg, I heard you like classes
      return new $wrapper($this->_sparkfinder->current());
    }

    return $this->_sparkfinder->current();
  }

  /**
   * Load the next record and return an object for it.
   *
   * @return SomeSaurus - a $this->_recordClass
   */
  public function getNext ()
  {
    // Assume we want to go ahead and find() if there aren't
    // already results to get
    if (! isset($this->_sparkfinder))
      $this->find();

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
   * @return true if there are more available.
   */
  public function hasNext ()
  {
    return $this->count() && ($this->_sparkfinder->position() < $this->count());
  }

  /**
   * Load some class properties with meta data about $this->_recordClass.
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
   * Set a wrapper class for results.
   */
  public function wrap ($class)
  {
    if (class_exists($class)) {
      $this->_wrapperClass = $class;
    } else {
      throw new Exception($class . ' does not exist');
    }
    return $this;
  }

  /**
   * Build the query.
   *
   * @return string sql
   */
  public function buildQuery ()
  {
    // Build and save the query
    $this->_query = $this->_base_query() .
                    $this->_where .
                    $this->_groupBy .
                    $this->_orderBy .
                    $this->_limit .
                    $this->_forUpdate . "\n";

    return $this->_query;
  }

  /**
   * Build the query, execute it, and load the first object.
   *
   * @return SparkFriendFinder - $this, for method chains.
   */
  public function find ()
  {
    // Build and save the query
    $this->buildQuery();

    // clear query parts
    $this->_join    = '';
    $this->_where   = '';
    $this->_orderBy = '';
    $this->_limit   = '';
    $this->_with    = '';

    // Get a SparkFinder and stash it
    $this->getResults();

    return $this;
  }

  /**
   * Get a database handle.
   */
  protected function getDBH ()
  {
    return DB::getInstance();
  }

  /**
   * Turn the current query into a result set and stash it.
   */
  protected function getResults ()
  {
    try {
      $this->_sparkfinder = new SparkFinder(
        $this->_recordClass,
        $this->_query
      );
    } catch (Exception $e) {
      throw new Exception('Query fail: ' . $this->_query . ' -- ' . $e->getMessage());
    }

    // PDO TODO: Come up with a graceful way to request an unbuffered resultset.
    //           (Presumably necessitates a connection per resultset.)
  }

  /**
   * Make the query a FOR UPDATE query.
   *
   * Essentially what this does is put a row lock on
   * every row that is part of the SELECT query such that
   * any other query (with a FOR UPDATE clause) that matches
   * any of the selected rows for this finder will block
   * until the current transaction has completed, either by
   * a commit or rollback.
   */
  public function forUpdate () {
    $this->_forUpdate = ' FOR UPDATE';
    return $this;
  }

  /**
   * Run find() and get the first result. Just a utility to shorten
   * things up a bit. If find() has already been called, will act
   * as an alias to current(), rather than re-running a bare query.
   *
   * @return SparkRecord
   */
  public function getOne ()
  {
    if (isset($this->_sparkfinder))
      return $this->current();
    return $this->find()->current();
  }

  /**
   * JOIN the given dinosaur by the relationship defined in records.ini
   */
  public function with ($dinosaur)
  {
    $record_class = $this->_recordClass;
    $relationships = $record_class::getRelationships();

    if (! isset($relationships[$dinosaur]))
      throw new Exception('Invalid relationship: ' . $dinosaur);

    if(in_array($relationships[$dinosaur]['type'], array('has_one', 'has_many'))) {
      $our_key   = $relationships[$dinosaur]['pk'];
      $their_key = $relationships[$dinosaur]['fk'];
    } elseif($relationships[$dinosaur]['type'] == 'belongs_to') {
      $our_key   = $relationships[$dinosaur]['fk'];
      $their_key = $relationships[$dinosaur]['pk'];
    }

    // If this is a one to many relationship, use a left join
    /*
    $has_many = $record_class::getHasManyDefaults();
    if($has_many[$dinosaur])
      $this->_join .= ' LEFT';
    */

    $classname = $relationships[$dinosaur]['class'];
    $this->_with .= $this->_generate_with($classname);
    $this->_join .= " JOIN {$classname::getDefaultTableName()} {$classname::getDefaultTableName()} ON {$this->_table}.{$our_key} = {$classname::getDefaultTableName()}.{$their_key} \n";

    return $this;
  }

  /**
   * JOIN another dinosaur by the relationship
   * defined in records.ini
   * TODO: Maybe merge this with with() or something less verbose?
   */
  public function withOn ($dinosaur, $joinon)
  {
    $record_class = $joinon . 'Saurus';
    $relationships = $record_class::getRelationships();

    if(! isset($relationships[$dinosaur]))
      throw new Exception('Invalid relationship: ' . $dinosaur . ' on ' . $record_class);

    if(in_array($relationships[$dinosaur]['type'], array('has_one', 'has_many'))) {
      $our_key   = $relationships[$dinosaur]['pk'];
      $their_key = $relationships[$dinosaur]['fk'];
    } elseif($relationships[$dinosaur]['type'] == 'belongs_to') {
      $our_key   = $relationships[$dinosaur]['fk'];
      $their_key = $relationships[$dinosaur]['pk'];
    }

    $classname = $relationships[$dinosaur]['class'];
    $this->_with .= $this->_generate_with($classname);
    $this->_join .= " JOIN {$classname::getDefaultTableName()} {$classname::getDefaultTableName()} ON {$record_class::getDefaultTableName()}.{$our_key} = {$classname::getDefaultTableName()}.{$their_key} \n";

    return $this;
  }

  /**
   * LEFT JOIN a table
   *
   * @param string $sql LEFT JOIN table on pkey = fkey
   */
  public function leftJoin ($sql)
  {
    $sql = trim($sql);

    if (! strlen($sql))
      return $this;

    // make sure it is left join sql
    if (strtoupper(substr($sql, 0, 9)) != 'LEFT JOIN')
      throw new Exception('Invalid LEFT JOIN clause: ' . $sql);

    $this->_left_join = ' ' . $sql . ' ';
    return $this;
  }

  /**
   * put some extra fields in the SELECT
   * for use with leftJoin() or sql functions
   *
   * BEWARE! If you use this in public-facing code with user inputs,
   * Brennen WILL murder you.
   *
   * @param array $fields fields or sql expressions like COUNT(*)
   */
  public function extraSelects ($fields)
  {
    if (! is_array($fields) || ! count($fields))
      throw new Exception('extraSelects expects a non-empty array');

    $sql = implode(', ', $fields) . ','; // needs trailing comma

    $this->_extraselects = $sql . ' ';
    return $this;
  }

  /**
   * To select only the primary table id and any extra selects
   * (instead of select * from all tables)
   *
   */
  public function selectIdOnly ()
  {
    $this->_selectIdOnly = true;
    return $this;
  }

  /**
   * FIELD table field name
   * **BEWARE: This function is rendered useless with a join or extraselects.
   */
  public function isValidField ($field)
  {
    if ($this->_join === '' && $this->_left_join === '' && $this->_extraselects === '') {
      return isset($this->_tableRecord[$field]);
    } else {
      return true;
    }
  }

  /**
   * Add to the WHERE clause for a given field.
   *
   * Be careful - this may fail if you're doing a ->with() _after_ the where().
   * Do with() first.
   *
   * @param $field string
   * @return SparkFriendFinder
   */
  public function where ($field)
  {
    if (!$this->isValidField($field))
      throw new Exception('Invalid field in where clause: ' . $field);

    $this->_where .= "\n  AND " . $field;
    return $this;
  }

  public function whereSubstring($field, $from, $for)
  {
    if (!$this->isValidField($field))
      throw new Exception('Invalid field in where clause: ' . $field);

    if (!is_integer($from) || !is_integer($for))
      throw new Exception('Invalid from/for in whereSubstring clause ' . $field);

    $this->_where .= "\n  AND substring(" . $field . " from " . $from . " for " . $for . ")";
    return $this;
  }

  /**
   * Add a WHERE lower($field)
   *
   * @param $field string
   * @return SparkFriendFinder
   */
  public function whereLower ($field)
  {
    if (!$this->isValidField($field))
      throw new Exception('Invalid field in where clause: ' . $field);

    $this->_where .= "\n  AND lower(" . $field . ")";
    return $this;
  }

  public function orWhere ($field)
  {
    if (!$this->isValidField($field))
      throw new Exception('Invalid field in where clause: ' . $field);

    $this->_where .= "\n  OR " . $field;
    return $this;
  }

  public function orWhereSubstring($field, $from, $for)
  {
    if (!$this->isValidField($field))
      throw new Exception('Invalid field in where clause: ' . $field);

    if (!is_integer($from) || !is_integer($for))
      throw new Exception('Invalid from/for in orWhereSubstring clause ' . $field);

    $this->_where .= "\n  OR substring(" . $field . " from " . $from . " for " . $for . ")";
    return $this;
  }

  /**
   * Add to the WHERE clause for a given subquery evaluation.
   *
   * Like with where() be careful - this may fail if you're doing
   * a ->with() _after_ the where(). Do with() first.
   *
   * @param $subquery string
   * @return SparkFriendFinder
   */
  public function subquery ($subquery)
  {
    $this->_where .= "\n  AND (\n"
                  .  $subquery . "\n"
                  . ")";

    return $this;
  }

  /**
   * startSub - begin a sub-where clause in the query.
   *
   * example:
   *
   *   $orders = OrderSaurus::finder()
   *   $orders->startSub();
   *   $orders->orWhere('customers_name')->like('%' . $s_query . '%');
   *   $orders->orWhere('customers_email_address')->like('%' . $s_query . '%');
   *   $orders->endSub();
   *   $orders->find();
   *
   * @param $op string of either AND or OR to prepend to the outside of the subclause
   * @param $subop string of either AND or OR which will affect the subclause
   */
  public function startSub ($op = 'AND', $subop = 'OR')
  {
    if('AND' == strtoupper($op))
      $this->_where .= "\n AND ( ";
    if('OR' == strtoupper($op))
      $this->_where .= "\n OR ( ";

    if('AND' == strtoupper($subop))
      $this->_where .= ' true ';
    if('OR' == strtoupper($subop))
      $this->_where .= ' false ';

    return $this;
  }

  public function endSub ()
  {
    $this->_where .= "\n ) ";
    return $this;
  }

  public function orderBy ($field, $direction = 'ASC', $nulls = null)
  {
    if ('ASC' != $direction && 'DESC' != $direction)
      throw new Exception('Invalid direction in "orderBy" clause: ' . $direction);

    if (isset($nulls) && (('FIRST' !== $nulls) && ('LAST' !== $nulls)))
      throw new Exception('Invalid NULLS in "orderBy" clause: ' . $nulls);

    if ($field instanceof \SparkLib\DB\Literal) {
      // right now, this just handles Random() - might be other things, tho:
      $field = $field->literal();
    } else {
      // it's a string - check whether it's safe to order by
      // We're unable to validate fields if a FIND_IN_SET or COALESCE is present.
      if (!stristr($field, 'FIND_IN_SET') && !stristr($field, 'COALESCE')) {
        if (!$this->isValidField($field))
          throw new Exception('Invalid field in orderBy clause: ' . $field);
      }
    }

    if ('' == $this->_orderBy)
      $this->_orderBy = ' ORDER BY ' . $field . ' ' . $direction;
    else
      $this->_orderBy .= ', ' . $field . ' ' . $direction;

    if (isset($nulls))
      $this->_orderBy .= ' NULLS ' . $nulls;

    return $this;
  }

  public function groupBy ($field)
  {
    // We're unable to validate fields if a FIND_IN_SET is present.
    if (!stristr($field, 'FIND_IN_SET')) {
      if (!$this->isValidField($field) && $field !== self::RAND)
        throw new Exception('Invalid field in "groupBy" clause: ' . $field);
    }

    if ('' == $this->_groupBy)
      $this->_groupBy = ' GROUP BY ' . $field;
    else
      $this->_groupBy .= ', ' . $field;

    return $this;
  }

  public function distinctOn ($field)
  {
    // We're unable to validate fields if a FIND_IN_SET is present.
    if (!stristr($field, 'FIND_IN_SET')) {
      if (!$this->isValidField($field) && $field !== self::RAND)
        throw new Exception('Invalid field in "distinct" clause: ' . $field);
    }

    if ('' == $this->_distinctOn)
      $this->_distinctOn = ' DISTINCT ON (' . $field . ')';
    else
      $this->_distinctOn = str_replace(')', ',', $this->_distinctOn) . $field . ')';

    return $this;

  }

  /**
   * PDO TODO: document
   */
  public function limit ($limit, $offset = 0)
  {
    $limit  = (int) $limit;
    $offset = (int) $offset;

    if ('' != $this->_limit)
      throw new Exception('You may only impose one "limit" clause.');

    if($limit > 0)
      $this->_limit = ' LIMIT ' . $limit;

    $this->_limit .= ' OFFSET ' . $offset;

    return $this;
  }

  /**
   * PDO TODO: document
   */
  public function eq ($val)
  {
    if (is_array($val)) {
      $this->_where .= ' IN(';
      foreach($val as $i => $v) {
        $this->_where .= $this->render($v);
        if($i+1 < count($val))
          $this->_where .= ',';
      }
      $this->_where .= ')';
    } else {
      $this->_where .= ' = ' . $this->render($val);
    }
    return $this;
  }

  /**
   * A hack to look for the lower-case version of a string.
   *
   * We'll let the database handle lower-casing, since there's a good
   * chance it's smarter than PHP.
   */
  public function eqLower ($val)
  {
    if (! is_string($val)) {
      throw new \Exception('lowerEq() expects a string, for now');
    }

    $this->_where .= ' = lower(' . $this->render($val) . ')';
    return $this;
  }

  /**
   * PDO TODO: document
   */
  public function ne ($val)
  {
    if (is_array($val)) {
      $this->_where .= ' NOT IN(';
      foreach($val as $i => $v) {
        $this->_where .= $this->render($v);
        if($i+1 < count($val))
          $this->_where .= ',';
      }
      $this->_where .= ')';
    } else {
      $this->_where .= ' <> ' . $this->render($val);
    }
    return $this;
  }

  /**
   * IS - use with a DB\Null, for example.
   */
  public function is ($val)
  {
    $this->_where .= ' IS ' . $this->render($val);
    return $this;
  }

  /**
   * IS NOT - use with a DB\Null, for example.
   */
  public function isnot ($val)
  {
    $this->_where .= ' IS NOT ' . $this->render($val);
    return $this;
  }

  /**
   * IN()
   * Added so we can use sub-selects. NOT ESCAPED.
   * eq/ne should be used under normal circumstances
   */
  public function in ($val)
  {
    // this isn't escaped because we need IN((query)) to be quote-free.
    // be seriously fucking careful.
    $this->_where .= ' IN(' . $val . ')';
    return $this;
  }

  /**
   * like in, but not. NOT ESCAPED.
   */
  public function nin ($val)
  {
    // this isn't escaped because we need NOT IN((query)) to be quote-free.
    // be really goddamned careful.
    $this->_where .= ' NOT IN(' . $val . ')';
    return $this;
  }

  public function gt ($val) { $this->_where .= ' > ' . $this->render($val); return $this; }

  public function lt ($val) { $this->_where .= ' < ' . $this->render($val); return $this; }

  public function between($val1, $val2) { $this->_where .= ' BETWEEN ' . $this->render($val1) . ' AND ' . $this->render($val2); return $this; }

  public function gte ($val) { $this->_where .= ' >= ' . $this->render($val); return $this; }

  public function lte ($val) { $this->_where .= ' <= ' . $this->render($val); return $this; }

  public function like ($val) { $this->_where .= ' LIKE ' . $this->render($val); return $this; }

  public function plus ($val) { $this->_where .= ' + ' . $this->render($val); return $this; }

  public function minus ($val) { $this->_where .= ' - ' . $this->render($val); return $this; }

  /**
   * Case-insensitive like.
   */
  public function ilike ($val)
  {
    // MySQL doesn't support ILIKE
    if ('mysql' !== constant('\DB_SERVER_TYPE')) {
      $this->_where .= ' ILIKE ' . $this->render($val);
      return $this;
    }
    return $this->like($val);
  }

  public function has($val) {
    return $this->like('%' . $val . '%');
  }

  public function ihas($val) {
    return $this->ilike('%' . $val . '%');
  }

  public function nlike ($val) { $this->_where .= ' NOT LIKE ' . $this->render($val); return $this; }

  /**
   * Case-insensitive nlike.
   */
  public function nilike ($val)
  {
    // MySQL doesn't support ILIKE
    if ('mysql' !== constant('\DB_SERVER_TYPE')) {
      $this->_where .= ' NOT ILIKE ' . $this->render($val);
      return $this;
    }
    return $this->nlike($val);
  }

  /**
   * Use buffered results.
   */
  public function buffered ()
  {
    $this->_buffered = true;
    return $this;
  }

  /**
   * Use unbuffered results.
   */
  public function unbuffered ()
  {
    // PDO TODO:  it would be nice to make unbuffered resultsets available
    throw new \Exception('unbuffered queries are not yet implemented for SparkFriendFinder');
    $this->_buffered = false;
    return $this;
  }

  /**
   * Custom escape to quote and otherwise render strings.
   */
  protected function render ($value)
  {
    $value = $this->typeJuggle($value);
    if ($value instanceof DB\Literal) {
      return $value->literal();
    }
    return $this->getDBH()->quote($value);
  }

  /**
   * Normalize values to the scheme expected by render()
   */
  protected function typeJuggle ($val)
  {
    // promote actual PHP nulls to SQL nulls
    if (is_null($val))
      $val = new DB\Null;

    if ($val instanceof DB\Literal)
      return $val;

    if (is_string($val))
      return $val;

    if (is_bool($val)) {
      if ($val)
        $val = new DB\True;
      else
        $val = new DB\False;
    }

    return $val;
  }


  /**
   * Initial SELECT and WHERE.
   *
   * If a JOIN is present, it will be included.
   */
  protected function _base_query ()
  {
    $this->_default_query = 'SELECT ' .
                             $this->_distinctOn . ' ' .
                             $this->_extraselects;

    // if true, only primary table key and extra selects are selected
    if ($this->_selectIdOnly) {
      $this->_default_query .= $this->_table . '.' . $this->_tableKey;
    } else {
      $this->_default_query .= $this->_table . '.* ' .
                             $this->_with;
    }

    $this->_default_query .= ' FROM ' . $this->_table .
                             $this->_join .
                             $this->_left_join .
                           ' WHERE ' . (($this->_key && $this->_id) ? $this->_key . ' = ' . $this->_id : 'true ');

    return $this->_default_query;
  }

  /**
   * Generates a string which selects and aliases
   * each column for a given dinosaur.
   */
  protected function _generate_with ($dinosaur)
  {
    $with = '';

    $table = $dinosaur::getDefaultTableName();
    $columns = array_keys($dinosaur::getDefaults());
    foreach ($columns as $column) {
      $with .= ", " . $table . '.' . $column . ' AS "' . $dinosaur::getBaseName() . '__' . $column . '"';
    }

    return $with;
  }

}
