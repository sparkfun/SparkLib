<?php
namespace SparkLib\SocialNoise;

use \SparkLib\Util\DateTime;

class Reddit extends \SparkLib\SocialNoise {

  /**
   * Get an object representing search results.
   */
  public static function search ($text, $qty)
  {
    $url = "http://www.reddit.com/search.json?q={$text}";
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
      $html .= '<li><a href="http://www.reddit.com/'
             . $h($post->data->permalink)
             . '">'
             . $h(trim($post->data->title)) . "</a>";

      $html .= ' <small><i>' . $post->data->score . ' points, submitted '
             . DateTime::contextualTime($post->data->created_utc)
             . ' by ' . $h($post->data->author) . '</i></small></li>';
    }

    return $html . '</ul>';
  }

}
