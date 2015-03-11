<?php

namespace SparkLib;

class JSON {
  public $data;

  public function __construct($json = null) {
    if ($json === null || !strlen($json)) {
      $this->data = [];
    } else {
      $this->data = json_decode($json, true);
    }
  }

  public function encode() {
    $strJson = json_encode(self::clean($this->data));
    return $strJson;
  }

  private static function clean($data) {
    if (is_array($data)) {
      foreach($data as $k=>$v) {
        $data[$k] = self::clean($data[$k]);
        if ($data[$k] == null || empty($data[$k])) {
          unset($data[$k]); continue;
        }
      }
    }
    return $data;
  }
}
