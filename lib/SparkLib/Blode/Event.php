<?php

/**
 * Event
 *
 * Send events to a blode daemon.  See also:
 *
 * https://github.com/benlemasurier/blode
 *
 * @author Ben LeMasurier <ben@sparkfun.com>
 * @author Brennen Bearnes <brennen@sparkfun.com>
 */

namespace SparkLib\Blode;

class Event {
  private static $_instance;

  // for PHP metadata about the current process
  public static $injectmeta = false;

  private static $_ip   = null;
  private static $_host = null;
  private static $_path = null;

  private $_url;
  private $_curl;
  private $_socket;
  private $_active = false;

  public function __construct() {
    $this->_active = (defined('BLODE_EVENTS') && (BLODE_EVENTS === true));
    $this->_url    = 'http://' . BLODE_SERVER . ':' . BLODE_HTTP_PORT;

    static::$_ip   = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    static::$_path = isset($_SERVER['PATH_INFO'])   ? $_SERVER['PATH_INFO']   : null;
    static::$_host = gethostname();

    if(BLODE_USE_UDP)
      $this->_init_socket();
    else
      $this->_init_curl();
  }

  public function __destruct() {
    if(!$this->_active)
      return;

    if(BLODE_USE_UDP)
      socket_close($this->_socket);
    else
      curl_close($this->_curl);
  }

  public static function getInstance() {
    if(!isset(self::$_instance))
      self::$_instance = new self();

    return self::$_instance;
  }

  public static function __callStatic($method, array $args) {
    $loglevel = $method;

    if (static::$injectmeta && is_array($args[0])) {
      // inject some useful metadata into the message, provided
      // it's already an id.
      if (isset(static::$_ip))   $args[0]['ip']   = static::$_ip;
      if (isset(static::$_path)) $args[0]['path'] = static::$_path;
      if (isset(static::$_host)) $args[0]['host'] = static::$_host;
    }

    static::getInstance()->write($args[0], $loglevel);
  }

  /**
   * Send a message to blode, optionally with a syslog-style severity.
   * The message should be a valid JSON string. You might want to
   * use writeJSON() for that and just hand it an array.
   *
   * @param $message string
   * @param $severity string name of syslog-style severity
   */
  public function write($message, $severity = 'debug') {
    if(!$this->_active)
      return;

    if(BLODE_USE_UDP)
      return $this->_write_udp($message, $severity);

    return $this->_write_http($message, $severity);
  }

  private function _write_udp($message, $severity) {
    $message = json_encode(Array('severity' => $severity, 'message' => $message));

    // write to the socket whether it's connected or not.
    socket_sendto($this->_socket, $message, strlen($message), 0, BLODE_SERVER, BLODE_UDP_PORT);

    return true;
  }

  private function _write_http($message, $severity) {
    // Handle structured messages by turning them into JSON:
    if(is_array($message))
      $message = json_encode($message);

    $message = urlencode($message);
    $get = "?severity=$severity&message=$message";
    curl_setopt($this->_curl, CURLOPT_URL, $this->_url . $get);
    return curl_exec($this->_curl);
  }

  private function _init_socket() {
    if(!$this->_active)
      return;

    $this->_socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_set_nonblock($this->_socket);
  }

  private function _init_curl() {
    if(!$this->_active)
      return;

    $this->_curl = curl_init();
    curl_setopt($this->_curl, CURLOPT_HEADER, 0);
    curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($this->_curl, CURLOPT_FOLLOWLOCATION, 1);

    return;
  }
}
