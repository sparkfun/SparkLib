<?php
namespace SparkLib\DB;

class Null implements Literal {

  public function literal ()
  {
    return 'null';
  }

}
