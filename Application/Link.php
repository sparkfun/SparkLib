<?php
namespace SparkLib\Application;

use \SparkLib\HTML;

/**
 * A class to model links within Applications. Used by 
 * Application&link(), etc.
 */
class Link extends HTML {

  protected $_controller;
  protected $_id;
  protected $_action;
  protected $_url;
  protected $_anchor;
  protected $_params;
  protected $_title;
  protected $_type = '';
  protected $_target = '';

  /**
   * Make a new link.
   *
   * @param string base URL to link
   * @param string controller to link
   */
  public function __construct ($url, $controller)
  {
    $this->_url        = $url;
    $this->_controller = $controller;
  }

  /**
   * get the controller
   *
   * @return string controller
   */
  public function getController ()
  {
    return $this->_controller;
  }

  /**
   * Set an id
   *
   * @param integer id
   * @return Link
   */
  public function id ($id)
  {
    $this->_id = $id;
    return $this;
  }

  /**
   * Set an action
   *
   * @param string action
   * @return Link
   */
  public function action ($action)
  {
    $this->_action = $action;
    return $this;
  }

  /**
   * get the action
   *
   * @return string action
   */
  public function getAction ()
  {
    return $this->_action;
  }

  /**
   * Set a target anchor.
   *
   * @param string name of target anchor
   * @return Link
   */
  public function anchor ($target)
  {
    $this->_anchor = (0 === strpos($target, '#') ? $target : '#' . $target);
    return $this;
  }

  /**
   * Set the target attribute.
   *
   * @param string name of the target type
   * @return Link
   */
  public function target ($target)
  {
    $this->_target = $target;
    return $this;
  }

  /**
   * Set a target type (html, json, csv, etc.)
   *
   * @param string name of type
   * @return Link
   */
  public function type ($type)
  {
    $this->_type = $type;
    return $this;
  }

  protected function renderType ()
  {
    if ($this->_type)
      return '.' . $this->_type;
    else
      return '';
  }

  /**
   * Set request parameters, eg: link/id?foo=bar&baz=bat
   *
   * @param mixed params can be an array or string of parameters
   * @return Link
   */
  public function params ($params)
  {
    if(is_array($params))
      $this->_params = '?' . http_build_query($params);
    elseif(is_string($params))
      $this->_params = (0 === strpos($params, '?') ? $params : '?' . $params);
    else
      throw new \Exception('Unknown param type in Link');
    return $this;
  }

  /**
   * Set a human-readable title.
   *
   * @param string $title
   * @return Link
   */
  public function title ($title)
  {
    $this->_title = $title;
    return $this;
  }

  /**
   * Get the currently set title.
   *
   * @return string title, null if not set
   */
  public function getTitle ()
  {
    return $this->_title;
  }

  /**
   * Stringify the current link
   *
   * @return string current path
   */
  public function __toString ()
  {
    return $this->path();
  }

  /**
   * Return a link tag for the current link.
   *
   * @param string optional text for link
   * @param array optional attributes for a tag
   * @return string link tag
   */
  public function a ($linktext = null, array $attribs = array())
  {
    // If we didn't get any link text, come up with a default
    if (! isset($linktext))
      $linktext = $this->_controller . ' ' . $this->_action . ' ' . $this->_id;

    $attribs['href'] = $this->path();
    if (isset($this->_title))
      $attribs['title'] = $this->_title;

    if( $this->_target != '' )
      $attribs['target'] = $this->_target;

    return $this->makeTag('a', $attribs, $linktext);
  }

  /**
   * Kind of a silly utility function. Maybe we should make this more magical
   * and shiny in future.
   */
  public function a_titled ($linktext = null, array $attribs = array())
  {
    $title = mb_strtolower($linktext ? $linktext : $this->path());
    return $this->a($linktext, array('title' => $title));
  }

  /**
   * @return string path for current link
   */
  public function path ()
  {
    $path   = array();
    $target = '';
    if (isset($this->_controller)) $path[] = $this->_controller;
    if (isset($this->_id))         $path[] = $this->_id;
    if (isset($this->_action))     $path[] = $this->_action;

    $base = rtrim($this->_url, '/');
    return $base . '/' . implode('/', $path) . $this->renderType() . $this->_params . $this->_anchor;
  }

  /**
   * @return \SparkLib\Application\Redirect for current link
   */
  public function redirect ($status = 302)
  {
    return new Redirect($this->path(), $status);
  }

}
