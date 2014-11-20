<?php
namespace SparkLib\Session;

use \Memcache;
use \SparkLib\Fail;

/**
 * A concrete implementation of session storage in memcached.  Used by
 * \SparkLib\Session.
 */
class MemcachedStore {

  protected $_mc = null;
  protected $_connected = false;

  public function __construct ()
  {
    $this->_mc = new Memcache();
    $this->_connected = $this->_mc->pconnect(MEMCACHED_SERVER, MEMCACHED_PORT);
  }

  public function connected ()
  {
    return $this->_connected;
  }

  public function read ($id)
  {
    return $this->_mc->get($id);
  }

  public function write ($id, $data)
  {
    Fail::log(var_export($data, 1));
    // TODO: should this compress?  Do keys expire even with 0 set for expiry?
    return $this->_mc->set($id, $data, false, 0);
  }

  public function close ()
  {
    // we can't actually close persistent memcache connections - fake it for now:
    $this->_connected = false;
    return true;
  }

  public function destroy ($id)
  {
    return $this->_mc->delete($id);
  }

  public function gc ($maxlifetime)
  {
    // DO NOTHING AT ALL
    return true;
  }

}
