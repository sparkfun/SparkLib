<?php
namespace SparkLib;

/**
 * A base class for simple wrappers to talk to some social media APIs.
 *
 * It's ok, the words "social media" make us gag a little too. Have a
 * look in SocialNoise/ for useful code.
 */
class SocialNoise {

  /**
   * Returns an object modelling the search results from the specified
   * URL (which is expected to be JSON).
   *
   * Just a wrapper to avoid cURL and cache boilerplate elsewhere.
   */
  public static function getSearchFromJson ($url)
  {
    $search = function () use ($url) {
      // humbly submitted: this is a stupid interface.
      $ch = curl_init($url);
      curl_setopt($ch, \CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, \CURLOPT_HEADER, 0);
      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result);
    };

    // If we've got a memcache wrapper available, store the results
    // for a bit.
    // TODO: Offer a filesystem-based alternative.
    if (class_exists('\SparkCache')) {
      $cachekey = get_called_class() . md5($url);
      $cache = \SparkCache::getInstance();
      return $cache->getOrSet($cachekey, $search);
    } else {
      return $search();
    }
  }

}
