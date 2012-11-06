<?php
namespace SparkLib\Util;

/**
 * A utility class to map mime types to extensions and vice-versa.
 *
 * This is not meant to be comprehensive - just the ones we come across regularly.
 *
 * Based in part on debian's /etc/mime.types
 **/

class Mime {

  public static $mimeToExtension = array(
    // the usuals
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/tiff' => 'tiff',
    'image/gif'  => 'gif',

    // pdf
    'applications/vnd.pdf'  => 'pdf',
    'application/acrobat'   => 'pdf',
    'application/x-pdf'     => 'pdf',
    'application/pdf'       => 'pdf',
    'text/x-pdf'            => 'pdf',
    'text/pdf'              => 'pdf',

    // odt
    'application/vnd.oasis.opendocument.text'   => 'odt',
    'application/x-vnd.oasis.opendocument.text' => 'odt',

    // zip
    'application/x-zip-compressed' => 'zip',
    'application/x-compressed'     => 'zip',
    'application/octet-stream'     => 'zip',
    'application/x-compress'       => 'zip',
    'application/x-zip'            => 'zip',
    'application/zip'              => 'zip',
    'multipart/x-zip'              => 'zip',

    // doc
    'application/vnd.ms-word' => 'doc',
    'application/vnd.msword'  => 'doc',
    'application/x-msword'    => 'doc',
    'application/winword'     => 'doc',
    'application/msword'      => 'doc',
    'application/x-msw6'      => 'doc',
    'application/word'        => 'doc',
    'application/doc'         => 'doc',
    'appl/text'               => 'doc',

    // docx
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',

    // ppt
    'application/vnd.ms-powerpoint' => 'ppt',
    'application/vnd-mspowerpoint'  => 'ppt',
    'application/ms-powerpoint'     => 'ppt',
    'application/mspowerpoint'      => 'ppt',
    'application/x-powerpoint'      => 'ppt',
    'application/mspowerpnt'        => 'ppt',
    'application/powerpoint'        => 'ppt',
    'application/mspowerpnt'        => 'ppt',
    'application/x-m'               => 'ppt',
  );

  public static $extensionToMime = array(
    'jpg'  => 'image/jpeg',
    'png'  => 'image/png',
    'tiff' => 'image/tif',
    'pdf'  => 'application/pdf',
    'odt'  => 'application/vnd.oasis.opendocument.text',
    'zip'  => 'application/zip',
    'doc'  => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'ppt'  => 'application/vnd.ms-powerpoint',
  );

  public static function getMime($extension)
  {
    return self::$extnsionToMime[$extension];
  }

  public static function getExtension($mime)
  {
    return self::$mimeToExtension[$mime];
  }

}

