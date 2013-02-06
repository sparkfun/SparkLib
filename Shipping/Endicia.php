<?php

namespace Spark\Shipper;

use SparkLib\Xml\Builder as Builder;

class Endicia {
  public $base_url;
  public $requester_id;
  public $account_number;
  public $password;
  public $test;

  public $request_type, $post_prefix, $xml, $response;

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

  protected function request() {
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
}
