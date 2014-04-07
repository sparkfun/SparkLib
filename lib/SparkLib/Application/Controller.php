<?php
namespace SparkLib\Application;

use \SparkLib\Application;
use \SparkLib\Application\Responder;
use \SparkLib\Application\Redirect;
use \SparkLib\Application\Action;
use \SparkLib\Fail;
use \SparkLib\Template;
use \SparkLib\Renderable;
use \Exception;

/**
 * Child classes should provide public methods corresponding
 * to actions.
 *
 * For now, see comments in Application.
 *
 * @author Brennen Bearnes <brennen@sparkfun.com>
 */
abstract class Controller {

  protected $_app;

  protected $_action        = null;
  protected $_errors        = array();
  protected $_layout        = null;
  protected $_defaultLayout = 'default.tpl.php';
  protected $_template      = null;
  protected $_mime          = 'text/html';
  protected $_type          = 'text/html';
  protected $_headers       = array(
    'X-UA-Compatible: chrome=1', // adds support for Google Chrome Frame for IE - if we recommend it we need this
    'X-Dinosaur-Says: RAWR',
  );

  protected $_defaultExtension = 'html';

  protected $_dbiWrite = true;

  protected $_modelInfo = array();

  public static $useacl = false; // should this controller use the ACL to glean perms automatically?

  /**
   * @param \SparkLib\Application that's running the show.
   */
  public function __construct (Application $app)
  {
    $this->_app = $app;
    $this->postConstruct();
  }

  /**
   * To be overloaded in child classes for doing constructor-like things;
   * called in the constructor.
   *
   * Not called init() because I didn't want to eat any more of the available
   * namespace for actions.
   *
   * You might, for example, set up a default responder here to be
   * overridden later.
   */
  protected function postConstruct () { }

  /**
   * Fire off an action (a public method on this controller), and do
   * something appropriate with the results.
   *
   * $this->action() may return:
   *
   *   A string or integer, to be printed.
   *   An array, to be encoded as JSON and printed.
   *   A Template, to be rendered and printed.
   *   Anything which implements SparkLib\Application\Action, which will be "fired".
   *     - for an example, see SparkLib\Redirect.
   *
   * Ideally, no output will be sent to the client outside of this method.
   *
   * @param $action string method to fire
   * @return void
   */
  public function handleResult ($result)
  {
    if ((! $result) && $this->hasResponse()) {
      // the method didn't return anything, but it did set up a responder
      // object with one or more callback functions for different content
      // types

      $wanted_type = $this->req()->mapType();

      // fall back to defaults if we don't have a responder function for this.
      // will be an extension, not a mime type.
      if (! $this->_response->__isset($wanted_type))
        $wanted_type = $this->_defaultExtension;

      $result = $this->_response->run($wanted_type);
      $this->setType(Application::$extensionToMime[$wanted_type]);
    }

    // Handle resources (file handles)
    if ($result && is_resource($result)){
      // Examine the resource to set the appropriate type.
      switch (get_resource_type($result)){
        case 'gd':
          $this->setType('image/png');
          break;
        default:
          $this->setType(false);
          throw new Exception("unsupported resource type [" . get_resource_type($result) . "] from {$this->_action}()");
          break;
      }
    }

    // Send headers - passed off to environment for SAPI-specific
    // handling
    foreach ($this->_headers as $header) {
      $this->_app->env()->header($header);
    }
    $this->_app->env()->header('Content-Type: ' . $this->getType());

    // If this is a HEAD request, we don't want a response body
    if ($this->req() instanceof \SparkLib\Application\Request\Head)
      return;

    // Render result based on type
    if     (is_string($result) || is_int($result)) echo $result;
    elseif (is_array($result))                     echo $this->jsonPrep($result);
    elseif ($result instanceof Renderable)         echo $result->render();
    elseif ($result instanceof Action)             $result->fire();

    elseif (is_resource($result) && $this->getType()) {
      switch ($this->getType()){
        case 'image/png':
          imagepng($result);
          break;
        default:
          throw new Exception("unsupported mime type [{$this->getType()}] from {$this->_action}()");
          break;
      }
    } elseif ($result instanceof \Generator) {
      foreach ($result as $yielded) {
        echo $yielded;
      }
    } else {
      throw new Exception(
        "expected string, array, resource, generator, Template, or Action from {$this->_action}(), but got a " . gettype($result)
      );
    }
  }

  /**
   * Do json_encode() and make sure that SparkLib\Fail won't tack anything
   * on to the response. This is something of a hack for the case where
   * we haven't set up a respondTo()->json callback but are still returning
   * an array to be turned into JSON from an action, and should only really
   * matter in the development environment.
   *
   * TODO: Get better at setting response types based on the kind of thing
   * we are actually sending back. Also, get better at using respondTo() for
   * things where we need something other than text/html. - BPB
   *
   * @param $result array to be converted into JSON
   */
  protected function jsonPrep (array &$result)
  {
    Fail::$errorLogAll = true;
    return json_encode($result);
  }

