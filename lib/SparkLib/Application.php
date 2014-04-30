<?php
namespace SparkLib;

use \SparkLib\Application\Environment;
use \SparkLib\Application\Controller;
use \SparkLib\Application\Link;
use \SparkLib\Application\Redirect;
use \SparkLib\Application\Request;
use \SparkLib\Application\Route;
use \SparkLib\Application\RouteMap;
use \SparkLib\Exception\SparkException;
use \SparkLib\Exception\AuthenticationException;
use \SparkLib\Blode\Event;
use \SparkLib\Fail;
use \SparkLib\User;
use \Exception;

/**
 * SparkLib\Application - A (relatively) simple web application framework
 *
 * @author Brennen Bearnes <brennen@sparkfun.com>
 * @author Ben LeMasurier <ben@sparkfun.com>
 * @author Casey Dentinger <caseyd@sparkfun.com>
 * @author David Stillman <dave@sparkfun.com>
 * @author Rob Carpenter <robert@sparkfun.com>
 * @author Todd Treece <ttreece@sparkfun.com>
 */
abstract class Application {

  protected $_env;                                 // Environment of request.

  protected $_req;                                 // Request which models current HTTP request, more or less
  protected $_referer;                             // SparkReferer which models HTTP_REFERER for current request, if possible
  protected $_route;                               // Route which models elements of current route, more or less
  protected $_sparkrev;                            // stat() mktime of the last deploy
  protected $_defaultController  = 'index';        // Default controller for this app
  protected $_controller;                          // Name of current controller
  protected $_defaultAction      = 'index';        // Name of default action
  protected $_action;                              // Name of current action
  protected $_fallbackController = 'fallback';     // Name of fallback controller - go here if we don't find anything else
  protected $_dispatcher         = 'index.php';    // Filename of script what does dispatching
  protected $_controllerClass    = null;
  protected $_namespace          = false;          // Always use namespaces for controllers?
  protected $_routeMap;                            // Route map object

  protected $_ctl;

  protected static $_hostname    = 'localhost';    // Hostname where this app lives
  protected static $_root        = '/';            // Root directory for the application - override in child classes
  protected static $_instance    = null;           // Current instance of Application - see app() below

  public static $mimeToExtension = [
    'text/html'                            => 'html',
    'application/xhtml+xml'                => 'html',
    'application/xml'                      => 'html', // ARGH - TODO: WTF is this about again?
    'application/json'                     => 'json',
    'application/javascript'               => 'js',
    'text/csv'                             => 'csv',
    'text/plain'                           => 'txt',
    'text/xml'                             => 'xml',
    'application/rss+xml'                  => 'rss',
    'application/atom+xml'                 => 'xml',
    'application/vnd.google-earth.kml+xml' => 'kml',
    'font/ttf'                             => 'ttf',
    'image/png'                            => 'png',
    'application/pdf'                      => 'pdf',
  ];

  public static $extensionToMime = [
    'html' => 'text/html',
    'xml'  => 'text/xml',
    'json' => 'application/json',
    'js'   => 'application/javascript',
    'csv'  => 'text/csv',
    'txt'  => 'text/plain',
    'rss'  => 'application/rss+xml',
    'kml'  => 'application/vnd.google-earth.kml+xml',
    'ttf'  => 'font/ttf',
    'png'  => 'image/png',
    'pdf'  => 'application/pdf',
  ];

