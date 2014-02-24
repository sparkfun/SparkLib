<?php
namespace SparkLib\Application\ControllerRole;

trait AjaxHandler {
  private function handleAjax() {
    if ($this->req()->isXHR()) {
      $this->setLayout('ajax_tab');
    }
  }
}