  /**
   * Get the controlling app for this controller
   *
   * @return \SparkLib\Application
   */
  protected function app () { return $this->_app; }

  /**
   * Return the controller app's Request object, which should model the
   * current GET or POST.
   *
   * @return SparkLib\Application\Request
   */
  protected function req () { return $this->_app->req(); }

  /**
   * Return the controller appl's Route object, which should model the
   * current route.
   */
  protected function route () { return $this->_app->route(); }

  /**
   * Access the current template for this application/controller/action.
   *
   * @return \SparkLib\Template
   */
  protected function template ()
  {
    if (! $this->_template)
      $this->setTemplate();
    return $this->_template;
  }

  /**
   * Public version of template().
   *
   * @return \SparkLib\Template
   */
  public function getTemplate ()
  {
    return $this->template();
  }

  /**
   * Set the current template to either the default or a specified
   * alternative.
   *
   * @param optional string template filename
   */
  protected function setTemplate ($template = null)
  {
    if (null === $template) {
      $template = $this->_app->action() . '.tpl.php';
    } elseif (is_string($template) && (! strpos($template, '.'))) {
      // bare string name, append ".tpl.php"
      $template .= '.tpl.php';
    }

    $tpl_dir = strtolower(get_class($this->_app)) . '/' . $this->_app->controller();

    if ($template instanceof Template) {
      $this->_template = $template;
    } else {
      // new template with app & controller available:
      $this->_template = new Template(
        null,
        array('app' => $this->_app, 'ctl' => $this)
      );
      $this->_template->setTemplateDirRel($tpl_dir);
      $this->_template->setTemplate($template);
    }

    return $this;
  }

  /**
   * Access the current page layout for this application.
   *
   * @return Template for current layout
   */
  protected function layout ()
  {
    if (! $this->_layout)
      $this->setLayout();
    return $this->_layout;
  }

  /**
   * Public version of layout().
   *
   * @return \SparkLib\Template
   */
  public function getLayout ()
  {
    return $this->layout();
  }

  /**
   * Set the current page layout to either the default or a specified
   * alternative.
   *
   * @param $layout_file string optional template filename
   */
  protected function setLayout ($layout_file = null)
  {
    if (! $layout_file)
      $layout_file = $this->_defaultLayout;

    if (! strpos($layout_file, '.'))
      $layout_file .= '.tpl.php';

    $this->_layout = new Template(
      null,
      ['app' => $this->_app,
       'ctl' => $this]
    );
    $this->_layout->setTemplateDirRel(strtolower(get_class($this->_app)) . '/layouts');
    $this->_layout->setTemplate($layout_file);

    return $this;
  }

  /**
   * Set a Content-Type
   *
   * @param $type string content type
   * @return string content type
   */
  protected function setType($type)
  {
    if ($type !== 'text/html')
      Fail::$errorLogAll = true; // suppress some pesky HTML generation
    $this->_type = $type;
    return $type;
  }

  /**
   * Reroute to a different action and return its results.
   *
   * As a side effect, resets the action on the current Application.
   *
   * TODO: Something about this is fucked.  The app and the controller
   * seem like they're the wrong kind of coupled now.
   *
   * @param string name of action to reroute to
   * @return array|string|int|SparkLib\Application\Action result of re-routed action
   */
  protected function reroute ($action)
  {
    $this->_app->setAction($action);
    return $this->$action();
  }

  /**
   * Access a Responder for this controller. Responder __set
   * magic will treat properties as, more or less, filetype extensions
   * corresponding to an appropriate MIME type, and expects them to be
   * set to an anonymous function which returns appropriate data.
   *
   * There are two viable syntaxes for setting up a response:
   *
   * <code>
   *   // some action:
   *   public function view ()
   *   {
   *     $somedino = new FooSaurus(123);
   *     // interesting things expected to happen here
   *
   *     $this->respondTo(array(
   *       'xml' => function () use ($somedino) {
   *         return $somedino->toXml(); // yeah, this needs to be written too
   *       },
   *
   *       'jpeg' => function () use ($somedino) {
   *         // should headers be set here, or should that be automatic?
   *         return $somedino->renderJpeg(); // mostly I'm kidding
   *       }
   *     ));
   *
   *     // notice that you don't need to return anything from the action here.
   *   }
   * </code>
   *
   * Or...
   *
   * <code>
   *   public function view ()
   *   {
   *     // ...
   *
   *     $this->respondTo()->xml = function () use ($somedino) {
   *     };
   *
   *     // etc.
   *   }
   * </code>
   */
  protected function respondTo ($responses = null)
  {
    if (! isset($this->_response)) {
      if (! isset($responses))
        $responses = array();
      $this->_response = new Responder($responses); // I know, I know, autovivification is scary
    } elseif (is_array($responses)) {
      $this->_response = new Responder($responses);
    }
    return $this->_response;
  }

  protected function hasResponse ()
  {
    return isset($this->_response);
  }

