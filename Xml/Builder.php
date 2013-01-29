<?php
namespace Spark;

use \SparkLib\Fail;

/* because DOMDocument sucks */
class XmlBuilder {
  public $document = array();

  public function _child(){
    return new static;
  }

  public function _attribs( $attributes ){
    $node = end($this->document);
    $node->attributes = $attributes;

    return $this;
  }

  public function _node($name, $value = '', $attributes = array(), $children = array()){
    $this->document[] = new XmlNode($name, $value, $attributes, $children);
    return $this;
  }

  public function __get($name){
    $this->_node($name);
    return $this;
  }

  public function __call($name, $arguments){
    $first = $arguments[0];
    if ($first instanceof static)
      $this->_node($name, '', array(), $first->document);
    else
      $this->_node($name, $first);
    return $this;
  }

  public function _print(){
    foreach ($this->document as $node)
      print $node;
  }
}

class XmlNode {
  public $name;
  public $value;
  public $attributes;
  public $children;

  public function __construct($name, $value = '', $attributes = array(), $children = array()){
    $this->name = $name;
    $this->value = $value;
    $this->attributes = $attributes;
    $this->children = $children;
  }

  public function __toString(){
    $quick_end = true;

    $s = "<{$this->name}";
    $guts = '';

    foreach ($this->attributes as $k => $v)
      $s .= " {$k}=\"{$v}\"";

    if ( $this->value !== '' ) {
      $quick_end = false;
      $guts .= $this->value;
    }

    if (count($this->children) > 0) {
      $quick_end = false;

      foreach ($this->children as $child)
        $guts .= $child->__toString();
    }

    if ($quick_end) {
      $s .= " />";
    } else {
      $s .= ">{$guts}</{$this->name}>";
    }

    return $s;
  }
}
