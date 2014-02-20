<?php
namespace SparkLib;

use \SparkLib\Blode\Event;

/**
 * A simple error and exception logging facility.
 *
 * In public, send errors to the log file and display a brief "something broke"
 * notice for uncaught exceptions. In the development environment, spit a log
 * into the browser.
 *
 * This isn't pretty code. It embeds some silly HTML. Mainly, it is intended
 * to be self-contained, so that when things go all pear shaped it can do the 
 * right thing without reference to external resources. It's also meant
 * to be a simple development and diagnostic tool. Developers should expect
 * Fail::log($msg) to do the right thing, mostly.
 *
 * To use, call <code>\SparkLib\Fail::setup($public_or_not)</code> somewhere near
 * the start of your application. At SparkFun, we do this in a configuration file
 * shortly after setting up \SparkLib\Autoloader.
 */
class Fail {

  protected static $failCount      = 0;
  protected static $exceptionCount = 0;
  protected static $failText       = '';
  protected static $reference      = '';

  /**
   * Image to display with public errors.
   */
  public static $img_url = 'https://dlnmh9ip6v2uc.cloudfront.net/images/sparkfail.png';

  /**
   * Send all errors straight to the log?
   */
  public static $errorLogAll = false;

  /**
   * Include user agent with fail logging?
   */
  public static $logUserAgent = false;

  /**
   * Log to a specific file via file_put_contents() instead of using
   * error_log().
   */
  public static $logFile = null;

  /**
   * Log only strings matching this regex.
   */
  public static $grep = null;

  /**
   * Break out backtraces for php E_ errors/warning/notices/whatever
   */
  public static $doBacktraces = false;

  /**
   * Map numbers to human-readable error types.
   */
  public static $errorList = array(
    1     => 'E_ERROR',
    2     => 'E_WARNING',
    4     => 'E_PARSE',
    8     => 'E_NOTICE',
    16    => 'E_CORE_ERROR',
    32    => 'E_CORE_WARNING',
    64    => 'E_COMPILE_ERROR',
    128   => 'E_COMPILE_WARNING',
    256   => 'E_USER_ERROR',
    512   => 'E_USER_WARNING',
    1024  => 'E_USER_NOTICE',
    2048  => 'E_STRICT',
    4096  => 'E_RECOVERABLE_ERROR',
    8192  => 'E_DEPRECATED',
    16384 => 'E_USER_DEPRECATED',
    30719 => 'E_ALL',
  );

  /**
   * List errors which should be promoted to exceptions.
   *
   * Something like:
   *
   * <code>
   * \SparkLib\Fail::$exceptionOnErrors = array(E_RECOVERABLE_ERROR => true);
   * </code>
   */
  public static $exceptionOnErrors = array();

  /**
   * Set up error & exception handling, logging, etc.
   *
   * @param $public boolean are we operating in public?
   */
  public static function setup ($public = true)
  {
    $class = get_called_class();

    // We always log exceptions
    // The array here is a callback for \SparkLib\Fail::log()
    set_exception_handler(array($class, 'log'));

    if ($public) {
      // We're in public - this will display something safe for users:
      register_shutdown_function(array($class, 'PukePublic'));
    } else {
      // We're on a development box.
      set_error_handler(array($class, 'handleError'));

      // Did this come from a browser?
      if (isset($_SERVER['QUERY_STRING']) || isset($_SERVER['REMOTE_HOST']))
        register_shutdown_function(array($class, 'PukeDevelopment'));
    }
  }

  /**
   * Log an arbitrary string or Exception.
   *
   * @param $message string|Exception message to log
   * @param $type string optional type of message
   */
  public static function log ($message, $type = 'error')
  {
    // Did we get an Exception?
    if ($message instanceof \Exception) {

      // Get a unique string - we can log this, and then display it to the
      // user as a reference number.
      self::$reference .= substr(sha1(time() . __FILE__), 0, 10) . ' ';

      self::$exceptionCount++;
      $message_text = self::$reference . ':: Uncaught ' . get_class($message) . ' - '
                    . $message->getMessage() . "\n"
                    . $message->getTraceAsString();
    } elseif (is_array($message) || is_object($message)) {
      $message_text = print_r($message, 1);
    } else {
      $message_text = $message;
    }

    // if we're grepping for something specific, make sure this message matches:
    if (isset(static::$grep) && (! preg_match(static::$grep, $message_text))) {
      return;
    }

    // If blode is sitting around, send it our message.
    if (class_exists('Event')) {
      Event::err($message_text);
    }

    if (static::$logUserAgent && isset($_SERVER['HTTP_USER_AGENT'])) {
      $message_text .= ' [' . $_SERVER['HTTP_USER_AGENT'] . ']';
    }

    $message_text .= "\n";

    self::$failCount++;
    self::$failText .= $message_text;

    if (isset(self::$logFile)) {
      // Note deliberate error suppression; there's a good chance this
      // write will fail from the command line.
      @file_put_contents(self::$logFile, $message_text, \FILE_APPEND);
    } else {
      error_log($message_text);
    }
  }

