<?php
namespace SparkLib;

use \SessionHandlerInterface;
use \SparkLib\Session\MemcachedStore;
use \SparkLib\Fail;

/**
 * A session handler.
 */
class Session implements SessionHandlerInterface {

  protected $_store = null;

  public function open($save_path, $session_name)
  {
    Fail::log(['session-open', $save_path, $session_name]);
    $this->_store = new MemcachedStore();
    return $this->_store->connected();
  }

  public function close()
  {
    Fail::log(['session-close']);
    return $this->_store()->close();
  }

  public function read ($id)
  {
    Fail::log(['session-read', $id]);
    return $this->_store->read($id);
  }

  public function write ($id, $data)
  {
    Fail::log(['session-write', $id, $data]);
    return $this->_store->write($id, $data);
  }

  public function destroy ($id)
  {
    Fail::log(['session-destroy', $id]);
    return $this->_store->destroy($id);
  }

  public function gc ($maxlifetime)
  {
    Fail::log(['session-gc', $maxlifetime]);
    return $this->_store->gc($maxlifetime);
  }

}