  /**
   * Instantiate an application, handling all of the top-level stuff we're
   * going to deal with - GET and POST variables, sessions, you name it,
   * and then route it to the correct controller and action.
   *
   * There are some intentional constraints in place here. You aren't
   * allowed to combine a POST with GET variables. Hopefully this makes
   * it a bit easier to think about whether an operation retrieves a
   * resource or makes some change to one.
   *
   * You are allowed to instantiate no more than one child of Application,
   * at least for now. Once this method ends, the application is done
   * running.
   */
  public function __construct (Environment $environment)
  {
    if (isset(static::$_instance))
      throw new Exception("tried to instantiate more than one Application");

    // store the instance so it can be accessed statically with app()
    // (in retrospect this might not have been such a hot idea):
    static::$_instance = $this;

    $this->_env        = $environment;
    $this->_req        = $this->_env->req();
    $this->_controller = $this->_defaultController;
    $this->_action     = $this->_defaultAction;

    $map_class = get_class($this) . 'RouteMap';
    $this->_routeMap = new $map_class;

    $this->_env->startSession(); // start a session and populate it
    $this->userInit();

    /* From here, we dispatch a request to the correct controller. This is
       the guts of everything. */

    // figure it out:
    $this->discernRoute();

    // to be overloaded in a child class (e.g.: Sparkle) if needed:
    $this->init();

    // no more mucking with the request object:
    $this->_req->finalize();

    // TODO: this is also called in setController() - seems redundant here,
    //       but breaks things if it goes away. Should be sorted.
    $this->_controllerClass = $this->makeControllerName($this->_controller);

    // verify controller and action:
    $this->validate();

    // stash the controller instance for later use
    $this->_ctl = new $this->_controllerClass($this);

    $action_method = $this->_action;

    try {
      // We want _only_ public methods to ever be called as actions.  By
      // checking is_callable() in this context, and passing the result
      // of the action method off to the controller, we make sure that anything
      // private/protected is uncallable:
      if (is_callable(array($this->_ctl, $action_method))) {
        $this->_ctl->handleResult( $this->_ctl->$action_method() );
      } else {
        $this->fallback('action not callable');
      }
    } catch (SparkException $e) {
      // Finally, we might have gotten a user-level exception:
      $this->handleException($e);
    }
  }

  /**
   * Set the controller. Expects a string.
   */
  protected function setController ($controller)
  {
    $class = $this->makeControllerName($controller);

    // Let's make sure $class is actually a Controller. It's not
    // paranoia when they're really out to get you.
    if ( (! class_exists($class)) || (! is_subclass_of($class, 'SparkLib\Application\Controller')) ) {
      if ($class === 'fallback')
        return false; // avoid infinite loopage
      $this->fallback($class . ' is not a Controller.');
      return false;
    }

    $this->_controller      = $controller;
    $this->_controllerClass = $class;

    return true;
  }

  /**
   * Figure out where we are supposed to go, based on path info.
   *
   * TODO: Most of this stuff should not live in Application.
   */
  protected function discernRoute ()
  {
    // Did we get a path at all?
    if (! strlen($path = trim($this->_env->path())))
      return;

    $route_found = false;
    $matches     = array();

    // Have we defined any direct routing?
    if (isset($this->_routeMap->directRoutes)) {
      foreach ($this->_routeMap->directRoutes as $direct_pattern => $direct_route) {
        if (preg_match($direct_pattern, $path, $direct_route_matches)) {
          $this->setController($direct_route[0]);

          if (isset($direct_route[1]))
            $action = $direct_route[1];
          elseif (isset($direct_route_matches['action']))
            $action = $direct_route_matches['action'];
          else
            $action = $this->_defaultAction;

          $route_found = true;
          $matches     = $direct_route_matches;

          foreach ($matches as $key => $value) {
            if (! is_numeric($key))
              $this->_req->inject($key, $value);
          }
        }
      }
    }

    // If we haven't got a route by now (from the directRoutes) we'll try and
    // figure out a controller...
    $initial_pattern = '{^/(' . $this->_routeMap->patterns['controller'] . ').*$}';
    if ((! $route_found) && preg_match($initial_pattern, $path, $initial_route)) {
      if ($this->setController($initial_route[1])) {
        foreach ($this->_routeMap->buildRoutes($this->_env->method()) as $route => $action) {
          $pattern = $this->_routeMap->makePattern($route);
          if ($route_found = preg_match($pattern, $path, $matches)) {
            break;
          }
        }
      }
    }

    if ($route_found) {
      // add these to the request, if we got 'em:
      if (isset($matches['id']))   { $this->_req->inject('id',   $matches['id']);   }
      if (isset($matches['bson'])) { $this->_req->inject('bson', $matches['bson']); }

      $this->_action = is_null($action)
                     ? $matches['action']
                     : $action;
    } else {
      $this->fallback('No route found for request, path given: ' . $this->_env->path());
    }

    // tell the request about any file type extension we got
    if (isset($matches['type'])) {
      if (! $this->_req->setTypeFromExtension($matches['type'])) {
        $this->fallback('Unable to map an appropriate type for ' . $matches['type']);
      }
    }

    // This will be empty if we haven't found anything by now.
    $this->_route = new Route($matches);
  }

