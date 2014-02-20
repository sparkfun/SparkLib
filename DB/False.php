<?php
namespace SparkLib\DB;

class False implements Literal {

  public function literal ()
  {
    return 'false';
  }

}
