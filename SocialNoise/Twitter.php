<?php
namespace SparkLib\SocialNoise;

use \SparkLib\Fail;

/**
 * This is based on:
 *
 * Plugin Name: PlanetTwitter
 * Description: Pulls in a feed based on a search term passed to it using
 *             this format: [planettwitter:searchterm]
 * Version: 1.1
 * Author: Eric Sipple & Brennen Bearnes
 * Author URI: http://saalonmuyo.com
 * 
 * Copyright 2009  Eric Sipple  (email : saalon@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
class Twitter extends \SparkLib\SocialNoise {

  public static $tableClass = '';

  /**
   * Return search results formatted as HTML.
   */
  public static function searchHTML ($text, $qty)
  {
    $url = 'https://search.twitter.com/search.json?q=' . rawurlencode($text);
    $searchResults = static::getSearchFromJson($url);

    if (! $searchResults)
      return '<p>Search failure.</p>';

    // Set up our string format templates
    $img       = '<img src="%s" height=48 width=48/>';
    $bold      = '<b>%s</b>';
    $fromUser  = '<a href="http://www.twitter.com/%s"><b>%s</b></a> ';
    $feed      = '';

    // Extrude some markup for each result
    $foundQty = 0;
    foreach ($searchResults->results as $result)
    {
      $foundQty++;

      // Replace any @replies or links with hrefs:
      $twitterText = $result->text;
      $twitterText = preg_replace("#(^|[\n ])@([^ \'\"\t\n\r<]*)#ise", "'\\1@<a href=\"http://www.twitter.com/\\2\" >\\2</a>'", $twitterText);
      $twitterText = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $twitterText);
      $twitterText = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $twitterText);

      // Basically undocumented behavior, but for now you can get at profile images
      // securely using https://si[n] instead of http://a[n] addresses.  See:
      //   http://code.google.com/p/twitter-api/issues/detail?id=2175
      //   http://code.google.com/p/twitter-api/issues/detail?id=2006
      $image_url = str_replace('http://a', 'https://si', $result->profile_image_url);

      // Take the profile image, the from user and the created date,
      // throw some HTML blobs around them:
      $feed .= '<tr>'
             . '<td>' . sprintf($img, $image_url) . '</td>'
             . '<td>' . sprintf($fromUser, $result->from_user, $result->from_user)
             . $twitterText
             . '<br><small><i><a href="http://twitter.com/#!/' . $result->from_user . '/status/' . $result->id_str . '">' . $result->created_at . '</a></i></small>'
             . '</td>'
             . '</tr>';

      if ($foundQty >= $qty) {
        break;
      }
    }

    $class = htmlspecialchars(static::$tableClass);
    return "<table class=\"{$class}\">$feed</table>";
  }

}
