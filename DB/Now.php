<?php
namespace SparkLib\DB;

class Now implements Literal {

  public function literal ()
  {
    return 'NOW()';
  }

}
