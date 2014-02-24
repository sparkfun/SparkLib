<?php
namespace SparkLib;

class HTML {
  /**
   * spit out an HTML tag
   *
   * takes a tag name, an array of attribute name/values, and an
   * optional body.
   *
   * if an attribute value is a literal true instead of a string,
   * just the attribute name will be inserted. this probably isn't
   * valid XHTML, but i think it's valid HTML5
   *
   * @param string tag name
   * @param array attribute name/value pairs
   * @param string contents of the tag
   */
  protected function makeTag ($tagname, array $attributes, $contents = null)
  {
    $close = ($contents === null) ? true : false;
    $html = $this->startTag($tagname, $attributes, $close);

    // if we got something to put inside, wrap it up
    // otherwise put it in a self-closing tag
    // n.b., this is potentially flawed for <script>
    if ($close)
      return $html;
    else
      return $html . $contents . "</{$tagname}>";
  }

  /**
   * Make a start tag, optionally self-closing.
   */
  protected function startTag ($tagname, array $attributes = array(), $close = false)
  {
     // open the tag
    $html = '<' . $tagname;

    // handle attributes
    foreach ($attributes as $a => $v) {
      if     ($v === null) continue;              // nothing
      elseif ($v === true) $html .= ' ' . $a;     // bare attribute, no value
      else                 $html .= ' ' . $a . '="' . htmlspecialchars($v) . '"'; // attribute="value"
    }

    if ($close)
      return $html . ' />';
    else
      return $html . '>';
  }

}
