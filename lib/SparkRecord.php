<?php
use \SparkLib\DB;
use \SparkLib\Blode\Event;

  /**
   * It's hard to believe this isn't a PHP builtin.
   *
   * @param $source array to pull a subset of key/value pairs out of
   * @param $keys list of keys to pull out
   * @return $result array
   */
  function array_subset_of_the_array_based_on_a_list_of_keys (array $source, array $keys)
  {
    $result = array();
    foreach ($keys as &$key)
      $result[$key] = $source[$key];
    return $result;
  }

  /**
   * SparkRecord - A base class for model objects stored in SQL
   *
   * See also:
   *   burn.php - generate records
   *   configuration/records.php - configuration for sparkgen.php
   *   lib/classes/SparkFinder.php - get an iterator for a collection of dinosaurs
   *   lib/classes/SparkFriendFinder.php - get an iterator for a collection of dinosaurs
   *   lib/classes/dinosaurs/*Saurus.php - interface
   *   lib/classes/dinosaurs/records/*Record.php - generated
   */
  abstract class SparkRecord {

    // This will be our data store:
    protected $_record       = array();
    protected $_extraSelects = array();
    protected $_joined       = array();

    protected $_tableId;

    // This will store record values we've changed using __set()
    // e.g., $somerecord->property = 'somevalue'
    protected $_changes = array();

    // This will store the original values of changed fields.
    protected $_originalValues = array();

    // Has the record changed?
    protected $_changed = false;

    // Has this record been loaded from the db?
    protected $_loaded  = false;

    // Do we think we can plausibly delete the row represented by this record?
    protected $_canDelete = false;

    // Should we use the cache?
    protected $_useCache = false;

    // Should we save all modifications to this dino to MongoDB?
    protected $_logModifications = false;

    // are there any fields we don't care about for modification logging?
    protected $_ignoreModifications = array();

    // Store has_one and belongs_to results here.
    protected $_dinostore = array();

    protected static $_relationships;

    protected $_field_cache = array();

    // A place to stash data which can be used by update/delete/insert hooks -
    // stuff like an associated user id, change note, etc.
    protected $_modificationInfo = array();

    /**
     * Build a record, by one of
     *   1. Loading defaults for the class.
     *   2. Loading a single id from the database.
     *   3. Populating it from a row of values passed in - generally from a Spark(Friend)Finder.
     *
     * postLoad() will be called here. There's no preLoad() because
     * That sounds fairly dangerous
     *
     * @param mixed $loadFrom may be either an integer id or an array of key/value pairs, such as
     * returned by PDO's fetch().
     *
     * @param boolean $useCache should we check the cache for a copy of the record, and store one
     * there if it doesn't exist?
     */
    public function __construct ($loadFrom = null, $useCache = false)
    {
      $this->_record = static::$_defaults;

      // Caching? Avoid the whole question if caching is turned off site-wide:
      if (constant('\MEMCACHED_ENABLED') === true)
        $this->_useCache = $useCache;

      if (isset($loadFrom)) {
        if (is_numeric($loadFrom) && ($loadFrom >= 0)) {
          $this->loadFromId($loadFrom);
        } elseif (is_array($loadFrom)) {
          $this->loadFromRow($loadFrom);
        } else {
          throw new UnexpectedValueException('expected result row array or integer id 0 or above - got ' . $loadFrom);
        }
      }

      $this->postLoad();
    }

    /**
     * Post-load hook. Override this if you need to take an action after data
     * has been retrieved from the db. Be really careful.
     */
    protected function postLoad () { }

    /**
     * Set the primary key for this record.
     *
     * *this is a hack*
     *
     * @param int $value
     * @access public
     * @return void
     */
    public function setPrimaryKey ($value)
    {
      $this->_originalValues[static::$_tableKey] = $this->_record[static::$_tableKey];
      $this->_record[static::$_tableKey] = $value;
      $this->_changes[static::$_tableKey] = $value;
      $this->_changed = true;
    }

    protected function hasMany ($value)
    {
      return isset(static::$_relationships[$value])
          && static::$_relationships[$value]['type'] == 'has_many';
    }

    protected function hasOne ($value)
    {
      return isset(static::$_relationships[$value])
          && static::$_relationships[$value]['type'] == 'has_one';
    }

    protected function belongsTo ($value)
    {
      return isset(static::$_relationships[$value])
          && static::$_relationships[$value]['type'] == 'belongs_to';
    }
    /**
     * Setter magic - set a corresponding element in our record.
     *
     * if an appropriate dinosaur is passed into a valid has_one, its
     * the corresponding key will be set and the object loaded
     *
     * for now there's no support for setting a has_many
     */
    public function __set($property, $value)
    {
      if ($property === static::$_tableKey)
        throw new SparkRecordException('you may not manually set the primary key.');

      // Are we just setting a scalar value?
      if ($this->isValidField($property)) {

        $this->typeValidate($property, $value);

        if ($this->_record[$property] !== $value) {
          $this->_originalValues[$property] = $this->_record[$property];
          $this->_record[$property]  = $value;
          $this->_changes[$property] = $value;
          $this->_changed            = true;
        }
        return $value;
      }

      // Or are we setting a relationship?  Value must be a dino.

      // belongs_to?  Set our key to theirs.
      if ($this->belongsTo($property)) {
        $key = static::$_relationships[$property]['fk'];
        $this->$key = $value->getId();
        $this->_dinostore[$property] = $value;
        return $value;
      }

      // has_one?  Set their key to ours.
      if ($this->hasOne($property)) {
        // Disabling this for now.  It makes the update sequence confusing because
        // you would have to call it on the target dino. It has never worked anyway.
        throw new SparkRecordException('no setting has_one for now.');
        /*
        $key = static::$_relationships[$property]['pk'];
        $value->$key = $this->getId();
        $this->_dinostore[$property] = $value;
        return true;
        */
      }

      throw new SparkRecordException("setting $property not allowed in " . get_class($this));
    }

    /**
     * Assign values from a source array (or object).
     *
     * Expects an object with public properties or an array. Skips
     * items not set on the source or invalid for this SparkRecord.
     *
     * @param $source of key/value pairs
     * @param $fields array of fields to extract from $source and set
     * @return $this
     */
    public function setFrom ($source, $fields = null)
    {
      if (! isset($fields))
        $fields = $this->getFields();

      if (is_array($source))
        $source = (object)$source;

      foreach ($fields as &$field) {
        if ($field === static::$_tableKey)
          continue;

        if (isset($source->$field) && $this->isValidField($field))
          $this->__set($field, $source->$field);
      }

      return $this;
    }

    /**
     * Getter magic
     *
     * Get a scalar field, or a relationship.
     *
     * @param string property name
     * @return scalar|SparkRecord|SparkFinder value for that property
     */
    public function __get ($property)
    {
      if ($this->isValidField($property))
        return $this->_record[$property];

      if (isset($this->_dinostore[$property]))
        return $this->_dinostore[$property];

      if (isset(static::$_relationships[$property])) {
        $class = static::$_relationships[$property]['class'];
        $key = static::$_relationships[$property]['fk'];
      } else {
        throw new SparkRecordException("getting $property not allowed in " . get_class($this));
      }

      /* TODO: Ok, so I kind of want to make a belongsTo relationship
               return a false if not set, like the hasOne relationship
               sort of incidentally does, rather than throwing an
               Exception because the key isn't set or refers to something
               that doesn't exist.

               I know that in a sense this maybe _should_ be an exception -
               we're sort of enforcing database constraints in code that
               way - but I suspect that in practical terms a lot of code
               would be simpler to write and less buggy if we could just
               take it as given that $address->Country would be false if
               not present, for example.

               If we decide to go this route, I'll do an

               ack-grep --php -C 'try {'|less

               ...and clean up anywhere that expects an exception here.
               I don't think there are _that_ many.

               -- bpb 5/13/2012 */

      if ($this->belongsTo($property)) {
        // This right here is what will blow up if we don't have a value for
        // the relationship:
        $this->_dinostore[$property] = new $class($this->_record[$key]);
        return $this->_dinostore[$property];
      }

      // TODO: this only works if key names are identical
      if ($this->hasOne($property)) {
        $this->_dinostore[$property] = $class::finder()->where($key)->eq($this->getId())->getOne();
        return $this->_dinostore[$property];
      }

      if ($this->hasMany($property)) {
        return new SparkFriendFinder($class, $key, $this->_tableId);
      }
    }

    /**
     * Check isset() against a given property of the record.
     *
     * This is actually trickier than it seems at first blush, and
     * should probably be expanded to account for relationships, but
     * it's hard to say exactly where the right level of abstraction is.
     */
    public function __isset ($property)
    {
      if ($this->isValidField($property))
        return isset($this->_record[$property]);

      // this covers some cases where a value may be cached
      if (isset(static::$_relationships[$property]))
        return isset($this->_dinostore[$property]);

      return false;
    }

    /**
     * Access any extra fields (by name) from the result row that created
     * this dinosaur.
     */
    public function extraSelect ($key)
    {
      return $this->_extraSelects[$key];
    }

    /**
     * Access all extra selects as an array.
     */
    public function extraSelects ()
    {
      return $this->_extraSelects;
    }

    /**
     * See if we have a given extra select value.
     */
    public function hasExtraSelect ($key)
    {
      return array_key_exists($key, $this->_extraSelects);
    }

    /**
     * Check the type of a field.
     *
     * TODO: Should this be static?
     */
    public function typeOf ($field)
    {
      return static::getType($field);;
    }

    /**
     * Return a value theoretically juggled into the correct PHP type.
     *
     * Post-PDO TODO: I think PDO may actually do this for us if we want
     * it.  Right now, that would probably break a lot of assumptions.
     */
    public function getTyped ($property)
    {
      $types = static::getTypes();

      if (! $this->isValidField($property))
        throw new SparkRecordException($property . ' is not a member of ' . get_called_class());

      switch($types[$property]) {
        case 'int':   return (int)     $this->_record[$property]; break;
        case 'float': return (float)   $this->_record[$property]; break;
        case 'bool':  return (boolean) $this->_record[$property]; break;
        default:      return           $this->_record[$property]; break;
      }
    }

    /**
     * Return the record, with each individual element passed through getTyped().
     */
    public function getTypedRecord ()
    {
      $rec = array();

      if (func_num_args()) {
        $keys = func_get_args();
        $rec = array_subset_of_the_array_based_on_a_list_of_keys($this->_record, $keys);
      } else {
        $rec = $this->_record;
      }

      foreach ($rec as $key => $val) {
        $rec[$key] = $this->getTyped($key);
      }

      return $rec;
    }

    /**
     * Return a standalone finder for a given has_many relationship.
     */
    public function hatch ($property)
    {
      if (! $this->hasMany($property)) {
        throw new SparkRecordException("finding $property not allowed in " . get_class($this));
      }
      $class = static::$_relationships[$property]['class'];
      return new SparkFriendFinder($class, static::$_tableKey, $this->_tableId);
    }

    /**
     * Jurassic Park, motherfuckers.
     */
    public function __clone ()
    {
      // Unset the id in case we want to insert this as a new record
      $this->_tableId = null;
      $this->_record[static::$_tableKey] = null;
    }

    /**
     * I have to admit that without the clones, it would have not been a victory.
     */
    public function cloneInto ($clone = null, $ignored_saurs = [])
    {
      if (!isset($clone))
        $clone = clone $this;

      $clone->insert();

      foreach(static::$_relationships as $saur=>$relationship) {
        if ($relationship['type'] == 'has_many' && !in_array($saur, $ignored_saurs)) {
          $records = $this->$saur->find();
          while($record = $records->getNext())
          {
            $cloned = clone $record;
            $cloned->$relationship['fk'] = $clone->getID();
            $record->cloneInto($cloned, $ignored_saurs);
          }
        }
      }

      return $clone;
    }

    /**
     * @return integer id of current record
     */
    public function getId () { return $this->_tableId; }

    /**
     * @return integer id of current record
     */
    public function id ()    { return $this->_tableId; }

    /**
     * @return string name of table modeled by this class
     */
    public function getTableName () { return static::$_tableName; }

    /**
     * @return string name of primary key
     */
    public function getTableKey ()  { return static::$_tableKey; }

    /**
     * This will return a list of the fields this class knows about. A subtle
     * trap: This doesn't take relationships into account at all; it only models
     * the core table.
     *
     * @return array list of fields
     */
    public function getFields () { return array_keys($this->_record); }

    /**
     * Static getters for some basic info. These are poorly named.
     */
    public static function getBaseName ()         { return static::$_baseName;      }
    public static function getDefaultTableName () { return static::$_tableName;     }
    public static function getDefaultTableKey ()  { return static::$_tableKey;      }
    public static function getDefaults ()         { return static::$_defaults;      }
    public static function getTypes ()            { return static::$_types;         }

    public static function getType ($field)
    {
      return static::$_types[ $field ];
    }

    // TODO: This is used by SparkFriendFinder to see if rels are valid,
    //       but it doesn't take has one and has many into account by
    //       default. Possibly those should just get moved into
    //       this array... Anyhow, causes that bug where you have to
    //       specify primary and foreign keys explicitly in records.php
    //       for a rel to get picked up.
    public static function getRelationships ()    { return static::$_relationships; }

    /**
     * Are we allowed to set/get the following key?
     */
    public function isValidField ($field)
    {
      if(empty($this->_field_cache))
        foreach($this->_record as $k => &$v)
          $this->_field_cache[$k] = true;

      return isset($this->_field_cache[$field]);
    }

    /**
     * Has a given field changed via set magic?
     *
     * @param $field string name of field
     */
    public function isChangedField ($field)
    {
      return isset($this->_changes[$field]);
    }

    /**
     * How many fields have changed via set magic?
     */
    public function countChanges ()
    {
      return count($this->_changes);
    }

    /**
     * Has anything changed via set magic?
     */
    public function isChanged () { return $this->_changed; }

    /**
     * Return the original value from the db/blank record.
     */
    public function originalValue ($field) {
      if (array_key_exists($field, $this->_originalValues))
        return $this->_originalValues[$field];
      else
        return $this->_record[$field];
    }

    /**
     * Has our record been loaded from the db?
     */
    public function isLoaded () { return $this->_loaded; }

    /**
     * Can this record be deleted?
     */
    public function canDelete () { return $this->_canDelete; }

    /**
     * Return a string dump of the record array.
     */
    public function dumpRecord (array $fields = array(), $format = 'verbose')
    {
      if (count($fields))
        $record = array_subset_of_the_array_based_on_a_list_of_keys($this->_record, $fields);
      else
        $record = $this->_record;

      if ('oneline' === $format) {
        $output = '';
        foreach ($record as $field => &$value) {
          $output .= "[$field]\t$value\t";
        }
        return $output;
      } else {
        return print_r($record, 1);
      }
    }

    /**
     * Return the record array.
     *
     * If given an array of keys, will limit the returned result to those keys.
     *
     * If given multiple strings, will limit the returned results to those keys.
     */
    public function getRecord ()
    {
      if (func_num_args()) {
        $keys = func_get_args();
        if (is_array($keys[0])) {
          $keys = $keys[0];
        }
        return array_subset_of_the_array_based_on_a_list_of_keys($this->_record, $keys);
      } else {
        return $this->_record;
      }
    }

    /**
     * Return just the values of the current record array.
     *
     * If given an array of keys, will limit the returned result to those keys.
     *
     * If given multiple strings, will limit the returned results to those keys.
     */
    public function getValues ()
    {
      if (func_num_args()) {
        $keys = func_get_args();
        if (is_array($keys[0])) {
          $keys = $keys[0];
        }
        return array_values($this->getRecord($keys));
      }

      return array_values($this->_record);
    }

    /**
     * Return the changes we've made.
     */
    public function changes() { return $this->_changes; }

    /**
     * Return the values before those changes;
     */
    public function originalValues() {
      return array_merge(
        $this->_record,
        $this->_originalValues
      );
    }

    /**
     * Return a string dump of the changes we've made.
     */
    public function dumpChanges () { return print_r($this->_changes, 1); }

    /**
     * reload the dinosaur from the DB, wiping any current changes
     *
     * TODO: Should postLoad() be called here?
     */
    public function refresh ()
    {
      if (! $this->isLoaded())
        throw new SparkRecordException('Cannot refresh an unloaded dinosaur.');

      $this->loadFromId($this->getId());
      $this->markUnchanged();
      $this->_dinostore = array();
    }

    /**
     * Mark this record as unchanged, after a refresh() or an update().
     *
     * There may be conceptual problems here.
     */
    protected function markUnchanged ()
    {
      $this->_changes = array();
      $this->_changed = false;
      $this->_originalValues = array();
    }

    /**
     * Find an array for this record in memcache, if one exists.
     *
     * @return array
     */
    protected function getCache ($id)
    {
      $key = $this->cacheKey($id);
      return unserialize(SparkCache::getInstance()->get($key));
    }

    /**
     * Store this record in memcache.
     */
    protected function setCache ()
    {
      $key = $this->cacheKey();
      return SparkCache::getInstance()->set($key, serialize($this->_record));
    }

    /**
     * Invalidate the memcache entry for this record.
     */
    public function invalidateCache ()
    {
      if (! MEMCACHED_ENABLED === true)
        return;
      return SparkCache::getInstance()->delete($this->cacheKey());
    }

    /**
     * Make a cache key based on the class of the current dinosaur plus an
     * id - by default the one loaded from the DB. Will die screaming if
     * the id is not available, which is probably a good indication someone
     * tried to update() a record before inserting it.
     *
     * @param $id integer optional id
     * @return string key
     */
    public function cacheKey ($id = null)
    {
      if (! isset($id))
        $id = $this->getId();

      $current_dinosaur = get_class($this) . $id;

      if (! $id) {
        throw new SparkRecordException(
          'No id when making cache key for '
          . $current_dinosaur
          . ' - has record been inserted?'
        );
      }

      return $current_dinosaur;
    }

    /**
     * Load data based on an id.
     */
    protected function loadFromId ($id)
    {
      // Handle caching
      $values = $this->_useCache
              ? $this->getCache($id)
              : null;

      // Cache values after loading?
      $savecache = false;

      if (! $values) {
        $savecache = true;
        $dbh = DB::getInstance();

        $tn = static::$_tableName;
        $tk = static::$_tableKey;

        $query = "SELECT * FROM \"{$tn}\" WHERE \"{$tk}\" = :id;";
        try {
          $sth = $dbh->prepare($query);
          $sth->execute(['id' => $id]);
          if (true === constant('\DB_LOGQUERIES')) {
            \SparkLib\Fail::log($sth->queryString, 'info');
          }
        } catch (Exception $e) {
          throw new SparkRecordException("Query failed: {$query}: " . $e->getMessage());
        }

        $count = $sth->rowCount();
        if ($count != 1)
          throw new SparkRecordException("{$count} record(s) found using {$query} - id should be unique, id given: {$id}");

        $values = $sth->fetch(\PDO::FETCH_ASSOC);
      }

      $this->loadFromRow($values);

      if ($this->_useCache && $savecache)
        $this->setCache();
    }

    /**
     * Store a row that's already been loaded from the db, potentially
     * including related dinosaurs from a JOIN.
     *
     * @param array result row
     */
    protected function loadFromRow (array &$result_row)
    {
      $joined = array();
      foreach ($result_row as $field => &$value) {
        if ($this->isValidField($field)) {
          $this->_record[$field] = $value;
        } elseif (strstr($field, '__')) {
          // the __ delimiter is expected to mean that we did a join in SFF
          list($dino_basename, $column) = explode('__', $field);
          $joined[$dino_basename][$column] = $value;
        } else {
          $this->_extraSelects[$field] = $value;
        }
      }

      // make friends:
      foreach ($joined as $dino_basename => &$values) {
        $dino_class = $dino_basename . 'Saurus';
        $this->_dinostore[$dino_basename] = new $dino_class($values); // rawr
      }

      $this->_loaded    = true;
      $this->_canDelete = true;
      $this->_tableId   = $this->_record[static::$_tableKey];
    }

    /**
     * Store any changes to a record in the db.
     *
     * Context-aware method that update()s or insert()s based on what needs
     * to happen. Useful if you don't know if the record was just created or
     * was around before you started.
     */
    public function wbang()
    {
      if ($this->isLoaded())
        return $this->update();
      else
        return $this->insert();
    }

    /**
     * Set some metadata to be accessed by pre- and post- change hooks on
     * child classes. (preUpdate, postUpdate, etc.)
     */
    public function modificationInfo ($info = null)
    {
      if (is_array($info))
        $this->_modificationInfo = $info;
      return $this->_modificationInfo;
    }

    /**
     * Used by logModifications to convert strings to UTF8
     */
    protected function to_utf8()
    {
      return function ($value) {
        if(! is_string($value)) {
          return $value;
        }
        return utf8_encode($value);
      };
    }

    /**
     * Saves the changes to the current record to MongoDB.
     * Called by insert/update/delete when the _logModifications boolean
     * is set to true in the dinosaur, or if modificationInfo is set before
     * update.
     */
    protected function logModifications($action, array $changes)
    {
      $mongo = ModificationsDBI::getInstance();
      $table = static::$_tableName;

      foreach ($this->_ignoreModifications as $ignore_field) {
        if (isset($changes[$ignore_field])) {
          unset($changes[$ignore_field]);
        }
      }

      // if there's nothing to log, avoid logging an empty record
      if (! count($changes)) {
        return;
      }

      $modification = $this->modificationInfo();
      $modification['id']      = (int)$this->getId();
      $modification['action']  = $action;
      $modification['date']    = new MongoDate();
      $modification['changed'] = $changes;

      $mongo->$table->insert($modification);
    }

    /**
     * pre- and post-update hooks - override these if you need them
     */
    protected function preUpdate() { }
    protected function postUpdate() { }

    /**
     * Store any changes to a record in the db.
     *
     * Calls preUpdate() and postUpdate(), which can be overridden as-need
     * in the child class. Also invalidates any cached version of the record
     * (even if it doesn't wind up doing anything to the db - this could
     * probably use some thought).
     *
     * Returns true if we updated something, false if we didn't.
     * Throws a SparkRecordException if the update fails.
     */
    public function update ()
    {
      $this->invalidateCache();
      $this->preUpdate();

      // Bail out if we don't have anything to update:
      if (! $this->isChanged())
        return false;

      $COMMA = ', ';
      $SPACE = ' ';

      $dbh = DB::getInstance();

      $numcols = count($this->_changes);
      $cols = '';
      $i    = 0;

      $update_data = [];

      foreach ($this->_changes as $col => $val)
      {
        $i++;
        $end = ($i < $numcols ? $COMMA : $SPACE);
        $cols .= '"' . $col . '" = ';

        $val = $this->typeJuggle($col, $val);

        if ($val instanceof DB\Literal) {
          $val_str = $val->literal();
        } else {
          $val_str = ':' . $col;
          // tack on to array for later execution of prep'd statement:
          $update_data[$col] = $val;
        }

        $cols .= $val_str . $end;
      }

      $q = 'UPDATE "' . static::$_tableName . '" SET ' . $cols . ' WHERE '
         . static::$_tableKey . ' = :_tablekey';

      $update_data['_tablekey'] = $this->_tableId;
      try {
        $sth = $dbh->prepare($q);
        foreach ($update_data as $col => $val) {
          $sth->bindValue(":$col", $val);
        }
        $sth->execute($update_data);
      } catch (Exception $e) {
        throw new SparkRecordException('Update failed: ' . $e->getMessage());
      }

      if ($this->_logModifications || count($this->modificationInfo()) > 0) {
        $this->logModifications('UPDATE', $this->_changes);
      }

      $this->logUpdate();
      $this->postUpdate();

      // Reset the changes array and the _changed flag so that future updates
      // using the same dinosaur don't rewrite the same fields:
      $this->markUnchanged();

      return true;
    }

    /**
     * Pre- and post-insertion hooks - override these if you need them.
     *
     * Changes are still available for examination within postInsert(),
     * but will be reset immediately afterwards.
     */
    protected function preInsert () { }
    protected function postInsert () { }

    /**
     * Insert a new record in the db.
     *
     * Calls preInsert() and postInsert(), if they are defined in the child
     * class.
     */
    public function insert ()
    {
      $this->preInsert();

      $dbh = DB::getInstance();

      // build the list of things we actually care about inserting - those differing
      // from defaults, specifically:
      $insert_values = [];
      foreach ($this->_record as $insert_key => $insert_val) {
        if ($insert_val !== static::$_defaults[ $insert_key ]) {
          $insert_values[ $insert_key ] = $insert_val;
        }
      }

      if (! isset($insert_values[ static::$_tableKey ]))
        $insert_values[ static::$_tableKey ] = DB::DefaultValue();

      $numcols = count($insert_values);

      $q    = 'INSERT INTO "' . static::$_tableName . '"';
      $cols = ' (';
      $vals = ' VALUES (';

      $insert_data = [];

      $i = 0;
      foreach ($insert_values as $col => $val)
      {
        $i++;
        $end = $i < $numcols ? ", " : ") ";
        // quote column names in case we run into a reserved word
        $cols .= '"' . $col . '"' . $end;

        $val = $this->typeJuggle($col, $val);

        if ($val instanceof DB\Literal) {
          $vals .= $val->literal();
        } else {
          $vals .= ':' . $col;
          // tack on to array for later execution of prep'd statement:
          $insert_data[$col] = $val;
        }

        $vals .= $end;
      }

      $q .= $cols . $vals;

      if ('pgsql' === constant('\DB_SERVER_TYPE')) {
        $q .= ' RETURNING *' ;
      }

      try {
        $sth = $dbh->prepare($q);
        foreach ($insert_data as $col => $val) {
          $sth->bindValue(":$col", $val);
        }
        $sth->execute();

        if ('pgsql' === constant('\DB_SERVER_TYPE')) {
          $insert_result = $sth->fetch(\PDO::FETCH_ASSOC);
          $this->loadFromRow($insert_result);
        } else {
          $this->_tableId = $dbh->lastInsertId();
        }
      } catch (Exception $e) {
        $failure_data_string = '';
        foreach ($insert_values as $failed_insert_column => $failed_insert_value) {
          if ($failed_insert_value instanceof DB\Literal) {
            $failed_insert_value = $failed_insert_value->literal();
          }
          $failure_data_string .= "$failed_insert_column: $failed_insert_value; ";
        }
        throw new SparkRecordException(
          'Insert failed: ' . $e->getMessage() . "\n[Query] " . $q . "\n[Values] $failure_data_string\n"
        );
      }

      // We have an id now, so we could do a delete operation.
      $this->_canDelete = true;

      // try and keep this in synch
      $this->_record[static::$_tableKey] = $this->_tableId;

      if($this->_logModifications || count($this->modificationInfo()) > 0) {
        $this->logModifications('INSERT', $this->_record);
      }

      $this->logInsert();
      $this->postInsert();

      // Reset the changes array and the _changed flag so that
      // any update() calls using the same dinosaur don't rewrite
      // those fields, and so that postUpdate() can behave sanely
      // in that case.
      $this->markUnchanged();

      return $this->_tableId;
    }

    /**
     * Normalize values to a scheme expected by insert() and update().
     */
    protected function typeJuggle ($col, $val)
    {
      // promote actual PHP nulls to SQL nulls
      if (is_null($val))
        $val = new DB\Null;

      if ($val instanceof DB\Literal)
        return $val;

      // if we just have a PHP native type here, we may need to do
      // some juggling:
      switch ($this->typeOf($col)) {
        case 'bool':
          if ($val) {
            $val = DB::True();
          } else {
            $val = DB::False();
          }
          break;
        case 'int':
          break;
      }

      return $val;
    }

    /**
     * Blow up if someone is trying to use a bogus value.
     */
    protected function typeValidate ($col, $val)
    {
      if (is_null($val) || ($val instanceof DB\Null)) {
        if (! static::$_nullable[$col]) {
          throw new SparkRecordException(
            "$col is not a nullable column on " . get_class($this) . "'s table, " . static::$_tableName
          );
        }
      }
    }

    /**
     * Pre- and post-deletion hooks - override these if you need them.
     */
    protected function preDelete() { }
    protected function postDelete() { }

    /**
     * Delete a record from the db.  You probably shouldn't be doing this.
     *
     * Calls preDelete() and postDelete(), if they are defined in the child.
     *
     * TODO: Should this call markUnchanged()?
     */
    public function delete ()
    {
      $this->invalidateCache();
      if (! $this->canDelete())
        throw new SparkRecordException("can't delete this record - sure you inserted or loaded it from the db?");

      $this->preDelete();

      $dbh = DB::getInstance();

      $tk = static::$_tableKey;
      $tn = static::$_tableName;

      try {
        $sth = $dbh->prepare(
          "DELETE FROM \"{$tn}\" WHERE \"{$tk}\" = :id"
        );
        $sth->execute(['id' => $this->_tableId]);
      } catch (Exception $e) {
        throw new SparkRecordException('Delete failed: ' . $e->getMessage());
      }

      if($this->_logModifications || count($this->modificationInfo()) > 0) {
        $this->logModifications('DELETE', $this->_record);
      }

      $this->logDelete();
      $this->postDelete();

      return true;
    }

    /*
     * These are about telling the universal log that something has happened...
     *
     * TODO - should the notification framework stuff move in here?
     *
     * The way I see it, this gets called from every insert(), update(),
     * or delete().  It should talk to some kind of data store that allows
     * for collections of arbitrary key-value pairs, and usefully record
     *
     *   a. the dinosaur in question
     *   b. time of action
     *   c. actor (This Part is Tricky and an Open Question)
     *   d. the delta in data
     *
     * This would be a foundation for a really robust general-purpose audit
     * log, as well as for a new alert system - or more generally a framework
     * for letting users define actions to take on given events, or collections
     * of events to monitor.
     *
     * There are a bunch of NoSQL systems that might work well here.  Probably
     * it should be the sort of thing that we can also invoke from other places
     * to log less granular events. We probably need a class much like \SparkLib\Fail
     * to drive it.
     *
     * For right now, messing with the following functions...
     */

    /**
     * Log an update.
     */
    protected function logUpdate ()
    {
      $this->logWrite('update',$this->_changes);
    }

    /**
     * Log the insertion of a new record.
     */
    protected function logInsert ()
    {
      $this->logWrite('insert', $this->_record);
    }

    /**
     * Log a deletion.
     */
    protected function logDelete ()
    {
      $this->logWrite('delete');
    }

    /**
     * Log some write operation to the database.
     */
    protected function logWrite ($action, $payload = array())
    {
      Event::info(array(
        'event'     => 'sparkrecord.write',
        'type'      => get_class($this),
        'id'        => $this->getId(),
        'action'    => $action,
        'payload'   => $payload
      ));

      if(defined('\FLAG_NOTIFY') && constant('\FLAG_NOTIFY')) {

        $dino_name = get_class($this);

        if( \Spark\Notify::validDino($dino_name) ) {

          $payload = array(
            'id'             => $this->getId(),
            'record'         => $this->getRecord(),
            'changes'        => $this->changes(),
            'originalValues' => $this->originalValues()
          );

          \Spark\Notify::emit($dino_name, $action, $payload);

        }

      }
    }

    /**
     * Provide a readable description of a Dinosaur.
     *
     * This is a silly hack and should not be used other than maybe in your handy
     * REPL. (See sparksh.)
     */
    public static function describe ()
    {
      $text = 'Dinosaur: ' . get_called_class() . "\n\n";

      // fields
      $fieldcount = count(static::getDefaults());
      $text .= "Fields ($fieldcount):\n\t";
      $pkey = static::getDefaultTableKey();
      foreach (static::getDefaults() as $field => $value) {
        $pri = '';
        if ($pkey == $field)
          $pri = " (PRIMARY)";
        if (strlen($value))
          $value = " <$value>";
        $fields[] = "$field{$value}{$pri}";
      }
      $text .= wordwrap(implode($fields, ', '), 70, "\n\t");
      $text .= "\n";

      // methods
      $all_methods         = get_class_methods(get_called_class());
      $default_methods     = get_class_methods('SparkRecord');
      $interesting_methods = array_diff($all_methods, $default_methods);

      $text .= "\nCustom methods:\n\t"
             . wordwrap(implode($interesting_methods, ', '), 70, "\n\t")
             . "\n\n";

      // relationships
      if (static::getRelationships()) {
        $text .= "\nRelationships:\n";
        foreach (static::getRelationships() as $rel => $keys) {
          $text .= "\t$rel: $keys[0] -> $keys[1]\n";
        }
      }

      return $text;
    }

    /**
     * Get a SparkFriendFinder for this class.
     */
    public static function finder ()
    {
      return new SparkFriendFinder(get_called_class());
    }

    /**
     * Get a SparkFriendFinder for this class where $field matches $value,
     * with find() already called
     *
     * @param $field string
     * @param $value string
     */
    public static function findBy ($field, $value)
    {
      return static::finder()->where($field)->eq($value)->find();
    }

    /**
     * Return the first record for this class where $field matches $value
     *
     * @param $field string
     * @param $value string
     */
    public static function getBy ($field, $value)
    {
      return static::findBy($field, $value)->getOne();
    }

    /**
     * Return the first record for this class where the primary key matches $value
     *
     * @param $value string
     */
    public static function getById ($value)
    {
      return static::getBy(static::$_tableKey, $value);
    }

    /**
     * Return the first record for this class where the primary key matches $value,
     * with a FOR UPDATE clause appended to the select query.
     *
     * @param $value string
     */
    public static function getByIdForUpdate ($value)
    {
      return static::finder()->where(static::$_tableKey)->eq($value)->forUpdate()->getOne();
    }

  }
