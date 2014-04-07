<?php
namespace SparkLib\Application;

abstract class Environment {

  protected $_req;
  protected $_path;

  abstract public function __construct ();
  abstract public function method ();
  abstract public function startSession ();
  abstract public function endSession ();

  /**
   * Send a header.
   */
  abstract public function header ($header);

  public function req ()  { return $this->_req;  }
  public function path () { return $this->_path; }

  /**
   * @return string client's remote IP address, if any
   */
  public function remoteAddress ()
  {
    return isset($_SERVER['REMOTE_ADDR'])
           ? $_SERVER['REMOTE_ADDR']
           : null;
  }

  /**
   * Name of the currently running script.
   *
   * @return string filename of currently running script
   */
  public function script ()
  {
    // I think this may be defined regardless of SAPI
    return basename($_SERVER['PHP_SELF']);
  }

}
