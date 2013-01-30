<?php
namespace Spark;

use \SparkLib\Fail,
    \DOMDocument,
    \DOMElement;


/* because DOMDocument sucks */
class XmlBuilder {
  private $domdoc;
  private $namespace = '';
  private $namespace_url = '';

  private $last_node = false;

  public function __construct(){
    $this->domdoc = new DOMDocument();
  }

  public function _attribs( $attributes ){
    foreach ($attributes as $name => $value)
      $this->_last_node()->setAttribute($name, $value);

    return $this;
  }

  public function _child(){
    $x = new static;
    $x->_namespace($this->namespace, $this->namespace_url);
    return $x;
  }

  public function _children( $document ){
    if ($document == null)
      return $this;

    $node = $this->_last_node();

    if ($document instanceof DOMDocument)
      $kids = $document;
    elseif ($document instanceof static)
      $kids = $document->domdoc;
    else
      throw new InvalidArgumentException(' _children only knows how to import children from a DOMDocument or a Spark\XmlBuilder.');

    if (count($kids) == 0)
      return $this;

    foreach ($kids->childNodes as $kid) {
      $node->appendChild(
        $this->domdoc->importNode($kid, true)
      );
    }

    return $this;
  }

  public function _last_node(){
    $node = $this->last_node;

    if ($node === false)
      throw new \LogicException('Unable to set attributes for nonexistant previous node');

    return $node;
  }

  public function _namespace($namespace, $url){
    $this->namespace = $namespace;
    $this->namespace_url = $url;
    return $this;
  }

  public function _node($name, $value = '', $attributes = array(), $children = null){
    if (strlen($this->namespace) > 0)
      $node = new DOMElement("{$this->namespace}:{$name}", '', $this->namespace_url);
    else
      $node = new DOMElement($name);

    $node->nodeValue = $value;
    $this->last_node = $node;

    $this->domdoc->appendChild($node);

    $this->_attribs($attributes);
    $this->_children($children);

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
    if ($first instanceof static || $first instanceof DOMDocument)
      $this->_node($name, '', array(), $first->domdoc);
    else
      $this->_node($name, $first);
    return $this;
  }

  public function _domdoc(){
    return $this->domdoc;
  }

  public function _string($html = false){
    if ($html)
      return $this->domdoc->saveHTML();
    else
      return $this->domdoc->saveXML();
  }

  public function _print( $html = false ){
    print $this->_string($html);
  }
}
