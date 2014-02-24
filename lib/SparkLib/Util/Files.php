<?php
namespace SparkLib\Util;

class Files {

  public static function scandir_by_ctime ($dir, $direction = null)
  {
    if('ASC' != $direction)
      $direction = null;

    $filez = scandir($dir);
    $sort = array();
    foreach ($filez as $file) {
      if ($file != '.' && $file != '..') {
        if (filectime($dir . $file) === false)
          return false;
        $date = date("YmdHis", filectime($dir . $file));
        $sort[$date] = $file;
      }
    }

    if ('ASC' == $direction)
      ksort($sort);
    else
      krsort($sort);

    return $sort;
  }

  public static function is_empty_dir ($dir)
  {
     return (($files = @scandir($dir)) && count($files) <= 2);
  }

}
