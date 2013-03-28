<?php
namespace SparkLib\Shipping\Endicia;

class MailClass {
  public $name;
  public $international;
  public $integrated_form;
  public $max_items;

  public function __construct($name, $international = false, $integrated_form = null, $max_items = null){
    $this->name            = $name;
    $this->international   = $international;
    $this->integrated_form = $integrated_form;
    $this->max_items       = $max_items;
  }

  public static function Express()      { return new static('Express');      }
  public static function First()        { return new static('First');        }
  public static function LibraryMail()  { return new static('LibraryMail');  }
  public static function MediaMail()    { return new static('MediaMail');    }
  public static function StandardPost() { return new static('StandardPost'); }
  public static function ParcelSelect() { return new static('ParcelSelect'); }
  public static function Priority()     { return new static('Priority');     }
  public static function CriticalMail() { return new static('CriticalMail'); }

  public static function FirstClassMailInternational()           { return new static('FirstClassMailInternational', true, 'Form2976', 5); }
  public static function FirstClassPackageInternationalService() { return new static('FirstClassPackageInternationalService', true, 'Form2976', 5); }
  public static function PriorityMailInternational()             { return new static('PriorityMailInternational', true, 'Form2976A'); }
  public static function ExpressMailInternational()              { return new static('ExpressMailInternational', true, 'Form2976A'); }

  public static function fromString($str) {
    if ( method_exists(get_class(), $str) ){
      return static::$str();
    } else {
      return null;
    }
  }

  public function isInternational(){
    return isset($this->international) && $this->international;
  }
}

