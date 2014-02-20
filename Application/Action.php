<?php
namespace SparkLib\Application;

/**
 * An interface for things returned from Controller actions.
 * Application will call fire() on these. See Redirect for an
 * example.
 */
interface Action {

  public function fire();

}
