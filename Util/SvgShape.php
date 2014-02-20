<?php

namespace SparkLib\Util;

/*

  This class can be used to obtain svg path snippets for some basic shapes
 */

class SvgShape {

  public static function shape($shape, $x, $y, $width, $fill)
  {
    $method = "self::{$shape}";
    if (is_callable($method, false, $callable_name)) {
      return call_user_func_array($callable_name, array_slice(func_get_args(), 1));
    }
    return FALSE;
  }

  public static function circle($x, $y, $width, $height, $fill = 'black') {
    $cpw = 0.166 * $width;
    return '<path fill="' . $fill . '" d="M ' . ($x + ($width / 2)) . ' ' . $y . ' C ' . ($x + $width + $cpw) . ' ' . $y . ' ' . ($x + $width + $cpw) . ' ' . ($y + $height) . ' ' . ($x + ($width / 2)) . ' ' . ($y + $height) . ' C ' . ($x - $cpw) . ' ' . ($y + $height) . ' ' . ($x - $cpw) . ' ' . $y . ' ' . ($x + ($width / 2)) . ' ' . $y . ' Z"/>';
  }

  public static function square($x, $y, $width, $height, $fill = 'black') {
    return '<path fill="' . $fill . '" d="M ' . $x . ' ' . $y . ' L ' . ($x + $width) . ' ' . $y . ' ' . ($x + $width) . ' ' . ($y + $height) . ' ' . $x . ' ' . ($y + $height) . ' Z"/>';
  }

  public static function triangle($x, $y, $width, $height, $fill = 'black') {
    return '<path fill="' . $fill . '" d="M ' . ($x + ($width / 2)) . ' ' . $y . ' L ' . ($x + $width) . ' ' . ($y + $height) . ' ' . $x . ' ' . ($y + $height) . ' ' . $x . ' ' . ($y + $height) . ' Z"/>';
  }

  public static function triangleDown($x, $y, $width, $height, $fill = 'black') {
    return '<path fill="' . $fill . '" d="M ' . $x . ' ' . $y . ' L ' . ($x + $width) . ' ' . $y . ' ' . ($x + ($width/2)) . ' ' . ($y + $height) . ' Z"/>';
  }

  public static function diamond($x, $y, $width, $height, $fill = 'black') {
    return '<path fill="' . $fill . '" d="M ' . ($x + ($width / 2)) . ' ' . $y . ' L ' . ($x + $width) . ' ' . ($y + ($height / 2)) . ' ' . ($x + ($width / 2)) . ' ' . ($y + $height) . ' ' . $x . ' ' . ($y + ($height / 2)) . ' Z"/>';
  }

  public static function triforce($x, $y, $width, $height, $fill = 'gold') {
    return '<path fill="' . $fill . '" d="M ' . ($x + ($width / 2)) . ' ' . $y . ' L ' . ($x + ($width - ($width / 4))) . ' ' . ($y + ($height / 2)) . ' ' . ($x + ($width / 4)) . ' ' . ($y + ($height / 2)) . ' ' . ($x + ($width / 4)) . ' ' . ($y + ($height / 2)) . ' Z"/>' .
            '<path fill="' . $fill . '" d="M ' . ($x + ($width / 4)) . ' ' . ($y + ($height / 2)) . ' L ' . ($x + ($width / 2)) . ' ' . ($y + $height) . ' ' . $x . ' ' . ($y + $height) . ' ' . $x . ' ' . ($y + $height) . ' Z"/>' .
            '<path fill="' . $fill . '" d="M ' . ($x + ($width - ($width / 4))) . ' ' . ($y + ($height / 2)) . ' L ' . ($x + $width) . ' ' . ($y + $height) . ' ' . ($x + ($width / 2)) . ' ' . ($y + $height) . ' ' . ($x + ($width / 2)) . ' ' . ($y + $height) . ' Z"/>';
  }

}