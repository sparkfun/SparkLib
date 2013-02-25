<?php
namespace SparkLib\Shipping\Endicia;

use SparkLib\Shipping\Endicia;
use SparkLib\Xml\Builder;
use \SimpleXMLElement;

class Account extends Endicia{
  public $balance = null;
  public $active  = null;

  const MINIMUM_CREDIT_REQUEST = 10;
  const MAXIMUM_CREDIT_REQUEST = 99999;

  public function fetchAccountStatus(){
    $this->request_type = 'GetAccountStatusXML';
    $this->post_prefix  = 'accountStatusRequestXML';
    $this->xml          = $this->accountStatusRequestXML();
    $this->request();

    $this->parse_response();
    $this->check_status();

    return $this->pullAccountStatus();
  }

  public function accountStatusRequestXML(){
    $b = new Builder();
    $b->AccountStatusRequest
      ->attribs( array('Test' => $this->test ? 'YES' : 'NO') )
      ->nest( $this->authXML( $b ) );

    return $b->string(true);
  }

  private function pullAccountStatus(){
    if ( ! $this->valid_response)
      return false;

    $status = $this->sxml->CertifiedIntermediary->AccountStatus;

    if ($status === NULL)
      throw new \RuntimeException("Could not parse AccountStatus from response XML.");
    else
      $this->active = 'A' == (string) $status;

    if ( ! $this->active)
      return false;

    $balance = $this->sxml->CertifiedIntermediary->PostageBalance;
    if ($balance === NULL)
      throw new \RuntimeException("Could not parse PostageBalance from response XML.");
    else
      $this->balance = (float) $balance;

    return true;
  }

  public function buyPostage($amount){
    $this->request_type = 'BuyPostageXML';
    $this->post_prefix  = 'recreditRequestXML';
    $this->xml          = $this->buyPostageXML($amount);

    $this->request();
    $this->parse_response();
    $this->check_status();

    if (! $this->valid_response)
      return false;

    // print_r($this->response);

    // TODO Come back for this when endicia responds to the email with something helpful
    // $state = $this->pullAccountStatus();
    // return $state;
    return true;
  }

  public function buyPostageXML($amount = 1500){
    if ( $amount < static::MINIMUM_CREDIT_REQUEST || $amount > static::MAXIMUM_CREDIT_REQUEST )
      throw new \RuntimeException("Postage purchase must be " . static::MINIMUM_CREDIT_REQUEST . " < x < " . static::MAXIMUM_CREDIT_REQUEST . ".");

    $b = new Builder();
    $b->RecreditRequest
      ->nest(
        $this->authXML( $b )
        ->RecreditAmount( $amount )
      );

    return $b->string(true);
  }

  public function ensureAccountBalance($minimum = 100){
    $this->fetchAccountStatus();

    if ($this->balance < $minimum){
      $amount_needed = $minimum - $this->balance;

      if ($amount_needed < static::MINIMUM_CREDIT_REQUEST)
        $amount_needed = static::MINIMUM_CREDIT_REQUEST;

      if ($amount_needed > static::MAXIMUM_CREDIT_REQUEST)
        $amount_needed = static::MAXIMUM_CREDIT_REQUEST;

      $this->buyPostage( $amount_needed );
      return true;
    }

    return false;
  }
}
