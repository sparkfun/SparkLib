<?php
namespace SparkLib;

use \SessionHandlerInterface;
use \SparkLib\Session\PostgresStore;
use \SparkLib\Session\MemcachedStore;
use \SparkLib\Fail;

/**
 * A session handler.
 */
class Session implements SessionHandlerInterface {

  protected $_store = null;

  /**
   * Called first, to connect to the session store.
   */
  public function open($save_path, $session_name)
  {
    $this->_store = new PostgresStore();
    return $this->_store->connected();
  }

  /**
   * Called last to disconnect from session store.
   */
  public function close()
  {
    return $this->_store->close();
  }

  /**
   * Called with the sessid cookie to read serialized session data
   * out of the store.
   *
   * Keep in mind that the serialization format is some weird bullshit
   * with null bytes, _similar to_ but not apparently exactly the same as
   * what is done here:
   *
   *   http://php.net/manual/en/function.serialize.php
   *
   * This took us a long time to figure out, because we were trying to
   * treat the serialized value as a string and store it in a database
   * the same way.  You probably need to use a binary-safe field type
   * for this.
   */
  public function read ($id)
  {
    return $this->_store->read($id);
  }

  /**
   * Write all session values back out to the data store.
   *
   * Called once as the PHP process shuts down (probably, unless you do
   * something explicit).
   */
  public function write ($id, $data)
  {
    return $this->_store->write($id, $data);
  }

  /**
   * Destroy a session by id.
   */
  public function destroy ($id)
  {
    return $this->_store->destroy($id);
  }

  /**
   * Garbage collect expired sessions.
   *
   * We probably aren't going to bother implementing this right now.
   */
  public function gc ($maxlifetime)
  {
    return $this->_store->gc($maxlifetime);
  }

}
