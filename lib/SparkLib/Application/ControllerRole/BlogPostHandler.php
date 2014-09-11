<?php
namespace SparkLib\Application\ControllerRole;

use \BlogPostSaurus;
use \BlogSaurus;

/**
 * Let a controller handle blog functions.
 *
 * A work in progress with many dependencies outside of SparkLib.
 */
trait BlogPostHandler {

  /**
   * Generate comment feeds for a given blog post.
   */
  public function comments ()
  {
    $this->req()->filter(['id' => 'FILTER_VALIDATE_INT']);

    $post = BlogPostSaurus::getById($this->req()->id);

    if (! $post)
      return $this->reroute('notfound');

    // horrible:
    if ($post->blog === BlogSaurus::COMMERCE_BLOG) {
      $entity_table = 'blog_posts';
    } else {
      $entity_table = 'learn_blog_posts';
    }

    $feed_responder = function() use ($post, $entity_table) {
      $feed = new \Spark\Feed\Comments([
        'entity_table' => $entity_table,
        // YEAAAARRGH:
        'entity_id'    => ['$in' => [$post->getId(), (string)$post->getId()]]
      ], \Spark\Feed\Comments::GET_ALL);
      return $feed;
    };

    $this->respondTo()->rss  = $feed_responder;
    $this->respondTo()->xml  = $feed_responder;
    $this->respondTo()->feed = $feed_responder;

    // for now, just redirect if they're looking for html
    $this->respondTo()->html = function () use ($post) {
      return $this->linkAction()->id($post->getId())->anchor('#comments')->redirect();
    };
  }

}
