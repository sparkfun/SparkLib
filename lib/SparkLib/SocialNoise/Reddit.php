<?php
namespace SparkLib\SocialNoise;

use \SparkLib\Util\DateTime;

class Reddit extends \SparkLib\SocialNoise {

  /**
   * Get an object representing search results.
   */
  public static function search ($text, $qty)
  {
    $url = "http://www.reddit.com/search.json?q={$text}&sort=new";
    return static::getSearchFromJson($url);
  }

  /**
   * Return search results formatted as HTML.
   *
   * @param $text to search for
   * @param $qty max number of items to return
   */
  public static function searchHTML ($text, $qty)
  {
    $h = function ($str) { return htmlspecialchars($str); };

    $html = '<ul>';
    $result = static::search($text, $qty);

    $i = 0;
    foreach ($result->data->children as $post) {
      if ($i++ > $qty) {
        break;
      }

      $post_title = $h(trim($post->data->title));
      if ($post->data->score >= 10)
        $post_title = "<b>$post_title</b>";
      $html .= '<li><a href="http://www.reddit.com/'
             . $h($post->data->permalink)
             . '">'
             . $post_title . "</a>";

      $author = $post->data->author;

      $html .= ' <small><i>' . $post->data->score . ' points, submitted '
             . DateTime::contextualTime($post->data->created_utc)
             . ' by <a href="http://www.reddit.com/u/'
             . $h($author) . '">' . $h($post->data->author) . '</a></i></small></li>';
    }

    return $html . '</ul>';
  }

}
