<?php
namespace SparkLib;
use SparkLib\Fail;
use \jsonRPCClient;

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
    $client = new jsonRPCClient($this->_uri . 'jsonrpc.cgi');

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
    $client = new jsonRPCClient($this->_uri . 'jsonrpc.cgi');
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
   * Search for a substring in a custom field. Returns, lame as this is,
   * an array of SimpleXML objects from the Atom version of a search result.
   */
  public function searchCustomField($field, $string)
  {
    $search_url = 'buglist.cgi?query_format=advanced&f1=cf_'
                . urlencode($field)
                . '&v1='
                . urlencode($string)
                . '&o1=substring&ctype=atom';

    $atom = \file_get_contents($this->_uri . $search_url);
    $result = \simplexml_load_string($atom);
    $bugs = array();

    foreach ($result->entry as $bug) {
      $bugs[] = $bug;
    }

    return $bugs;
  }

}
