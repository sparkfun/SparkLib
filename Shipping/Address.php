<?php

namespace SparkLib\Shipping;

class Address {
  // Boolean
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
  public $email;

  public function isDomestic(){
    return !! $this->domestic;
  }

  public function fullName(){
    return trim($this->first_name . ' ' . $this->last_name);
  }

  public function trimPostalCode($length = 5){
    return substr($this->postal_code, 0, $length);
  }

  public function blankName()     { return 0 === strlen( $this->fullName() );         }
  public function blankCompany()  { return 0 === strlen(trim( $this->company ));      }
  public function blankPhone()    { return 0 === strlen(trim( $this->phone_number )); }
  public function blankEmail()    { return 0 === strlen(trim( $this->email ));        }
  public function blankAddress2() { return 0 === strlen( $this->address2 );           }
}
