<?php

namespace SparkLib\Util;

class Timer {

  private $_startTime = null;

  public function __construct ()
  {
    $this->reset();
  }

  public function reset ()
  {
    $time = microtime();
    $time = explode(' ', $time);
    $this->_startTime = $time[1] + $time[0];
  }

  public function spent ()
  {
    $time = microtime();
    $time = explode(' ', $time);

    return ($time[1] + $time[0]) - $this->_startTime;
  }

}
