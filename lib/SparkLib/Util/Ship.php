<?php
namespace SparkLib\Util;

class Ship
{

  public static function isUpsAccount ($number)
  {
    return preg_match('/^[a-z0-9]{6}$/i', $number) ? true : false;
  }

  public static function isFedExAccount ($number)
  {
    return preg_match('/^[0-9]{9}$/i', $number) ? true : false;
  }

}
