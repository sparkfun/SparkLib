<?php
namespace Spark;

use \SparkLib\Fail;

/* because DOMDocument sucks */
class XmlBuilder {
  public $document = array();
  public $namespace = '';

  public function _attribs( $attributes ){
    $this->_last_node()->attributes = $attributes;

    return $this;
  }

  public function _child(){
    $x = new static;
    $x->_namespace($this->namespace);
    return $x;
  }

  public function _children( $kids ){
    $node = $this->_last_node();
    foreach ($kids->document as $child_node)
      $node->children[] = $child_node;
  }

  public function _last_node(){
    $node = end($this->document);

    if ($node === false)
      throw new \LogicException('Unable to set attributes for nonexistant previous node');

    return $node;
  }

  public function _namespace($namespace){
    $this->namespace = $namespace;
    return $this;
  }

  public function _node($name, $value = '', $attributes = array(), $children = array()){
    if (strlen($this->namespace) > 0)
      $name = "{$this->namespace}:{$name}";

    $this->document[] = new XmlNode($name, $value, $attributes, $children);
    return $this;
  }

  public function __get($name){
    $this->_node($name);
    return $this;
  }

  public function __call($name, $arguments){
    if (count($arguments) <= 0) {
      $this->_node($name);
      return $this;
    }

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
