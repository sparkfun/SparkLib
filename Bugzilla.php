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
   */
  public function bug ($id)
  {
    $options = array('prefix' => 'Bug.');

    $client = \XML_RPC2_Client::create($this->_uri, $options);
    $result = $client->get(
      array('ids' => array($id)
    ));

    // send back a stdClass for the first bug in the results
    return (object)($result['bugs'][0]);
  }

  /**
   * Return an array of objects representing search results.
   *
   * See: http://www.bugzilla.org/docs/4.2/en/html/api/Bugzilla/WebService/Bug.html#search
   *
   * @param $params array of search fields => values
   */
  public function search (array $params)
  {
    $options = array('prefix' => 'Bug.');
    $client = \XML_RPC2_Client::create($this->_uri, $options);
    $result = $client->search($params);

    $bugs = array();
    foreach ($result['bugs'] as $bug) {
      $bugs[] = (object)$bug;
    }
    return $bugs;
  }

}
