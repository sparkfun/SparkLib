<?php
namespace SparkLib;

use mikehaertl\wkhtmlto\Pdf as webkitPDF;

class PDF {

  protected $_pdf;

  function __construct () {
    if (! class_exists('mikehaertl\wkhtmlto\Pdf'))
      throw new \Exception('mikehaertl\wkhtmlto\Pdf appears to be unavailable.');

    $this->_pdf = new webkitPDF([
      'footer-center' => 'Page [page] of [toPage]',
      'page-size' => 'letter',
    ]);
  }

  function __call($name, $args) {
    return call_user_func_array([$this->_pdf, $name], $args);
  }

  function loadHtml($html) {
    return $this->_pdf->addPage($html);
  }

  function render() {
    //nop
  }

  function stream() {
    return $this->_pdf->send();
  }

  function output() {
    return $this->_pdf->toString();
  }

}
