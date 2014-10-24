<?php
namespace SparkLib\Application\ControllerRole;

/**
 * Let a controller handle 404/403 functions.
 *
 * A work in progress with many dependencies outside of SparkLib.
 */
trait ErrorHandler {

  /**
   * Display 403 page and appropriate http headers
   *
   * @access public
   * @return void
   */
  public function fourohthree ()
  {
    $body = $this->app()->partial('fourohthree');

    // let's not break the Internet, shall we?
    $this->addHttpHeader('HTTP/1.1 403 Forbidden');

    $this->layout()->title = "ERROR - 403 - FORBIDDEN";
    $this->layout()->body = $body;

    return $this->layout();
  }

  /**
   * Display 404 page and appropriate http headers
   *
   * @access public
   * @return void
   */
  public function fourohfour ()
  {
    $ref         = $this->app()->referer();
    $reason      = '';
    $search_term = '';

    $body = $this->app()->partial('fourohfour');

    // The idea here is to try to figure out where the user came from
    // and act accordingly. There are a few options, including:
    //  * mistyped URL     (no referer)
    //  * broken bookmark  (no referer)
    //  * broken ext. link (external referer)
    //  * broken int. link (internal referer)
    //  * search engine    (search referer)
    // So we try to be smart about it. Sort of.
    // If we're off the mark, we still want to display something useful.

    if (strlen($ref->string()) < 1) {
      // mistyped URL, bad bookmark, client that doesn't pass referer string,
      // malicious activity...
      $reason = 'badurl';

    } elseif (strpos($ref->string(), HOSTNAME)) {
      // internal broken link. shit.
      // TODO: log for investigation
      $reason = 'internal';

    } elseif ($ref->isSearchEngine()) {
      // if the referer is a search engine
      if (isset($ref->req()->q)) {
        $search_term = $ref->req()->q;
      }
      $reason = 'search';

    } else {
      // if we're here, we really don't know why they got the 404.
      $reason = 'unknown';
    }

    // let's not break the Internet, shall we?
    $this->addHttpHeader('HTTP/1.1 404 Not Found');

    $body->reason       = $reason;
    $body->search_term  = $search_term;

    $url_terms    = trim(str_replace('/', ' ', $this->app()->requestUrl()));

    $search_results = $this->getModule('SearchResults');
    $search_results->build_results($url_terms, ['news', 'pages', 'products', 'resources', 'tutorials'], 1, 4, 'relevance|asc', false);

    $body->search_results = $search_results;

    $total_items = array_sum($search_results->getTotals());

    if ($total_items < 1) {
      $body->posts = \BlogPostSaurus::findLiveRandom(2);
      $body->tutorials = \LearnTutorialSaurus::findPublicRandom(2);
      $body->products = \StorefrontProductSaurus::findLiveRandom(4);
    }

    $this->layout()->title = "ERROR - 404 - NOT FOUND";
    $this->layout()->body = $body;

    return $this->layout();
  }

}
