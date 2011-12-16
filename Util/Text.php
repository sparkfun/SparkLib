<?php
namespace SparkLib\Util;

/**
 * A place to hang little text utility functions. It's only a class so the
 * autoloader can pick it up. Use like:
 *
 * <code>
 *   use \Spark\Text;
 *   $foo = Text::asciify($bar);
 * </code>
 */
class Text {

  /**
   * Transliterate a string in a given source character set to the nearest
   * ASCII equivalent (according to iconv()).
   *
   * @param $text string to convert
   * @param $source_charset string name of source character set
   * @return string
   */
  public static function asciify ($text, $source_charset = 'ISO-8859-1')
  {
    return \iconv($source_charset, "ASCII//TRANSLIT//IGNORE", $text);
  }

  /**
   * Produce an ASCII string acceptable (hopefully) to things like the FedEx
   * and Endicia APIs.
   *
   * @param $str string to clean
   * @return string
   */
  public static function clean_str ($str)
  {
    // manually specify some
    $trans = array("&" => "and",
                   "'" => "");

    $str = trim(strtr($str, $trans));

    return Text::asciify($str);
  }

  public static function truncate ($str, $len = 25, $pad = 0)
  {
    if(strlen($str) > $len - $pad)
      $ret = substr($str, 0, $len) . '&hellip;';
    else
      $ret = $str;
    return $ret;
  }

  public static function truncateWithTitle ($str, $len = 25, $pad = 0)
  {
    if(strlen($str) > $len - $pad)
      $ret = '<span title="' . htmlentities($str) . '">' . substr($str, 0, $len) . '&hellip;</span>';
    else
      $ret = $str;
    return $ret;
  }

  public static function truncateToWord ($str, $len = 25)
  {
    if (strlen($str) > $len) {
      $ret = wordwrap($str, $len);
      $ret = substr($ret, 0, strpos($ret, "\n"));
      $ret .= '&hellip;';
    } else
      $ret = $str;
    return $ret;
  }


  /*
   *  The implications of not doing this pluralization sub-engine correctly
   *  kind of terrify me.  No really.  Think about the word 'Media'.  What is
   *  the plural of that!? Dammit English...what the crap.
   *
   *  Trick question! 'Media' like 'data' is commonly misunderstood plural.
   *  We don't want no datas.
   *
   *  Hint: the singulars are 'Medium' and 'Datum'.
   *
   *  Cases I can think of off the top of my head:
   *  Batch -> Batches
   *  Media -> Medium
   *  Category -> Categories
   *  Deer -> Deer
   *  Saurus -> Saurii
   *
   */
  public static function depluralize($word)
  {
    return rtrim($word, 's');
  }

  public static function pluralize($word)
  {
    // mmmm...inflector...want...
    if (substr($word,-1)==='s')
      return $word;
    return $word . 's';
   }

  // assumes we're coming from camelcase'd notation
  public static function underscore($string)
  {
    // yay php...
    $matches = null;
    preg_match_all('/[A-Z][^A-Z]*/',$string,$matches);
    $parts = array_map(function($s){return strtolower($s);},$matches[0]);
    return implode('_',$parts);
  }

  // assumes we're coming from underscored notation
  public static function camelcase($string)
  {
    $parts = explode('_', $string);
    foreach ($parts as &$part)
      $part = ucfirst($part);
    return implode ('', $parts);
  }

}
