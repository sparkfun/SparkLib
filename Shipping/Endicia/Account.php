<?php
namespace SparkLib\Shipping\Endicia;

use SparkLib\Shipping\Endicia;
use SparkLib\Xml\Builder;
use \SimpleXMLElement;

class Account extends Endicia{
  public $balance = null;
  public $active  = null;

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


  //
  // From the old API code
  //
        // if we've less than $100 available, refill
        // NOTE: also check to see if the balance is over $1bn and refill if it is.
        // Endicia's crack API returns a 17 digit number (~ 18 quadrillion) when our
        // balance goes negative, which can only happen if a single label is so expensive
        // it blows right past our $100 window.  This is a dirty hacky fix that needs to
        // be addressed at the account/administrative level with Endicia.
        //
        // $account_status_response = $this->label_server->xmlAccountStatusRequest();
        // if(!preg_match('/<PostageBalance>([^<]*)/', $account_status_response, $matches)) {
        //   die('Tried to get account balance and this was the response:<br/>' . $account_status_response . '<br/>');
        // } else {
        //   if(is_numeric($matches[1])) {
        //     if ( ($matches[1] < 1000) || ($matches[1] > 1000000000) ) {
        //       $desired_postage = 1500;
        //       $recredit_request_response = $this->label_server->xmlRecreditRequest($desired_postage);
        //     }
        //   } else {
        //     die('Returned postage balance of ' . $matches[1] . '...wtf?<br/>');
        //   }
        // }
        // break;

  public function buyPostage($amount){
    $this->request_type = 'BuyPostageXML';
    $this->post_prefix  = 'recreditRequestXML';
    $this->xml          = $this->buyPostageXML($amount);

    $this->request();
    $this->parse_response();
    $this->check_status();

    if (! $this->valid_response)
      return false;

    $state = $this->pullAccountStatus();
    var_dump($state);
    return $state;
  }

  public function buyPostageXML($amount = 1500){
    if ( $amount < 10 || $amount > 99999 )
      throw new \RuntimeException("Postage purchase must be 10 < x < 10000.");

    $b = new Builder();
    $b->RecreditRequest
      ->nest(
        $this->authXML( $b )
        ->RecreditAmount( $amount )
      );

    return $b->string(true);
  }
}