  /**
   * Get a Redirect that goes back to the index with request params in p
   * This is used by the login stuff that currently still lives in the main layout
   * template.
   *
   * TODO: untangle.
   */
  protected function goHome()
  {
    $app = $this->app();
    $getstring = $app->controller() . '/' . $app->action() . $this->req()->compact();
    return new \SparkLib\Application\Redirect($app->url() . '?p=' . urlencode($getstring), 401);
  }

  /**
   * @return string current Content-Type
   */
  public function getType()
  {
    return $this->_type;
  }

  /**
   * Set a custom HTTP header
   *
   * @param string http header
   * @return string http header
   */
  protected function addHttpHeader ($header)
  {
    $this->_headers[] = $header;
    return $header;
  }

  /**
   * Attempt to create a dinosaur.
   * Uses the request object as well as an optional array of presets for values
   */
  protected function createModel ($presets = array())
  {
    if (! isset($this->_modelInfo['class'])) {
      throw new Exception('Insufficient info for magick create');
    }

    $classname = $this->_modelInfo['class'];

    if (! class_exists($classname)) {
      throw new UnexpectedValueException("{$classname} is not a valid class");
    }

    $instance = new $classname;

    $user = $_SESSION['user']->adminUser();
    $instance->modificationInfo(array('user' => $user->getId()));

    $pass_messages = ($this->req()->mapType() == 'html');

    // Build the $source array of values for the new record by starting with the request
    // object and adding key/val pairs from the presets array, if present.
    // Do not allow a value $presets to overwrite a value in the request object.
    $source = $this->req()->getArray();
    foreach ($presets as $field => $value) {
      if (! isset($source[$field]))
        $source[$field] = $value;
    }

    try {
      $instance->setFrom($source);
      $instance->insert();
      if ($pass_messages)
        $this->_app->passMessage('Created', 'success');

      return $instance;
    }
    catch (SparkRecordException $e) {
      if ($pass_messages)
        $this->_app->passMessage('Create failed', 'error');

      return false;
    }
  }

  /**
   * Attempt to update an associated dinosaur.
   */
  protected function updateModel ()
  {
    if (! isset($this->_modelInfo['class'])) {
      throw new Exception('Insufficient info for magick update');
    }

    $classname = $this->_modelInfo['class'];

    if (! class_exists($classname)) {
      throw new UnexpectedValueException("{$classname} is not a valid class");
    }

    $req = $this->req()->getArray();
    $user = $_SESSION['user']->adminUser();
    $instance = new $classname($this->req()->id);

    if (is_array($this->_modelInfo['perms'])) {
      foreach ($this->_modelInfo['perms'] as $field => $perm) {

        if (isset($req[$field]) && ! $user->hasPermission(key($perm), current($perm)) &&

          // xxx this is duplicating some logic in dino&update, asking if the
          // field will change.  i don't like it, but i don't know how
          // else to stop this from throwing false warnings.
          $req[$field] != $instance->$field

        ) {
          $this->_app->passMessage("You are not allowed to update {$field}", 'error');
          unset($req[$field]);
        }
      }
    }

    // use loose comparison here to deal with the fact that we're getting
    // strings but the models have actual typed values (we don't want to set
    // identical values to the ones that're already set):
    $fields = array_keys($req);
    foreach ($fields as $field) {
      if (! $instance->isValidField($field))
        continue;

      if ($req[$field] == $instance->$field) {
        unset($req[$field]);
      }
    }

    $instance->setFrom($req);
    $instance->modificationInfo(array('user' => $user->getId()));

    $pass_messages = ($this->req()->mapType() == 'html');

    try {
      if ($instance->update()) {
        if ($pass_messages)
          $this->_app->passMessage('Updated', 'success');
      }
      else {
        if ($pass_messages)
          $this->_app->passMessage('Nothing to update', 'message');
      }

      return $instance;
    }
    catch (SparkRecordException $e) {
      if ($pass_messages)
        $this->_app->passMessage('Update failed', 'error');

      return false;
    }
  }

  /**
   * Return a specific module/action
   */
  public function getModule ($module)
  {
    if(! class_exists('\Spark\Module\\' . $module))
      throw new Exception('Invalid Module: ' . $module);

    $class = '\Spark\Module\\' . $module;

    $module = new $class(array(
      'ctl' => $this,
      'app' => $this->_app
    ));

    return $module;
  }

  /**
   * Get the current HTTP headers
   *
   * @return array http headers
   */
  public function getHttpHeaders ()
  {
    return $this->_headers;
  }

  /*
   * Return a Link for a given action on the current controller.
   * Defaults to the bare controller, which means action will be routed to index.
   *
   * TODO: Make this actually respect the current controller (this class) instead
   * of what Application thinks is the current controller...  This is too
   * tightly coupled.
   *
   * @param $action string optional action name (uses default otherwise)
   * @return SparkLib\Application\Link
   */
  public function linkAction ($action = null)
  {
    $link = $this->_app->link($this->_app->controller());
    if ($action)
      $link->action($action);
    return $link;
  }

}
