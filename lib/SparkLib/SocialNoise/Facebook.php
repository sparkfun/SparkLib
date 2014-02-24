<?php
namespace SparkLib\SocialNoise;

use \SparkLib\Util\Text;

class Facebook extends \SparkLib\SocialNoise {

  public $tableClass = '';

  public function __construct () { }

  public function search ($text, $qty)
  {
    $url = "https://graph.facebook.com/search?type=post&q={$text}";
    return static::getSearchFromJson($url);
  }

  /**
   * Format a particular search response as HTML.
   */
  public function searchHTML ($text, $qty)
  {
    $result = $this->search($text, $qty);

    $html = '<table class="' . htmlspecialchars($this->tableClass) . '">';

    $count = 0;
    foreach ($result->data as $activity) {

      if ($count++ > $qty)
        break;

      $html .= '<tr>';

      if (isset($activity->picture))
        $html .= '<td><img src="' . htmlspecialchars($activity->picture) . '" height=50 width=50></td>';
      elseif (isset($activity->icon))
        $html .= '<td><img src="' . htmlspecialchars($activity->icon) . '"></td>';
      else
        $html .= "<td></td>";

      $html .= '<td>[' . htmlspecialchars($activity->from->name) . '] ';

      if (isset($activity->message))
        $html .= (Text::truncate(htmlspecialchars($activity->message), 50));
      elseif (isset($activity->story))
        $html .= (Text::truncate(htmlspecialchars($activity->story), 50));

      $html .= '<br>';
      $time = '<small><i>' . htmlspecialchars($activity->created_time) . "</i></small>";
      if (isset($activity->link))
        $html .= '<a href="' . htmlspecialchars($activity->link) . '">' . $time . '</a>';
      else
        $html .= $time;

      $html .= "</td></tr>";
    }

    $html .= '</table>';

    return $html;
  }

}
