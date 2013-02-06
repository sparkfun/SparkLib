<?php
namespace SparkLib\Xml;

use \DOMDocument, \DOMNode, \DOMElement, \DOMNodeList, \DOMXPath;

use \SimpleXMLElement;

class Crack {
  public $domdoc;
  public $sxml;

  public static function parse($xml_string, $html = false){
    $that = new static();
    $that->load($xml_string, $html);
    return $that;
  }

  public function __construct(){
    $this->domdoc = new DOMDocument();
  }

  public function load($xml_string, $html = false){
    libxml_use_internal_errors(true);
    $this->sxml = simplexml_load_string( $xml_string );
  }

  public function fetch(/* $key, $key, $key, ... $key, $key */){
    $keys = func_get_args();

    $elem = $this->sxml;
    foreach($keys as $key){
      $elem = $elem->$key;

      if ($elem === null)
        return null;
    }

    return $elem;
  }

  private function to_array( $object ){
    $casted = array();

    if ($object instanceof DOMDocument) {
      return $this->to_array( $object->childNodes );

    } elseif ($object instanceof DOMNodeList) {

      if ($object->length == 1 && $this->has_only_text_child($object) )
        return $this->fetch_text_value($object);

      foreach ($object as $node) {
        if ($node->hasChildren())
          $casted[ $node->nodeName ] = $this->to_array( $node->childNodes );
        else
          $casted[] = $node->nodeName;
      }

      return $casted;
    }

    print "to_array: uncastable element: " . get_class($object) . "\n";
    return $casted;
  }

  private function has_only_text_child( $node ){
    if ($node instanceof DOMNode) {

      if ($node->nodeType === \XML_TEXT_NODE) {
        return true;
      } else {
        return $node->childNodes->length == 1 && $node->childNodes->item(0)->nodeType == \XML_TEXT_NODE;
      }

    } elseif ($node instanceof DOMNodeList) {
      return $node->length == 1 && $this->has_only_text_child( $node->item(0) );
    }

    print "not domnode: " . get_class( $node ) . "\n";

    return false;
  }

  private function fetch_text_value( $node ){
    if ($node instanceof DOMNode) {
      if ($node->nodeType === \XML_TEXT_NODE)
        return $node->nodeValue;
      else
        return $node->childNodes->item(0)->nodeValue;
    } elseif ($node instanceof DOMNodeList) {
      return $this->fetch_text_value($node->item(0));
    } else
      return null;
  }
}
