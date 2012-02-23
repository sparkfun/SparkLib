<?php
namespace SparkLib;
use SparkLib\Fail;
use \stdClass;

// TODO: autoload this
require_once 'XML/RPC2/Client.php';

/**
 * Wrap some XML-RPC calls to a Bugzilla installation.
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
    $options = array('prefix' => 'Bug.');

    $client = \XML_RPC2_Client::create($this->_uri, $options);

    try {
      $result = $client->get(
        array('ids' => array($id)
      ));
    } catch (\XML_RPC2_FaultException $e) {
      Fail::log('bug not found: ' . $e->getFaultCode() . ' ' . $e->getFaultString());
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
    $options = array('prefix' => 'Bug.');
    $client = \XML_RPC2_Client::create($this->_uri, $options);

    try {
      $result = $client->search($params);
    } catch (\XML_RPC2_FaultException $e) {
      Fail::log('search failed: ' . $e->getFaultCode() . ' ' . $e->getFaultString());
      return false;
    }

    $bugs = array();
    foreach ($result['bugs'] as $bug) {
      $bugs[] = (object)$bug;
    }
    return $bugs;
  }

}