  /**
   * Do the controller and its action exist? Will only pass with a
   * public method named after the action, or a __call() method which
   * can dynamically handle actions.
   */
  protected function validate ()
  {
    $is_real_method = method_exists($this->_controllerClass, $this->_action);
    $has_call       = method_exists($this->_controllerClass, '__call');
    if (! $is_real_method && ! $has_call) {
      $this->fallback(
        'No such action (and no __call() fallback) when looking for ' . $this->_controllerClass . '&' . $this->_action
      );
    }
  }

  /**
   * Handle user-level exceptions
   */
  protected function handleException (SparkException $e)
  {
    // Inform the user
    $this->passMessage($e->getMessage());

    // Override the current controller and validate the new target
    $this->_controller      = $e->controller();
    $this->_controllerClass = $this->makeControllerName($this->_controller);
    $this->_ctl             = new $this->_controllerClass($this);
    $this->_action          = $e->action();

    $this->validate();

    $redirect = $this->_ctl->linkAction($this->_action)->redirect(301);
    $redirect->fire();
  }

  /**
   * To be overloaded in child classes for doing constructor-like things;
   * called in the constructor.
   */
  protected function init() { }

  /**
   * To be overloaded in child classes for doing user init-like things
   * called in startSession()
   */
  protected function userInit() { }

  /**
   * Log an error and let the fallback controller decide what to do.
   * Assumes that a fallback controller will be present. (Not found errors
   * as well as any necessary magic on URLs not modeled by controllers can
   * happen here.)
   */
  protected function fallback ($logmsg)
  {
    $this->setController('fallback');
    $this->_action = 'index';
  }

  /**
   * Tell Blode to record this run of the application.
   * Child classes of Application can call this as-appropriate.
   */
  protected function blodeRun ()
  {
    $run = [
      'event' => 'app.run',
      'app'   => get_class($this),
    ];

    // do not track:
    if (isset($_SERVER['HTTP_DNT']))
      $run['dnt'] = $_SERVER['HTTP_DNT'];

    Event::debug($run);
  }

  /**
   * Go down in flames if someone tries to make a copy of the application.
   */
  public function __clone ()
  {
    throw new Exception("why you try and make clone of Application? >:|");
  }

  /**
   * Return a Link modelling a URL/path for the given controller.
   * See the docs in that class for more detail. Should enable something like:
   *
   * <code>
   * echo $app->link('products')->id(666)->a('Arduino Duemilanove');
   * </code>
   *
   * @param string controller name
   * @return Link for given controller
   */
  public function link ($controller = null)
  {
    $base = 'https://' . static::$_hostname . $this->url();
    return new Link($base, $controller);
  }

  /**
   * Return a Link for another Application. This
   * should be better.
   *
   * @param string controller name
   * @return Link for given app/controller
   */
  public static function externalLink ($controller = null)
  {
    $base = 'https://' . static::$_hostname . static::$_root;
    return new Link($base, $controller);
  }

  /**
   * Return a Template for the given partial.
   *
   * Look in [template dir]/[application]/partials/ for corresponding
   * template files. If a controller name is specified as the second
   * parameter, use [template dir]/[application]/[controller]/ instead.
   *
   * @param string name of partial
   * @return Template instance for corresponding partial
   */
  public function partial ($name, $controller = null)
  {
    $partial = new \SparkLib\Template(null, array(
      'app' => $this,
      'ctl' => $this->_ctl
    ));

    if (null === $controller) {
      $partial->setTemplateDirRel($this->_templateDir . '/partials');
    } elseif (is_string($controller)) {
      $partial->setTemplateDirRel($this->_templateDir . '/' . $controller);
    } else {
      throw new Exception('If supplied, controller name must be a string.');
    }

    $partial->setTemplate($name . '.tpl.php');
    if (! $partial->templateFileExists()) {
      // we haaaaaaaaates it:
      $partial->setTemplateDir(\LIBDIR . 'templates/partials');
    }

    return $partial;
  }

  public function ctl () { return $this->_ctl; }

  /**
   * @return \SparkLib\Application current instance of Application
   */
  public static function app () { return static::$_instance; }

