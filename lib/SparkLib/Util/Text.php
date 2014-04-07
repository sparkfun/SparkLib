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
   * TODO: IGNORE may fail on versions of PHP > 5.4
   *       http://www.php.net/manual/en/function.iconv.php
   *       https://bugs.php.net/bug.php?id=61484
   *
   * @param $text string to convert
   * @param $source_charset string name of source character set
   * @return string
   */
  public static function asciify ($text, $source_charset = 'UTF-8')
  {
    $encoding = mb_detect_encoding($text);
    if (! $encoding)
      $encoding = $source_charset;

    // LC_CTYPE cannot be C or POSIX
    // http://us3.php.net/manual/en/function.iconv.php#74101
    setlocale(LC_CTYPE, 'en_US');
    return \iconv($encoding, "ASCII//TRANSLIT//IGNORE", $text);
  }

  public static function UPSCrapToWorkingZPL ($text)
  {
    //return \iconv('UTF-8', "CP850//TRANSLIT", $text);
    return \iconv('UTF-8', "ISO-8859-1//TRANSLIT", $text);
  }

  /**
   * Produce an ASCII string acceptable (hopefully) to things like the FedEx
   * and Endicia APIs.
   *
   * @param $str string to clean
   * @return string
   */
  public static function clean_str ($str, $extra = null)
  {
    // manually specify some
    $trans = [
      "&" => "and",
      "'" => ""
    ];

    if ($extra && is_array($extra))
      $trans = array_merge($trans, $extra);

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
    $str = trim(preg_replace('/\s+/', ' ', $str));
    if (strlen($str) > $len) {
      $ret = wordwrap($str, $len);
      $ret = substr($ret, 0, strpos($ret, "\n"));
      $ret .= '&hellip;';
    } else
      $ret = $str;
    return $ret;
  }

  public static function depluralize($word)
  {
    return rtrim($word, 's'); // heh
  }

  public static function pluralize($word)
  {
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

  // I didn't want to use size, file, or filesize for obvious reasons. open to better name...
  public static function prettyfilesize($bytes)
  {
    if ($bytes > 1048575) {
      $div = $bytes / 1048576;
      $size = round($div, 1)." MB";
    } else {
      $div = $bytes / 1024;
      $size = round($div, 1)." KB";
    }
    return $size;
  }

}
