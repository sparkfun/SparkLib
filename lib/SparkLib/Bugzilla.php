<?php
namespace SparkLib;

use SparkLib\Fail;
use SparkLib\jsonRPC\Client;

/**
 * Wrap various API calls to a Bugzilla installation.
 */
class Bugzilla {

  protected $_uri    = null;

  // TODO
  protected $_user   = null;
  protected $_passwd = null;

  /**
   * Get an instance of Bugzilla for the given installation URI.
   */
  public function __construct ($uri)
  {
    $this->_uri = $uri;
  }

  /**
   * Return an object representing a single bug.
   *
   * @param $id integer bug id
   * @return stdClass bug for given id
   * @return false if no such bug found
   */
  public function bug ($id)
  {
    $client = new Client($this->_uri . 'jsonrpc.cgi');

    try {
      $result = $client->__call('Bug.get', array(array('ids' => array($id))));
    } catch (\Exception $e) {
      Fail::log($e);
      return false;
    }

    // send back a stdClass for the first bug in the results
    return (object)($result['bugs'][0]);
  }

  /**
   * Return an array of objects representing search results.
   *
   * See: http://www.bugzilla.org/docs/4.2/en/html/api/Bugzilla/WebService/Bug.html#search
   *
   * @param array $params search fields => values
   * @return array of stdClass bug objects for given search
   * @return boolean false if search failed altogether (I think)
   */
  public function search (array $params, $return_count_only = false)
  {
    $client = new Client($this->_uri . 'jsonrpc.cgi');
    try {
      $result = ($client->__call('Bug.search', array($params)));
    } catch (\Exception $e) {
      Fail::log($e);
      return false;
    }

    if ($return_count_only)
      return count($result['bugs']);

    $bugs = array();
    for($i = 0, $c = count($result['bugs']); $i < $c; ++$i) {
      $bugs[] = (object)$result['bugs'][$i];
    }

    return $bugs;
  }

  /**
   * Sort and return an array of objects representing search results.
   *
   * Usage: Bugzilla::sortBugs($bugs, 'priority', SORT_ASC, 'last_change_time', SORT_DESC);
   * ...where $bugs is an array of stdClass objects representing bugs (e.g. the output of Bugzilla->search())
   *
   * @return array of stdClass bug objects for given search
   */
  public static function sortBugs ()
  {

    // Pull unsorted bug array off the front of the argument list
    $args = func_get_args();
    $bugs = array_shift($args);

    // Trivial case: kick back out if there are no bugs to sort
    if (! count($bugs))
      return $bugs;

    // Build the sort arrays!
    //
    // We start with an unsorted array ($bugs) and an alternating list of fields and directions (priority, SORT_ASC...)
    // For array_multisort we want a single array of arguments that looks like this:
    //
    // [ [Bug 0 field 0 value, Bug 1 field 0 value, ...], direction 0, [Bug 0 field 1 value, Bug 1 field 1 value, ...], direction 1, ... ]
    //
    // We do this in place by walking our array of arguments (which is already in the right order)
    // and turning each field name string into its corresponding array of field values from the unsorted bug list
    foreach ($args as $n => $field) {
      if (is_string($field)) {
        if (!strlen($field) || !isset($bugs[0]->$field))
          throw new Exception ("Invalid sort field: " . $field);
        $tmp = array();
        foreach ($bugs as $b => $bug)
          $tmp[$b] = $bug->$field;
        $args[$n] = $tmp;
      }
    }

    // Attach the unsorted bug list by reference onto the end of our arguments array.
    // array_multisort sorts arguments in order, so the last argument needs to be the master unserted list.
    // It also sorts arguments in place, hence why they must be passed by reference.
    $args[] = &$bugs;
    call_user_func_array('array_multisort', $args);

    return array_pop($args);

  }

  /**
   * Search for a substring in a custom field. Returns an array of simple
   * bug objects extracted from CSV. (XML can suck it.)
   *
   * @param string $field to search
   * @param string $string to search for
   * @return array of stdClass bug objects
   */
  public function searchCustomField ($field, $string, $new_only = false)
  {
    $search_url = 'buglist.cgi?query_format=advanced&f1=cf_'
                . urlencode($field)
                . '&v1='
                . urlencode($string)
                . '&o1=substring&order=Bug&ctype=csv';

    if ($new_only) {
      $search_url .= '&bug_status=NEW&bug_status=ASSIGNED&bug_status=REOPENED';
    }

    $csv  = file_get_contents($this->_uri . $search_url);

    $bugs = array();

    $rows = explode("\n", $csv);
    $fields = str_getcsv(array_shift($rows));
    foreach ($rows as &$row) {
      $values = str_getcsv($row);
      $bug = array();
      foreach ($values as $idx => $value) {
        $bug[ $fields[$idx] ] = $value;
      }
      $bugs[] = (object)$bug; // make a stdClass instance
    }

    return $bugs;
  }

  /**
   * Return a list of open bugs CC'd to a user.
   *
   * @param string $user
   * @return array of stdClass bug objects
   */
  public function searchCC ($user)
  {
    $search_url = 'buglist.cgi?query_format=advanced&emailcc1=1'
                . '&email1=' . urlencode($user)
                . '&emailtype1=substring&order=Bug&ctype=csv'
                . '&bug_status=UNCONFIRMED&bug_status=NEW&bug_status=ASSIGNED&bug_status=REOPENED';

    $csv  = file_get_contents($this->_uri . $search_url);

    $bugs = array();

    $rows = explode("\n", $csv);
    $fields = str_getcsv(array_shift($rows));
    foreach ($rows as &$row) {
      $values = str_getcsv($row);
      $bug = array();
      foreach ($values as $idx => $value) {
        $bug[ $fields[$idx] ] = $value;
      }
      $bugs[] = (object)$bug; // make a stdClass instance
    }

    return $bugs;
  }

}
