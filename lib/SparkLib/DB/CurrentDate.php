<?php
namespace SparkLib\DB;

class CurrentDate implements Literal {

  public function literal ()
  {
    return 'CURRENT_DATE';
  }

}
