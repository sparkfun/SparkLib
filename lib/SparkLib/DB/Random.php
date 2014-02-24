<?php
namespace SparkLib\DB;

class Random implements Literal {

  public function __construct ($db_type = 'mysql')
  {
    $this->_dbType = $db_type;
  }

  public function literal ()
  {
    if ('mysql' === $this->_dbType)
      return 'RAND()';
    else
      return 'RANDOM()';
  }

}
