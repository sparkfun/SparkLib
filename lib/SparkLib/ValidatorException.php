<?php
namespace SparkLib;
use Exception;

/**
 * An Exception class for when validation blows up. See SparkLib\Validator.
 */
class ValidatorException extends Exception {

  protected $_failures = array();

  public function __construct (array $failures)
  {
    $this->_failures = $failures;

    // give the exception a somewhat readable error string
    foreach ($failures as $field => $problem) {
      $error_message = $field . ' ' . $problem;
    }
    parent::__construct($error_message);
  }

  /**
   * @return associative array of validation failures
   */
  public function getErrors ()
  {
    return $this->_failures;
  }

}
