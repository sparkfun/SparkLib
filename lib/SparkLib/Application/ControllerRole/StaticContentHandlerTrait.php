<?php
namespace SparkLib\Application\ControllerRole;

trait StaticContentHandlerTrait {

  /**
   * Spit back some HTML for a custom page.
   *
   * The name "static content" is a holdover from older weirdness.
   */
  protected function renderStaticContent (\StaticContentSaurus $page)
  {
    $body = $this->app()->partial('static_content');
    $body->static = $page;

    if ($page->full_layout && "Learn" !== $this->app()->appName())
      $this->setLayout('default_full');

    if ($page->is_commentable) {
      $mongo = \MongoDBI::getInstance();

      $filter = [
        "entity_table" => "custom_pages",
        "entity_id"    => (string) $page->static_content_name,
        "visible"      => true
      ];

      if ($_SESSION['user']->isAuthenticated() && $_SESSION['user']->customer()->customer_is_moderator)
        unset($filter['visible']);

      $comments = $mongo->comments->find($filter)->sort(["ratings_count" => -1, "ctime" => -1]);
      $body->comments = $comments;
    }

    $this->layout()->rev_canonical = $this->app()->link('pages')->action($page->static_content_name);
    $this->layout()->title = $page->static_content_title;
    $this->layout()->body = $body;
    return $this->layout();
  }

}
