<?php

/**
 * AuthenticationException
 *
 * @author Ben LeMasurier <ben@sparkfun.com>
 */

namespace SparkLib\Exception;

class AuthenticationException extends SparkException
{
  public function __construct($message = "Authentication Required", $code = 0, Exception $previous = null) {
    if($message instanceof \SparkLib\Application\Link) {
      // this kind of feels dirty.
      $this->_action     = $message->getAction();
      $this->_controller = $message->getController();
      $message = 'Authentication Required';
    } else {
      $this->_action     = 'login';
      $this->_controller = 'account';
    }

    parent::__construct($message, $code, $previous);
  }
}
