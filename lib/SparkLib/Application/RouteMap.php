<?php
namespace SparkLib\Application;

class RouteMap {

  /**
   * Sub-patterns for matching given components of a route. The patterns
   * will be placed inside named capture groups corresponding to the keys
   * here, and separated by slashes. See makePattern().
   */
  public $patterns = [
    // Controller names may contain underscores, but must begin and end with
    // a character in [a-z].  Single-character controller names are allowed.
    // (Alternation happens inside of a non-capturing group, because captured
    // groups are treated as components of the route.)
    'controller' => '(?:[a-z][a-z_]*[a-z]|[a-z])',

    // Same pattern as controller.  Note that because actions are methods,
    // we need to require them to start with a-z lest we accidentally expose
    // __construct() and friends.
    'action'     => '(?:[a-z][a-z_]*[a-z]|[a-z])',

    'shortlink'  => '[enptwr][0-9]+',
    'id'         => '[0-9]+',
    'bson'       => '[0-9a-z]{24}',
    'default'    => '',
  ];

  /**
   * Define routing for requests by method. Currently:
   *
   *   GET    /orders/123/foo -> $controller->foo()   - call action foo() for order 123
   *   GET    /orders/make    -> $controller->make()  - get a new blank order
   *   GET    /orders/123     -> $controller->view()  - look at one order
   *   GET    /orders         -> $controller->index() - look at the index/list of orders
   *
   *   HEAD   Identical to GET
   *
   *   POST   /orders/123     -> $controller->view()   - change order 123
   *   POST   /orders         -> $controller->create() - create a new blank order (using a form returned by make())
   *
   *   DELETE /orders/123     -> delete order 123
   *
   * It is not safe to touch this unless you know _EXACTLY_ what you are doing.
   */
  public $defaultRoutes = [

    'GET' => [
      'id/action'   => null,
      'bson/action' => null,
      'action'      => null,
      'id'          => 'view',
      'default'     => 'index',
    ],

    // These should be identical to GET
    'HEAD' => [
      'id/action'   => null,
      'bson/action' => null,
      'action'      => null,
      'id'          => 'view',
      'default'     => 'index',
    ],

    'POST' => [
      'id/action'   => null,
      'bson/action' => null,
      'action'      => null,
      'id'          => 'update',
      'default'     => 'create',
    ],

    'DELETE' => [
      'id'          => 'delete',
      'bson'        => 'delete',
    ],

  ];

  // Override this to set up custom routes.
  public $routes = [];

  /**
   * Generate a regexp corresponding to a route string.
   * (Plus optionally a type extension.)
   *
   * @return string regular expression
   */
  public function makePattern ($route)
  {
    $pattern_parts = [];

    $route = 'controller/' . $route;

    foreach (explode('/', $route) as $route_part) {
      $part_pattern = $this->patterns[$route_part];
      if ($part_pattern)
        $pattern_parts[] = '(?<' . $route_part . '>' . $this->patterns[$route_part] . ')';
    }

    $pts = implode('/', $pattern_parts);

    return '{^/    # open slash
      ' . $pts . ' # main components of route
      /?           # optional trailing slash

      (?:          # optional group for extension
        [.]        # dot - not captured
        (?<type>
          [a-z]+   # actual extension (xml, json, etc.)
        )
      )?
    $}x';
  }

  /**
   * Get a route array that takes any custom routes into account,
   * ordered correctly. Custom routes will take priority over all default
   * routes.
   */
  public function buildRoutes ($method)
  {
    $default = isset($this->defaultRoutes[$method]) ? $this->defaultRoutes[$method] : array();
    $custom  = isset($this->routes[$method])        ? $this->routes[$method]        : array();
    $merged = $custom;

    foreach ($default as $route => $action) {
      if (! isset($merged[$route]))
        $merged[$route] = $action;
    }

    return $merged;
  }

}
