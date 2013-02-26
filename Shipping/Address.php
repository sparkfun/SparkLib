<?php

namespace SparkLib\Shipping;

class Address {
  // Booleans
  public $domestic = true;

  // Strings
  public $first_name;
  public $last_name;
  public $company;
  public $address;
  public $address2;
  public $city;
  public $state;
  public $postal_code;
  public $country;
  public $phone_number;

  public function isDomestic(){
    return !! $this->domestic;
  }
}
