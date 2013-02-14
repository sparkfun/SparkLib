<?php

namespace SparkLib\Shipping;

use SparkLib\Xml\Builder as Builder;

class Endicia {
  public $base_url;
  public $requester_id;
  public $account_number;
  public $password;
  public $test;

  public $request_type, $post_prefix, $xml;
  public $valid_response, $message, $response, $sxml;

  public $curl_info;

  public function __construct($test_mode = false){
    $this->test = $test_mode;
    $this->base_url = \ENDICIA_LABEL_SERVER;
    $this->requester_id = \ENDICIA_REQUESTER_ID;
    $this->account_number = \ENDICIA_ACCOUNT_NUMBER;
    $this->password = \ENDICIA_PASSWORD;

    $this->test = true;
    $this->base_url = "https://www.envmgr.com/LabelService/EwsLabelService.asmx/";
    $this->requester_id = \ENDICIA_REQUESTER_ID;
    $this->account_number = \ENDICIA_ACCOUNT_NUMBER;
    $this->password = \ENDICIA_PASSWORD;
  }

  public function request() {
    $url = $this->base_url . $this->request_type;

    $post_body = $this->post_prefix . "=" . $this->xml;
    $length = strlen($post_body);

    $headers = array('Content-Type: application/x-www-form-urlencoded');

    $ch = curl_init();
    curl_setopt($ch, \CURLOPT_URL, $url);
    curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, \CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, \CURLOPT_POST, true);

    curl_setopt($ch, \CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, \CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, \CURLOPT_TIMEOUT, 10);

    $this->response  = curl_exec($ch);
    $this->curl_info = curl_getinfo($ch);

    curl_close($ch);
    return $this->response;
  }

  public function parse_response(){
    if ($this->response === null)
      throw new \LogicException('Cannot parse, no valid response.');

    if ($this->curl_info === null)
      throw new \LogicException('Cannot check curl status, no valid info hash.');

    if ( $this->curl_info['http_code'] !== 200 ) {
      $this->valid_response  = false;
      $this->message = "HTTP status was {$this->curl_info['http_code']}, expected 200";
      throw new \RuntimeException( $this->message );
      return false;
    }

    libxml_use_internal_errors(true);
    $this->sxml = simplexml_load_string( $this->response );

    // TODO: parse out sxml errors
    $this->valid_response = true;

    return true;
  }

  public function check_status(){
    if ($this->sxml === null)
      throw new \LogicException("Cannot check response status without a parsed response");
    if ( ! $this->valid_response)
      throw new \LogicException("Cannot check response status for invalid response. Status message: {$this->message}.");

    $status = $this->sxml->Status;
    $message = $this->sxml->ErrorMessage;

    if ($status == NULL) {
      $this->valid_response = false;
      $this->message = "Could not retrieve request status from response document.";
      return false;
    }

    if ($status != 0) {
      $this->valid_response = false;
      $this->message = "Endicia returned error: $message";
      throw new \RuntimeException( $this->message );
      return false;
    }

    return true;
  }

  protected function authXML( $b ){
    return
      $b->child()
        ->RequesterID( $this->requester_id )
        ->RequestID('12345')
        ->CertifiedIntermediary(
            $b->child()
              ->AccountID( $this->account_number )
              ->PassPhrase( $this->password )
        );

  }
}
