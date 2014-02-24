<?php

/*
 * Compressor
 *
 * PunyPNG.com image compression API wrapper
 * Supports PNG, JPEG, and GIF images
 *
 * @author Ben LeMasurier <ben@sparkfun.com>
 *
 */

namespace SparkLib\Image;

class Compressor
{
  const URL          = 'http://www.punypng.com/api/optimize';
  const DOWNLOAD_URL = 'http://www.punypng.com/processor/download_image';
  const MAX_FILESIZE = 5242880; // PunyPNG limit, 5MB.

  private $_ch;

  public function __construct()
  {
    // PunyPNG API key must be defined
    if(!defined('PUNYPNG_KEY'))
      throw new \Exception('PunyPNG API key undefined');

    // ensure curl library is available
    if(!function_exists('curl_version'))
      throw new \Exception('cURL library support is required');

    // initialize curl
    $this->_ch = curl_init(self::URL);
  }

  public function __destruct()
  {
    curl_close($this->_ch);
  }

  /*
   * upload and compress the given file
   *
   * @param $file - full path to uncompressed image
   * @param $lossy - defaults to false, lossless and lossy formats
   *    will still be availbe, this is only for logging purposes.
   * @return mixed, false on failure
   */
  public function compress($file, $lossy = false)
  {
    if(!file_exists($file))
      throw new \Exception('File not found: ' . $file);

    if(!is_file($file))
      throw new \Exception('Invalid file: ' . $file);

    if(filesize($file) > self::MAX_FILESIZE)
      throw new \Exception($file . ' exceeds maximum file size of ' . self::MAX_FILESIZE . ' bytes');

    $result = $this->upload($file);
    if(!$result->status)
      return false;

    if(!isset($result->optimized_url))
      throw new \Exception('PunyPNG API did not return a download URL');

    if($lossy && !isset($result->indexed_url))
      throw new \Exception('PunyPNG API did not return a lossy download URL');

    // Log successful result
    $ics = new \ImageCompressionSaurus();
    $ics->original_size  = $result->original_size;
    if($lossy)
      $ics->optimized_size = ($result->original_size - $result->indexed_savings_bytes);
    else
      $ics->optimized_size = $result->optimized_size;
    $ics->ctime = \SparkLib\DB::Now();
    $ics->insert();

    return $result;
  }

  /*
   * download the optimized image
   *
   * @param $file mixed - this can either be the url
   *    or the return value from compress()
   * @param $save_path - full save path for the downloaded image
   * @param $lossy boolean - if passing the result of compress(), specify
   *    whether you'd like the lossy or lossless image. Defaults to false.
   */
  public function download($file, $save_path, $lossy = false)
  {
    if(!is_string($file)) {
      if($lossy) {
        if(!isset($file->indexed_url))
          throw new \Exception('missing indexed download url');

        $file = $file->indexed_url;
      } else {
        if(!isset($file->optimized_url))
          throw new \Exception('missing optimized download url');

        $file = $file->optimized_url;
      }
    }

    curl_setopt($this->_ch, CURLOPT_URL, $file);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->_ch, CURLOPT_FILE, fopen($save_path, 'w'));

    return curl_exec($this->_ch);
  }

  /*
   * upload the given file to PunyPNG for compression
   *
   * @return mixed - PunyPNG API Response and status code
   */
  private function upload($file)
  {
    $postdata = [
      'key' => PUNYPNG_KEY,
      'img' => new \CURLFile($file)
    ];

    curl_setopt($this->_ch, CURLOPT_URL, self::URL);
    curl_setopt($this->_ch, CURLOPT_POST, true);
    curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);

    $result           = json_decode(curl_exec($this->_ch));
    $result->status   = (curl_getinfo($this->_ch, CURLINFO_HTTP_CODE) === 200);

    return $result;
  }
}
