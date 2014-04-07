<?php
namespace SparkLib\Application\Environment;

use \SparkLib\Application\Environment;
use \SparkLib\Application\Request\Get;
use \SparkLib\Application\Request\Post;
use \SparkLib\Application\Request\Head;
use \SparkLib\Application\Request\Delete;

/**
 * An application environment for the command line.  Mangles ARGV,
 * STDIN, etc., into objects that can be treated by Application more
 * or less the same way it treats data from HTTP requests.
 *
 * See comments on Environment\HTTP for more detailed rationale.
 *
 * Arguments work like so:
 *
 * $ executable
 * $ executable controller
 * $ executable controller action
 * $ executable controller action param1=val param2=val ...
 *
 * Which should correspond almost exactly to:
 *
 * /index.php
 * /index.php/controller
 * /index.php/controller/action
 * /index.php/controller/action?param1=val
 *
 */
class CLI extends Environment {

  protected $_keyvalpat = '/
    (?<key> .*?)
    =
    (?<val> .*)
  /x';

  protected $_flagpat = '/
    -+
    (?<flag> [a-z]+)
  /xi';

  protected $_flags = [];

  public function __construct ()
  {
    global $argv;
    $script = array_shift($argv);

    $request  = [];
    $path_arr = [];

    foreach ($argv as $arg) {

      $matches = [];
      if (preg_match($this->_keyvalpat, $arg, $matches)) {

        // handle pulling key/values into the "request"
        $request[ $matches['key'] ] = $matches['val'];

      } else if (preg_match($this->_flagpat, $arg, $matches)) {

        // set some bits for --flag style flags
        $this->_flags[ $matches['flag'] ] = true;

      } else {

        // tack other strings on to path
        $path_arr[] = $arg;

      }

    }

    // we need a leading slash and a slash-separated path
    // for all the routing crap:
    $this->_path = implode('/', $path_arr);

    // if we have a path, but it doesn't start with a leading slash,
    // add one:
    if (strlen($this->_path)) {
      if ($this->_path[0] !== '/') {
        $this->_path = '/' . $this->_path;
      }
    }

    // set up a Request object
    switch ($this->method()) {
      case 'GET'    : $this->_req = new Get($request);    break;
      case 'POST'   : $this->_req = new Post($request);   break;
      case 'DELETE' : $this->_req = new Delete($request); break;
      case 'HEAD'   : $this->_req = new Head($request);   break;
      default       : $this->_req = new Get($request);
    }
  }

  public function method ()
  {
    // silly, liable to break:
    if ($this->_flags['get'])    return 'GET';
    if ($this->_flags['post'])   return 'POST';
    if ($this->_flags['delete']) return 'DELETE';
    if ($this->_flags['head'])   return 'HEAD';

    // silly default:
    return 'GET';
  }

  /**
   * For now, just fake a session.
   */
  public function startSession ()
  {
    $GLOBALS['_SESSION'] = [];
  }

  /**
   * End the current session.
   */
  public function endSession ()
  {
    $GLOBALS['_SESSION'] = array();
  }

  public function header ($header)
  {
    return;
  }

}
