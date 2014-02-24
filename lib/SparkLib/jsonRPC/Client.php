<?php
namespace SparkLib\jsonRPC;

use \SparkLib\Fail;
use \Exception;

/*
          COPYRIGHT

Copyright 2007 Sergio Vaccaro <sergio@inservibile.org>

This file is part of JSON-RPC PHP.

JSON-RPC PHP is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

JSON-RPC PHP is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with JSON-RPC PHP; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * This is a fork of Sergio Vaccaro's jsonRPC client code from
 *
 * http://jsonrpcphp.org/
 *
 * It's been tweaked slightly to support SparkFun's use case (talking
 * to the Bugzilla API), and now throws Exceptions on timeouts.
 *
 * Objects of this class are generic jsonRPC 1.0 clients
 * http://json-rpc.org/wiki/specification
 *
 * @author sergio <jsonrpcphp@inservibile.org>
 * @author Brennen Bearnes <brennen@sparkfun.com>
 */
class Client {

  /**
   * Debug state
   *
   * @var boolean
   */
  protected $debug;

  /**
   * The server URL
   *
   * @var string
   */
  protected $url;

  /**
   * The request id
   *
   * @var integer
   */
  protected $id;

  /**
   * If true, notifications are performed instead of requests
   *
   * @var boolean
   */
  protected $notification = false;

  /**
   * How many seconds before an exception is thrown for a timeout?
   *
   * @var integer
   */
  protected $timeout = 10;

  /**
   * Takes the connection parameters
   *
   * @param string $url
   * @param boolean $debug
   */
  public function __construct($url, $debug = false) {
    // server URL
    $this->url = $url;

    // proxy
    empty($proxy) ? $this->proxy = '' : $this->proxy = $proxy;

    // debug?
    $this->debug = $debug;

    // message id
    $this->id = 1;
  }

  /**
   * Sets the notification state of the object. In this state, notifications are performed, instead of requests.
   *
   * @param boolean $notification
   */
  public function setRPCNotification($notification) {
    empty($notification) ? $this->notification = false
                         : $this->notification = true;
  }

  /**
   * Set a timeout for connections, in seconds. Defaults to 10.
   */
  public function setTimeout($timeout) {
    $this->timeout = $timeout;
  }

  /**
   * Performs a jsonRCP request and gets the results as an array
   *
   * @param string $method
   * @param array $params
   * @return array
   */
  public function __call($method, $params) {

    // check
    if (! is_scalar($method)) {
      throw new Exception('Method name has no scalar value');
    }

    // check
    if (is_array($params)) {
      // no keys
      // TODO: this bit strikes me as broken:
      // $params = array_values($params);
    } else {
      throw new Exception('Params must be given as array');
    }

    // sets notification or request task
    if ($this->notification) {
      $currentId = null;
    } else {
      $currentId = $this->id;
    }

    // prepares the request
    $request = array(
      'method' => $method,
      'params' => $params,
      'id'     => $currentId
    );
    $request = json_encode($request);
    $this->debug && Fail::log('***** Request *****'."\n".$request."\n".'***** End Of request *****'."\n\n");

    // performs the HTTP POST
    $opts = array (
      'http' => array (
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $request
      )
    );
    $context = stream_context_create($opts);
    if ($fp = fopen($this->url, 'r', false, $context)) {
      stream_set_timeout($fp, $this->timeout);
      $response = '';
      while($row = fgets($fp)) {
        $stream_info = stream_get_meta_data($fp);
        if ($stream_info['timed_out']) {
          throw new Exception('timed out reading from server');
        }
        $response.= trim($row)."\n";
      }
      $this->debug && Fail::log('***** Server response *****'."\n".$response.'***** End of server response *****'."\n");
      $response = json_decode($response, true);
    } else {
      throw new Exception('Unable to connect to ' . $this->url);
    }

    // final checks and return
    if (!$this->notification) {
      // check
      if ($response['id'] != $currentId) {
        throw new Exception('Incorrect response id (request id: ' . $currentId . ', response id: ' . $response['id'].')');
      }
      if (! is_null($response['error'])) {
        throw new Exception('Request error: ' . print_r($response['error'], 1));
      }

      return $response['result'];

    } else {
      return true;
    }
  }
}
