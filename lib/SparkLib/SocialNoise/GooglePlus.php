<?php
namespace SparkLib\SocialNoise;

use \SparkLib\Fail;
use \SparkLib\Util\Text;

class GooglePlus extends \SparkLib\SocialNoise {

  protected $_key = null;

  public $tableClass = '';

  /**
   * Make a new GooglePlus object that knows about a given API key.
   *
   * @param $api_key
   */
  public function __construct ($api_key)
  {
    $this->_key = $api_key;
  }

  /**
   * Get an object representing search results.
   */
  public function search ($text, $qty)
  {
    $key = $this->_key;
    $url = "https://www.googleapis.com/plus/v1/activities?query={$text}&maxResults={$qty}&orderBy=recent&pp=1&key={$key}";
    return static::getSearchFromJson($url);
  }

  /**
   * Format a particular search response as HTML.
   */
  public function searchHTML ($text, $qty)
  {
    $result = $this->search($text, $qty);

    $html = '<table class="' . htmlspecialchars($this->tableClass) . '">';

    foreach ($result->items as $activity) {
      $image_url = $activity->actor->image->url;

      $html .= '<tr>';
      if (strlen($image_url) > 14) {
        // if actor->image->url is this short, it's probably bunk data, and we are too
        // lazy to go digging through the rest of the stuff in the response looking
        // for a valid one:
        $html .=  '<td><img height=50 width=50 src="' . htmlspecialchars($image_url) . '"></td>';
      } else {
        $html .= '<td></td>';
      }

      $html .= '<td><a href="' . htmlspecialchars($activity->actor->url) . '">' . htmlspecialchars($activity->actor->displayName) . '</a> ';

      if (isset($activity->title))
        $html .= $activity->title;

      if (isset($activity->object->attachments)) {
        foreach($activity->object->attachments as $attached) {
          if (isset($attached->displayName)) {
            $displayname = Text::truncate($attached->displayName, 140);

            $html .= '<br><a href="'
                   . htmlspecialchars($attached->url)
                   . '">' . htmlspecialchars($displayname) . '</a>';
          }
        }
      }
      $html .= '<br><i><small><a href="'
             . htmlspecialchars($activity->url)
             . '">' . $activity->published . '</a></small></i></td></tr>';
    }
    $html .= '</table>';

    return $html;
  }

}
