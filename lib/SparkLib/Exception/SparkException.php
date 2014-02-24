<?php

/**
 * SparkException
 *
 * user-level application exceptions
 *
 * @author Ben LeMasurier <ben@sparkfun.com>
 */

namespace SparkLib\Exception;

use \SparkLib\Blode\Event;

class SparkException extends \Exception
{
  protected $_action     = 'index';
  protected $_controller = 'index';

  // require a message which will be displayed to the user
  public function __construct($message, $code = 0, Exception $previous = null) {
    Event::debug(array(
      'event'       => 'SparkException:' . $message,
      'app'         => get_class($this),
      'path'        => $_SERVER['REQUEST_URI'],
      'remote_addr' => $_SERVER['REMOTE_ADDR']
    ));

    parent::__construct($message, $code, $previous);
  }

  public function action()     { return $this->_action;     }
  public function controller() { return $this->_controller; }

  // these are user-level exceptions, never display a stack-trace.
  public function __toString() { return $this->message; }
}