  /**
   * timestamp of the last deploy. Useful for bumping version numbers of static files.
   *
   * @return int timestamp
   */
  public function sparkrev ()
  {
    if ($this->_sparkrev)
      return $this->_sparkrev;
    $s = stat(BASEDIR . '/sparkrev');
    $this->_sparkrev = $s['mtime'];
    return $this->_sparkrev;
  }

  /**
   * Various other getters. These are getters, in case you're wondering, so
   * that they will be hard to mess with.  If you're trying to change one
   * of the underlying values for some reason and there's not already a
   * method for it, talk to Brennen.
   */

  /**
   * Base path of the application.
   *
   * @return string url
   */
  public function baseUrl () { return static::$_root; }

  /**
   * How should external code point to this application.
   *
   * @return string url
   */
  public static function linkPath () { return static::$_root; }

  /**
   * URL of the dispatcher itself. Will likely be the same as baseUrl() if
   * URL rewriting is in place on the web server.
   *
   * @return string url
   */
  public function url () { return static::$_root . $this->_dispatcher; }

  /**
   * Full path of the request string without the request params
   *
   * @return string url
   */
  public function requestUrl ()
  {
    if (strpos($_SERVER['REQUEST_URI'], '?'))
      // is this faster than explode()? _dave
      return substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
    return $_SERVER['REQUEST_URI'];
  }

  /**
   * An object modeling the components of the referer, or false
   * if we can't parse same.
   *
   * Arguably maybe this should be chained off the request, but
   * for now I'm putting it here in the interest of less typing.
   */
  public function referer ()
  {
    if (! isset($this->_referer)) {
      $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
      $this->_referer = new \SparkLib\URLParser($ref);
    }
    return $this->_referer;
  }

  /**
   * @return Environment for the current SAPI
   */
  public function env () { return $this->_env; }

  /**
   * @return Request which models the current request
   */
  public function req () { return $this->_req; }

  /**
   * @return Route which models the current route
   */
  public function route () { return $this->_route; }

  /**
   * @return string name of the current action
   */
  public function action () { return $this->_action; }

  /**
   * Set the current action.
   *
   * @param string action name
   */
  public function setAction ($action)
  {
    return $this->_action = $action;
  }

  /**
   * @return string name of the current controller
   */
  public function controller() { return $this->_controller; }

  /**
   * Camelcase a name_with_underscores and come up with a class name
   * like ApplicationWhateverName.
   *
   * @param string name of a controller
   * @return string name of a controller class
   */
  public function makeControllerName ($controller)
  {
    $parts = explode('_', $controller);
    foreach ($parts as &$part) {
      $part = ucfirst($part);
    }

    // this lives in Application\Controller
    $namespaced = get_class($this) . '\\' . implode('', $parts);

    // this tells us everything will be namespaced, so we can
    // shortcut right to using that one
    if ($this->_namespace)
      return $namespaced;

    // this lives in Application\ApplicationController
    // it is the old way and we hates it
    $un_namespaced = get_class($this) . implode('', $parts);

    if (class_exists($un_namespaced)) {
      return $un_namespaced;
    }

    return $namespaced;
  }

  /**
   * Return application name
   *
   * @author tylerc <tyler.cipriani@sparkfun.com>
   */
  public function appName() { return get_class($this); }

  /**
   * End the current session.
   */
  public function endSession ()
  {
    $this->_env->endSession();
  }

  /**
   * Stash a message in the session to be passed on to the user.
   */
  public function passMessage ($message, $type = 'error', $delay = 0, $fixed = false)
  {
    // replaces with full class?
    $messageO = new \stdClass();
    $messageO->type  = $type;
    $messageO->delay = $delay;
    $messageO->fixed = $fixed;
    $messageO->text  = $message;

    $_SESSION['messages'][] = $messageO;
  }

  public function getMessages ($type = null)
  {
    $messages = [];
    foreach ($_SESSION['messages'] as $message){
      if ($type == null || $message->type == $type){
        $messages[] = $message;
      }
    }

    // Reset user messages, we've seen these now.
    $_SESSION['messages'] = array();

    return $messages;
  }

  public function hasMessages ()
  {
    return count($_SESSION['messages']) > 0;
  }

  public function require_authentication ($redirect = null)
  {
    if (! $_SESSION['user']->isAuthenticated())
      throw new AuthenticationException($redirect);
  }

}
