<?php
namespace SparkLib\Util;

/**
 * A place to hang date-and-time stuff that doesn't seem
 * to exist elsewhere. Considerable redundancy at the
 * moment; liable to change substantially.
 */
class DateTime {

  public static function interval_since ($date)
  {
    $iv = date_diff(
      new \DateTime($date),
      new \DateTime('now')
    );

    $units = array(
      ' yr ' => $iv->y,
      ' mo ' => $iv->m,
      ' dy ' => $iv->d,
      ' hr ' => $iv->h,
      ' min' => $iv->i,
    );

    $str   = '';
    $found = 0;

    foreach ($units as $label => $val) {
      if ($val > 0)
        $found++;
      if ($found > 0)
        $str .= $val . $label;
      if ($found > 2)
        break;
    }

    return $str;
  }

  public static function interval ($seconds)
  {
    // This is pretty silly.
    $str = '';
    $segment = function ($divisor, $label) use (&$seconds, &$str) {
      $units = round(($seconds - ($seconds % $divisor)) / $divisor);
      $seconds = $seconds % $divisor;
      if ($units)
        $str .= "$units $label ";
    };

    $segment(86400, 'dy');
    $segment(3600,  'hr');
    $segment(60,    'min');

    return trim($str . ($seconds ? "$seconds sec" : ''));
  }

  // heh. fuzzy interval.
  // Stolen from the internet.
  // http://blog.slapthink.net/2009/04/16/fuzzy-time-or-relative-time-in-php/
  public static function fuzzy_interval ($date_from)
  {
    $_time_formats = array(
      array(60, 'just now'),
      array(90, '1 minute'),
      array(3600, 'minutes', 60),
      array(5400, '1 hour'),
      array(86400, 'hours', 3600),
      array(129600, '1 day'),
      array(604800, 'days', 86400),
      array(907200, '1 week'),
      array(2628000, 'weeks', 604800),
      array(3942000, '1 month'),
      array(31536000, 'months', 2628000),
      array(47304000, '1 year'),
      array(3153600000, 'years', 31536000),
    );

    $now = time();// current unix timestamp

    // if a number is passed assume it is a unix time stamp
    // if string is passed try and parse it to unix time stamp
    if(is_numeric($date_from)){
      $dateFrom = $date_from;
    }elseif (is_string($date_from)) {
      $dateFrom   = strtotime($date_from);
    }

    $difference = $now - $dateFrom;// difference between now and the passed time.
    $val    = '';// value to return

    if ($dateFrom <= 0) {
      $val = 'a long time ago';
    } else {
      //loop through each format measurement in array
      foreach ($_time_formats as $format) {
        // if the difference from now and passed time is less than first option in format measurment
        if ($difference < $format[0]) {
          //if the format array item has no calculation value
          if (count($format) == 2) {
            $val = $format[1] . ($format[0] === 60 ? '' : ' ago');
            break;
          } else {
            // divide difference by format item value to get number of units
            $val = ceil($difference / $format[2]) . ' ' . $format[1] . ' ago';
            break;
          }
        }
      }
    }
    return $val;
  }

  /**
   * from the internets
   *
   * @param time() $small_ts
   * @param time() $large_ts
   */
  public static function contextualTime ($small_ts, $large_ts=false)
  {
    if (! $large_ts) {
      $large_ts = time();
    }
    $n = $large_ts - $small_ts;

    if ($n <= 1)
      return 'less than 1 second ago';

    if ($n < (60))
      return $n . ' seconds ago';

    if ($n < (60*60)) {
      $minutes = round($n/60);
      return 'about ' . $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    }

    if ($n < (60*60*16)) {
      $hours = round($n/(60*60));
      return 'about ' . $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    }

    if ($n < (time() - strtotime('yesterday')))
      return 'yesterday';

    if ($n < (60*60*24)) {
      $hours = round($n/(60*60));
      return 'about ' . $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    }

    if ($n < (60*60*24*6.5))                     return 'about ' . round($n/(60*60*24)) . ' days ago';
    if ($n < (time() - strtotime('last week')))  return 'last week';
    if (round($n/(60*60*24*7))  == 1)            return 'about a week ago';
    if ($n < (60*60*24*7*3.5))                   return 'about ' . round($n/(60*60*24*7)) . ' weeks ago';
    if ($n < (time() - strtotime('last month'))) return 'last month';
    if (round($n/(60*60*24*7*4))  == 1)          return 'about a month ago';
    if ($n < (60*60*24*7*4*11.5))                return 'about ' . round($n/(60*60*24*7*4)) . ' months ago';
    if ($n < (time() - strtotime('last year')))  return 'last year';
    if (round($n/(60*60*24*7*52)) == 1)          return 'about a year ago';
    if ($n >= (60*60*24*7*4*12))                 return 'about ' . round($n/(60*60*24*7*52)) . ' years ago';

    return false;
  }

}
