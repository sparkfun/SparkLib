<?php
namespace SparkLib\DB;

class DefaultValue implements Literal {

  public function literal ()
  {
    return 'DEFAULT';
  }

}
