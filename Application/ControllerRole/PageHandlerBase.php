<?php
namespace SparkLib\Application\ControllerRole;

use \SparkLib\Application\Controller;
use \DomainSaurus;
use \StaticContentSaurus;

/**
 * class from which all Page controllers descend
 * to be shared across applications
 *
 * Contains dependencies outside of SparkLib.
 *
 * @author tylerc <tyler.cipriani@sparkfun.com>
 */
class PageHandlerBase extends Controller
{
  use StaticContentHandlerTrait;

  public function view ()
  {
    $name = $this->req()->id;

    $domain_id = $this->app()->appName() === 'Commerce' 
               ? DomainSaurus::COMMERCE 
               : DomainSaurus::LEARN;

    if ($static = StaticContentSaurus::getActiveByName($name, false, $domain_id))
      return $this->renderStaticContent($static);

    return $this->app()->link('fallback')->action('notfound')->redirect();
  }

}
