<?php
namespace SparkLib\Application\Environment;

use \SparkLib\Application\Environment;
use \SparkLib\Application;
use \Exception;

/**
 * An application Environment for HTTP requests.  Mangles standard
 * PHP request variables and such into objects that can be used
 * cleanly by the Application and Controller classes.
 *
 * Once upon a time, Application and Request between them handled
 * what little this class does.  The advantage of decoupling
 * our Request object from things like PHP superglobals is that we
 * can then adopt the same application to other execution
 * models without worrying about the specifics of a PHP SAPI or
 * what-have-you.  By mapping other forms of input onto the same
 * interfaces we've used to build a web application, we can more
 * easily reuse utility functions and expose a code surface for
 * unit testing.
 *
 * Besides the command-line client that prompted this, we might
 * consider possiblities like text-to-speech, an e-mail gateway,
 * or APIs as thin translation layers to the mainline application.
 *
 *   -- bpb 2013/December/9
 */
class HTTP extends Environment {

  public function __construct ()
  {
    if ($_GET && $_POST)
      throw new Exception("can't mingle GET variables with a POST if instantiating an Application");

     // See also: http://php.net/manual/en/reserved.variables.server.php
    $this->_path = $_SERVER['PATH_INFO'];

    switch ($this->method()) {
      case 'GET'    : $this->_req = new \SparkLib\Application\Request\Get($_GET); break;
      case 'POST'   : $this->_req = new \SparkLib\Application\Request\Post($_POST); break;
      case 'DELETE' : $this->_req = new \SparkLib\Application\Request\Delete($_REQUEST); break;
      case 'HEAD'   : $this->_req = new \SparkLib\Application\Request\Head($_GET); break;
      default       : $this->_req = new \SparkLib\Application\Request\Get(array()); // fake it for other methods
    }

    $this->discernType();
  }

  /**
   * Initialize and populate sessions.
   */
  public function startSession ()
  {
    if (! isset($_SESSION))
      session_start();
  }

  /**
   * End the current session.
   */
  public function endSession ()
  {
    $_SESSION = array();
    session_destroy();
  }

  public function method ()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function header ($header)
  {
    header($header);
  }

  /**
   * Grab the first thing in the Accepts: header, check it against
   * a whitelist, and (if it passes) set the expected MIME type of request
   * to it.  This may later be overwritten by a type extension found
   * on the URL by Application's routing mechanism.
   *
   * For now this is defaulting to text/html if we get an unrecognized
   * type.  More appropriate behavior MIGHT be to throw an exception,
   * but on the other hand it could be that we're going to get a lot of
   * weird input that we don't want to break on.
   *
   * Much to be investigated here.
   */
  protected function discernType ()
  {
    $accept = $_SERVER['HTTP_ACCEPT'];
    $types = explode(',', $accept);
    list($first_type) = explode(';', $types[0]);
    $first_type = trim($first_type);
    if (Application::$mimeToExtension[$first_type]) {
      $this->_req->setType($first_type);
    }
  }

}
