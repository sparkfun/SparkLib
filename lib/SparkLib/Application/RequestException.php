<?php
namespace SparkLib\Application;
use \SparkLib\ValidatorException;

/**
 * An Exception class for when request validation blows up. See
 * SparkLib\Application\Request.
 */
class RequestException extends ValidatorException { }
