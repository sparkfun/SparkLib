<?php

/**
 * AuthenticationException
 *
 * @author Ben LeMasurier <ben@sparkfun.com>
 */

namespace SparkLib\Exception;

class AuthenticationException extends SparkException
{
  public function __construct ($redirect = null, $code = 0, Exception $previous = null)
  {
    $this->_app_name   = 'Commerce';
    $this->_controller = 'account';
    $this->_action     = 'login';

    if ($redirect instanceof \SparkLib\Application\Link) {
      $this->_params = 'redirect=' . $redirect->path(false);
    } else if ($redirect) {
      $this->_params = 'redirect=' . $redirect;
    }

    $message = 'Please log in.';
    parent::__construct($message, $code, $previous);
  }
}
