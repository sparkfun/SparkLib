<?php
namespace SparkLib;

use \SparkLib\Fail;

/**
 * A singleton to wrap up database connections for PDO.
 * May also be a place to hang some utility methods and
 * shortcuts.
 *
 * http://php.net/manual/en/book.pdo.php
 *
 * Sample usage:
 *
 * <code>
 * $dbh = \Spark\db::pdo();
 * $sth = $dbh->prepare('SELECT * FROM customers WHERE customers_id = :id');
 * $sth->execute(array('id' => 81000));
 * // FETCH_ASSOC gives us name => value
 * print_r($sth->fetch(PDO::FETCH_ASSOC));
 * </code>
 */
class DB {

  /**
   * Getters for DB\Literal implementations for various types/values.
   */
  public static function True () { return new \SparkLib\DB\True; }
  public static function False () { return new \SparkLib\DB\False; }
  public static function Null () { return new \SparkLib\DB\Null; }
  public static function Now () { return new \SparkLib\DB\Now; }
  public static function Random () { return new \SparkLib\DB\Random(\DB_SERVER_TYPE); }

  // FUCK YOU, PHP
  public static function DefaultValue () { return new \SparkLib\DB\DefaultValue; }

  public static function Field ($field)
  {
    return new \SparkLib\DB\Field($field);
  }

  protected static $_instance = null;

  /**
   * PDO TODO: this should be called something else and handle selecting
   * different servers based on queries and and and...
   *
   * Get a PDO object.
   */
  public static function pdo ()
  {
    if (! self::$_instance)
    {
      // No instance. Get a new one.
      self::$_instance = new \PDO(
        \DB_SERVER_TYPE . ':host=' . \DB_SERVER . ';dbname=' . \DB_DATABASE,
        \DB_SERVER_USERNAME,
        \DB_SERVER_PASSWORD,
        [\PDO::ATTR_PERSISTENT => \USE_PCONNECT ]
      );

      // We want exceptions on failures.
      self::$_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      self::$_instance->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_TO_STRING);

      if (\DB_SERVER_TYPE === 'mysql')
        self::$_instance->query("SET sql_mode='ANSI';");
    }

    return self::$_instance;
  }

  /**
   * place_holders
   *
   * gets the supplied number of PDO place holders
   * as a string to use with prepared queries
   *
   * @param int number of place holders to create
   * @access public
   * @return string
   *
   */
  public static function place_holders ($number = 1)
  {
    $arguments = array();

    for($i=0; $i<$number; $i++) {
      $arguments[] = '?';
    }

    return implode(',', $arguments);
  }

  public static function getInstance ()
  {
    return static::pdo();
  }

  /**
   * Convenience method to execute a query and return the results
   *
   * @param string $sql: sql statement. Can contain parameter placeholders
   * @param array $params: optional array of parameters that match the
   *                       placeholders in $sql
   * @return array of query results
   */
  public static function fetchAll ($sql, $params = [], $style = \PDO::FETCH_ASSOC)
  {
    $dbh = self::pdo();
    $sth = $dbh->prepare($sql);
    $sth->execute($params);
    return $sth->fetchAll($style);
  }

  /**
   * Convenience method to execute a query and return the results
   *
   * @param string $sql: sql statement. Can contain parameter placeholders
   * @param array $params: optional array of parameters that match the
   *                       placeholders in $sql
   * @param string $style: optional fetch mode. In the form of PDO::FETCH_*
   * @return array of query results
   */
  public static function fetch ($sql, $params = [], $style = \PDO::FETCH_ASSOC)
  {
    $dbh = self::pdo();
    $sth = $dbh->prepare($sql);
    $sth->execute($params);
    return $sth->fetch($style);
  }

  /**
   * Executes an array of statements
   *
   * Will catch and throw PDO errors
   *
   * All statments are executed with the same database connection.
   *
   * @param $sql_array Array of sql statements.
   */
  public static function exec_statements ($sql_array)
  {
    $dbh = self::pdo();
    $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    foreach ($sql_array as $stmt) {
      try {
        $dbh->exec($stmt);
      }
      catch (PDOException $e) {
        Fail::log($e);
      }
    }

  }

  /**
   * Convenience method for PDO::beginTransaction().
   *
   * Starts a database transaction.
   *
   * @returns nothing
   */
  public static function begin () {
    self::pdo()->beginTransaction();
  }

  /**
   * Convenience method for PDO::commit().
   * 
   * Commit a database transaction.
   *
   * @returns nothing
   */
  public static function commit () {
    self::pdo()->commit();
  }

  /**
   * Convenience method for PDO::rollBack().
   * 
   * Rollback a database transaction.
   *
   * @returns nothing
   */
  public static function rollback () {
    self::pdo()->rollBack();
  }

}
