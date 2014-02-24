<?php
namespace SparkLib;

define('SLASH', DIRECTORY_SEPARATOR);

/**
 * A simple but configurable autoloader. Expects everything to
 * live under the directory specified by LIBDIR, with most classes
 * under LIBDIR/classes/.
 *
 * <code>
 *   define('LIBDIR', '/path/to/your/code/lib/');
 *   require LIBDIR . 'classes/SparkLib/Autoloader.php';
 * </code>
 */
class Autoloader {

  /**
   * Set this to declare explicit include paths, relative to
   * AUTOLOADER_INCLUDE_ROOT, for things that don't conform to
   * the classes/ClassName.php pattern. For example:
   *
   * <code>
   *   \SparkLib\Autoloader::$classPath = array(
   *     'CupsPrintIPP' => 'phpprintipp/php_classes/CupsPrintIPP.php',
   *     'SphinxClient' => 'classes/sphinxapi.php',
   *   );
   * </code>
   */
  public static $classPath = array();

  /**
   * Set this to declare special directories for classes containing
   * a given substring.
   *
   * <code>
   *   \SparkLib\Autoloader::$searchPaths = array(
   *     'Saurus' => 'classes/dinosaurs/',
   *   );
   * </code>
   */
  public static $searchPaths = array();

  /**
   * Set this to define any extra files which should be included
   * if we fail to find a class.
   */
  public static $extraAutoloaders = array();

  /**
   * Install this puppy as an autoloader, do some basic configuration.
   */
  public static function setup ()
  {
    // TODO
    // Get this in full conformance with:
    // http://groups.google.com/group/php-standards/web/psr-0-final-proposal?pli=1
    // ...and see about just setting include_path() instead of knowing an absolute 
    // path to things.

    // If LIBDIR isn't defined, assume that this file lives in a path like
    // /somepath/lib/classes/SparkLib/, where we want somepath/lib/ to be
    // our include root...
    if (constant('LIBDIR')) {
      define('AUTOLOADER_INCLUDE_ROOT', LIBDIR);
    } else {
      define(
        'AUTOLOADER_INCLUDE_ROOT',
        realpath(dirname(__FILE__) . SLASH . '..' . SLASH . '..' . SLASH)
      );
    }

    // Register autoloaders
    spl_autoload_register(array('\SparkLib\Autoloader', 'load'));
  }

  /**
   * Do the actual business of autoloading.
   *
   * @param string name of class
   */
  public static function load ($class)
  {
    if (isset(self::$classPath[$class])) {
      $path = self::$classPath[$class];
    }
    else {
      // TODO: All these strpos() calls are probably expensive.
      foreach (static::$searchPaths as $substr => $dir) {
        // we first check for a \, which indicates a namespace
        // - those we want to skip
        if ((false === strpos($class, '\\')) && (false !== strpos($class, $substr))) {
          $path = $dir . $class . '.php';
          break;
        }
      }
    }

    // If we got here, try for a corresponding file in classes
    if (! isset($path)) {
      $class = str_replace('\\', SLASH, $class);
      $path = 'classes' . SLASH . $class . '.php';
    }

    $full_path = AUTOLOADER_INCLUDE_ROOT . SLASH . $path;
    if (is_file($full_path)) {
      include $full_path;
    } else {
      // If we've got any fallback autoloaders, pull 'em in so
      // they can try to find the class in question
      foreach (static::$extraAutoloaders as $autoloader_path) {
        include_once($autoloader_path);
      }
    }
  }

}
