<?php
namespace SparkLib;

use \Exception;

/**
 * A general-purpose validation class.
 */
class Validator {

  protected $_values;
  protected $_exceptionClass = '\SparkLib\ValidatorException';

  /**
   * Build a new Validator, optionally specifying an exception class to throw
   * on failure.  The exception class's constructor is expected to take an
   * array of failures, so if you need something besides the default
   * ValidatorException, it would be reasonable to extend that one.
   *
   * This is all around a pretty bad design, and will eventually be refactored
   * to remove the reliance on an exception for message-passing.
   *
   * @param $values array of key-value pairs to validate
   * @param $exceptionClass optional string name of exception class to pass 
   * failure array
   */
  public function __construct (array $values, $exceptionClass = null)
  {
    $this->_values = $values;

    if (isset($exceptionClass)) {
      $this->_exceptionClass = $exceptionClass;
    }
  }

  /**
   * Require parameters to be non-empty, and then check
   * them against provided filters.  A convenience wrapper around
   * expect() and filter().
   */
  public function expectFiltered (array $filters)
  {
    $failures = array();

    // first, did we get all the desired fields?
    try {
      $this->expect(array_keys($filters));
    } catch (Exception $e) {
      $missing = $e->getErrors();
    }

    // second, do they pass the provided filters?
    try {
      $this->filter($filters);
    } catch (Exception $e) {
      $invalid = $e->getErrors();
    }

    if (isset($missing)) {
      foreach ($missing as $field => $val)
        $failures[$field] = $val;
    }

    if (isset($invalid)) {
      foreach ($invalid as $field => $val)
        $failures[$field] = $val;
    }

    if ($failures) {
      $e_class = $this->_exceptionClass;
      throw new $e_class($failures);
    }
  }

  /**
   * Require request parameters to be non-empty(). For example, in a
   * Controller action:
   *
   *   $this->req()->expect('foo', 'bar');
   *
   * @param mixed... array or variable length list of parameters to expect
   * @throws \SparkLib\Application\RequestException
   */
  public function expect ()
  {
    $args = func_get_args();

    // DIRTY DIRTY HACK
    if (is_array($args[0]))
      $expectations = $args[0];
    else
      $expectations = $args;

    // Check everything in requires to make sure we have a value
    $failures = $this->checkParams($expectations, $this->_values);

    if (count($failures) > 0) {
      $e_class = $this->_exceptionClass;
      throw new $e_class($failures);
    }
  }

  private function checkParams ($expectation, $value)
  {
    $failures = [];

    if (is_array($expectation)) {
      foreach ($expectation as $key => $expected) {
        $check = is_array($expected) ? $key : $expected;
        $fail = $this->checkParams($expected, $value[$check]);
        $failures = array_merge($failures, $fail);
      }
    } else if (!is_array($value) && !strlen(trim($value))) {
      $failures[$expectation] = 'missing';
    }

    return $failures;
  }

  /**
   * Match request parameters against filters.
   *
   *   $filters = array(
   *     'foo' => 'FILTER_VALIDATE_INT',
   *     'bar' => '/^[a-z]+$/',
   *     'baz' => function ($value) {
   *       if ($value == 'barf') {
   *         return false;
   *       }
   *       return true;
   *     }
   *   );
   *   $this->req()->filter($filters);
   *
   * A filter may be the name of a filter constant, a / delimited
   * PCRE expression, or an anonymous function which takes one parameter
   * and returns true to pass or false to fail.
   *
   * Like expect(), this will throw a \SparkLib\Application\RequestException if something
   * doesn't match, because programmers suck at checking error conditions and
   * I'd rather make failures obvious. Wrap it in a catch block if you want to
   * handle things more gracefully than a "Something broke". RequestException
   * provides getErrors(), which returns the array of validation errors.
   *
   * See also: http://www.php.net/manual/en/filter.filters.validate.php
   *
   * @param array filters to check against specific parameters
   * @throws \SparkLib\Application\RequestException
   */
  public function filter (array $filters)
  {
    $failures = array();

    // Check every param in the request against any defined filters
    foreach ($filters as $param => $filter)
    {
      // If we weren't given a value, don't filter it.
      // (If you want to mandate that the value is set, use expect() or expectFiltered())
      // There is a special case here for the string '0', which empty() considers empty.
      // Let Lerdorf hope that I never encounter him in a dark alley.
      if (empty($this->_values[$param]) && ($this->_values[$param] !== '0')) {
        continue;
      }

      $errstring = 'invalid';
      if (is_array($filter)) {
        if (array_key_exists(1, $filter)) {
          $errstring = $filter[1];
        }
        $filter = $filter[0];
      }

      if (is_string($filter)) {

        if ($filter[0] === '/') // treat the filter as a regexp
        {
          // fail if no match:
          if (! preg_match($filter, $this->_values[$param]))
            $failures[$param] = $errstring;
        }
        // treat the filter as a builtin filter
        elseif (filter_var($this->_values[$param], constant($filter)) === FALSE)
        {
          $failures[$param] = $errstring;
        }

      } elseif (is_callable($filter)) {

        // treat the filter as a callback
        if (! $filter($this->_values[$param]))
          $failures[$param] = $errstring;

      }
    }

    if (count($failures) > 0) {
      $e_class = $this->_exceptionClass;
      throw new $e_class($failures);
    }
  }

}