  /**
   * Catch an error and do something useful with it, ignoring a
   * few less helpful things.
   */
  public static function handleError ($errno, $errstr, $errfile, $errline, $errcontext)
  {
    // Filter out low-urgency stuff we don't care about right now:
    // XXX: Get rid of SFE-specific stuff here.
    if ($errno === \E_NOTICE) {
      if (stristr($errstr, 'undefined index')) return;
    }
    if ($errno === \E_DEPRECATED) {
      if (strstr($errfile, 'Barcode.php')) return;
    }
    if (($errno === \E_WARNING) || ($errno === \E_STRICT)) {
      if (strstr($errfile, 'Barcode.php')) return;
      if (strstr($errfile, 'Code39.php')) return;
    }

    $errorType = static::$errorList[(int)$errno];

    self::log("$errfile +$errline - {$errorType} - $errstr\n");

    if (static::$doBacktraces) {
      // pull this current function call off of the trace
      $trace = debug_backtrace();
      array_shift($trace);

      self::log(static::compile_backtrace($trace));
    }

    if (isset(static::$exceptionOnErrors[ $errno ])) {
      // these get thrown on type errors and possibly elsewhere - let's
      // see what happens if we make sure they're fatal
      throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
  }

  /**
   * Check whether we've seen any failure.
   */
  public static function noFail ()
  {
    return (self::$failCount === 0);
  }

  /**
   * How many failures have we logged?
   */
  public static function failCount () { return self::$failCount; }

  /**
   * How many exceptions have we seen?
   *
   * Fundamentally this is kind of silly, since we're probably only
   * ever going to get _one_.
   */
  public static function exceptionCount () { return self::$exceptionCount; }

  /**
   * Return a simple version of the failure log.
   */
  public static function render ()
  {
    if (self::noFail()) {
      return 'No known failures.';
    }
    return self::$failText . "\n  " . self::$failCount . ' failures';
  }

  /**
   * Build a human-readable backtrace.
   */
  public static function compile_backtrace (array $backtrace)
  {
    $str = '';

    foreach ($backtrace as $stack_frame) {
      $str .= "{$stack_frame['file']} +{$stack_frame['line']}: {$stack_frame['function']}(";

      $first_argument = true;
      foreach ($stack_frame['args'] as $function_argument) {
        if (! $first_argument )
          $str .= ', ';

        $str .= $type = gettype($function_argument);

        switch ($type){
        case 'integer':
        case 'double':
        case 'boolean':
          $str .= "({$function_argument})";
          break;

        case 'string':
          $str .= '("';
          $str .= substr($function_argument,0, min(15, strlen($function_argument)) );
          $str .= '")';
          break;

        case 'array':
          $str .= '[' . count($function_argument) . ']';
          break;

        // a bit untested...
        case 'object':
          $str .= '('. get_class($function_argument) . ')';
          break;

        case 'resource':
          break;
        }

        $first_argument = false;
      }

      $str .= ")\n";
    }

    $str .= "\n\n";

    return $str;
  }

  /**
   * If we've seen any exceptions, spit out a friendly-ish error message,
   * safe for consumption by the general public.
   */
  public static function PukePublic ()
  {
    $img = static::$img_url;
    if (self::$exceptionCount) {
      ?><div style="border: 1px solid black; margin-left: 10%; margin-right: 10%; font-family: Georgia,Times,serif; z-index: 1000;">
          <img src="<?= $img ?>" style="float: left;">
          <h1>Something broke.</h1>
          <p>...not to worry. We've logged this error and will be looking into it.</p>
          <p>Reference #<?= self::$reference; ?>
          <div style="width: 1px; height: 1px; clear: both !important;"></div>
        </div><?php
    }
  }

  /**
   * Spit out something useful for debugging.
   *
   * We install this as a shutdown function in the dev environment,
   * just to force developers to pay attention
   */
  public static function PukeDevelopment ()
  {
    // Did we actually get any failures?         \
    //                                            --> skip it
    //  Are we supposed to just use error_log()? /
    if (self::noFail() || self::$errorLogAll) {
      return;
    }

    $img_url = static::$img_url;

    // fuuuuuugly:
    print <<<HTML
<style>
  pre#sparkfail-errors {
    position: absolute; top: 5px; left: 5px;
    z-index: 2147483647;
    text-align: left;
    background: white;
    color: red;
    border: 1px solid black;
    padding: 10px;
    background-image: url({$img_url});
    background-repeat: no-repeat;
    padding-bottom: 150px;
    background-position: bottom right;
  }

  pre#sparkfail-errors b       { float: left; font-weight: bold; color: black; }
  pre#sparkfail-errors b.close { cursor: pointer; color: blue; float: right; margin: 0; padding: 0; font-size: 1.1em; }
  pre#sparkfail-errors hr      { margin: 0; padding: 0; }
</style>
<pre id="sparkfail-errors">
<b>SparkFail</b><b class="close" onclick="foo=document.getElementById('sparkfail-errors');foo.style.display='none';">[X]</b>
<hr>
HTML;

    print self::render() . "\n</pre>";
    print "<script language=\"javascript\">$('body').keyup(function(e) { if(e.keyCode == 67) { $('#sparkfail-errors').hide() }; });</script>";
  }

}
