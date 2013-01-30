<?php
namespace Spark;

use \SparkLib\Fail,
    \DOMDocument,
    \DOMElement;


/** because DOMDocument sucks
 *
 * XmlBuilder is a wrapper for DOMDocument's creation interface.
 *
 * When using php's DOM library you are required to manually create a
 * series of DOMInterface and DOMDocument and DOMAttribute and and and
 * and and ...
 *
 * With Spark\XmlBuilder, you can instead just build out a series of
 * nested nodes using a simplified method chaining syntax similar to
 * XML builder clasess available elsewhere.
 *
 * Spark\XmlBuilder uses a subset of php's DOM functions so that
 * the restrictions imposed by standard practice aren't enforced by
 * the builder or DOM class.
 *
 * General usage:
 *    $b = new \Spark\XmlBuilder();
 *
 *    - Create elements using the object operator:
 *      $b->Name('Rob')
 *        ->Age('34')
 *        ->Weight('185')
 *
 *      to produce:
 *        <Name>Rob</Name>
 *        <Age>34</Age>
 *        <Weight>185</Weight>
 *
 *    - Add attributes to previous node using ->_attribs :
 *      $b->Person
 *        ->_attribs( array(
 *          'age' => 34,
 *          'weight' => 185,
 *        ))
 *
 *      to produce:
 *        <Person age="34" weight="185"></Person>
 *
 *    - Build out an independent or nested set of nodes using ->_child()
 *      and add them as children of a node :
 *      $people = $b->_child();
 *      foreach (array('Rob','Casey','Brennen','Dave') as $name)
 *        $people->$name;
 *      $b->People($people);
 *
 *      to produce[1]:
 *        <People>
 *          <Rob></Rob>
 *          <Casey></Casey>
 *          <Brennen></Brennen>
 *          <Dave></Dave>
 *        </People>
 *
 *    - Add children to previous node using ->_children :
 *      $b->People;
 *      foreach (array('Rob','Casey','Brennen','Dave') as $name)
 *        $b->_children( $b->_child()->$name );
 *
 *      to produce:
 *        <People>
 *          <Rob></Rob>
 *          <Casey></Casey>
 *          <Brennen></Brennen>
 *          <Dave></Dave>
 *        </People>
 *
 *    - Fetch a string representation of the document :
 *      print $b->People->Places->Things->_string( $want_html );
 *
 *    - Fetch the DOMDocument object for beating with hammers :
 *      $b->Youll->Hate->Yourself->_domodc();
 *
 *
 * Notes:
 * 1: Thankfully, DOMDocument doesn't know how to create singleton tags,
 *    so it just creates empty tag pairs: <br></br>.  D:
 */

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
