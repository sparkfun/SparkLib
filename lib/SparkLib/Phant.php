<?php
namespace SparkLib;

/**
 * An interface to Phant instances.
 */
class Phant {

  protected $_endpoint = 'http://data.sparkfun.com';
  protected $_pubhash;
  protected $_privhash;

  public function __construct ($endpoint, $pubhash, $privhash)
  {
    $this->_endpoint = $endpoint;
    $this->_pubhash  = $pubhash;
    $this->_privhash = $privhash;
  }

  /**
   * Write data to a stream for which we know the private hash.
   */
  public function input (array $data)
  {
    $data['private_key'] = $this->_privhash;
    $postbody = http_build_query($data);

    $headers = [
      "Content-type: application/x-www-form-urlencoded",
    ];

    $opts = [
      'http' => [
        'method'  => 'POST',
        'header'  => $headers,
        'content' => $postbody
      ]
    ];

    $url = $this->_endpoint . '/input/' . $this->_pubhash . '.txt';

    $context = stream_context_create($opts);

    return file_get_contents($url, false, $context);
  }

  /**
   * Get current stats for the stream.
   */
  public function stats ()
  {
    $opts = [
      'http' => [
        'method'  => 'GET',
      ]
    ];

    $url = $this->_endpoint . '/output/' . $this->_pubhash . '/stats';

    $context = stream_context_create($opts);

    return json_decode(file_get_contents($url, false, $context));
  }

  /**
   * Return stream data.
   */
  public function data ()
  {
    $opts = [
      'http' => [
        'method'  => 'GET',
      ]
    ];

    $url = $this->_endpoint . '/output/' . $this->_pubhash . '.json';

    $context = stream_context_create($opts);

    return json_decode(file_get_contents($url, false, $context));
  }

}
