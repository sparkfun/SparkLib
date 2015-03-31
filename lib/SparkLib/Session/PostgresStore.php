<?php
namespace SparkLib\Session;

use SparkLib\Fail;
use PDO;

/**
 * A concrete implementation of session storage in PostgreSQL.  Used by
 * \SparkLib\Session.  See that class for some commentary on order of
 * method calls and such.
 */
class PostgresStore {

  protected $_dbh;

  protected $_connected      = false;
  protected $_found_existing = false;

  public function __construct ()
  {
    $this->_dbh = new \PDO(
      \DB_SERVER_TYPE . ':host=' . \DB_SERVER . ';dbname=' . \DB_DATABASE,
      \DB_SERVER_USERNAME,
      \DB_SERVER_PASSWORD,
      [ \PDO::ATTR_PERSISTENT => false ]
    );

    // We want exceptions on failures.
    $this->_dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $this->_dbh->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_TO_STRING);

    $this->_dbh->exec('BEGIN');

    $this->_connected = $this->_dbh instanceof \PDO;
  }

  public function connected ()
  {
    return $this->_connected;
  }

  public function read ($id)
  {
    $q = 'SELECT data FROM sessions WHERE id = :sessid FOR UPDATE';
    $sth = $this->_dbh->prepare($q);

    $success = $sth->execute(['sessid' => $id]);

    $values = $sth->fetch(\PDO::FETCH_ASSOC);

    if ($sth->rowCount() > 0) {
      $this->_found_existing = true;

      // PDO should be giving us a file resource here - has to be treated
      // as such.
      return fgets($values['data']);
    }

    return "";
  }

  public function write ($id, $data)
  {
    if ($this->_found_existing) {
      $q = 'UPDATE sessions SET data = :sessdata WHERE id = :sessid';
    } else {
      $q = 'INSERT INTO sessions (id, data) VALUES(:sessid, :sessdata)';
    }

    $sth = $this->_dbh->prepare($q);
    $sth->bindParam(':sessid', $id);

    // PARAM_LOB: Large Object Binary - inserting into a bytea field, which is
    // sorta like a blob - have to do this because the serialized session data
    // contains null bytes:
    $sth->bindParam(':sessdata', $data, PDO::PARAM_LOB);

    $success = $sth->execute();

    $this->_dbh->exec('COMMIT');

    return $success;
  }

  public function close ()
  {
    $this->_dbh = null;
    $this->_connected = false;
    return true;
  }

  public function destroy ($id)
  {
    $q = 'DELETE FROM sessions WHERE id = :sessid;';
    $sth = $this->_dbh->prepare($q);
    
    $success = $sth->execute(['sessid' => $id]);

    // We probably need to commit the transaction here so that this
    // takes effect:
    $this->_dbh->exec('COMMIT');

    return $success;
  }

  public function gc ($maxlifetime)
  {
    // DO NOTHING AT ALL
    return true;
  }

}
