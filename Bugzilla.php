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
   * @param $params array of search fields => values
   * @return array of stdClass bug objects for given search
   * @return false if search failed altogether (I think)
   */
  public function search (array $params)
  {
    $client = new Client($this->_uri . 'jsonrpc.cgi');
    try {
      $result = ($client->__call('Bug.search', array($params)));
    } catch (\Exception $e) {
      Fail::log($e);
      return false;
    }

    $bugs = array();
    for($i = 0, $c = count($result['bugs']); $i < $c; ++$i) {
      $bugs[] = (object)$result['bugs'][$i];
    }

    return $bugs;
  }

  /**
   * Search for a substring in a custom field. Returns an array of simple
   * bug objects extracted from CSV. (XML can suck it.)
   */
  public function searchCustomField($field, $string)
  {
    $search_url = 'buglist.cgi?query_format=advanced&f1=cf_'
                . urlencode($field)
                . '&v1='
                . urlencode($string)
                . '&o1=substring&order=Bug&ctype=csv';

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

  public function searchCC ($user)
  {
    $search_url = 'buglist.cgi?query_format=advanced&emailcc1=1'
                . '&email1=' . urlencode($user)
                . '&emailtype1=substring&order=Bug&ctype=csv';

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
