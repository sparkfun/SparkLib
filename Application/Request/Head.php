<?php
namespace SparkLib\Application\Request;
/**
 * Model a HEAD request. This is something of a special case - HEAD
 * expects the identical response headers to a GET request, but should
 * not return a response body.
 *
 * We model this as a child class of Get so as to be transparent
 * to controllers expecting a GET request.
 */

class Head extends \SparkLib\Application\Request\Get { }
