<?php
namespace SparkLib\DB;

class True implements Literal {

  public function literal ()
  {
    return 'true';
  }

}
