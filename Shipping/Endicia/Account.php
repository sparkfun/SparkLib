<?php
namespace Spark\Shipper\Endicia;

use \Spark\Shipper\Endicia;
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

    if ( ! $this->valid_response)
      return false;

    $status = $this->sxml->CertifiedIntermediary->AccountStatus;

    if ($status === NULL)
      throw new \RuntimeException("Could not parse AccountStatus from response XML.");
    else
      $this->active = 'A' == (string) $status;

    if ( ! $this->active)
      return;

    $balance = $this->sxml->CertifiedIntermediary->PostageBalance;
    if ($balance === NULL)
      throw new \RuntimeException("Could not parse PostageBalance from response XML.");
    else
      $this->balance = (float) $balance;

    return true;
  }

  public function accountStatusRequestXML(){
    $b = new Builder();
    $b->AccountStatusRequest
      ->attribs( array('Test' => $this->test ? 'YES' : 'NO') )
      ->nest( $b->child()
        ->RequesterID( $this->requester_id )
        ->RequestID('12345')
        ->CertifiedIntermediary(
          $b->child()
            ->AccountID( $this->account_number )
            ->PassPhrase( $this->password )
        )
      );

    return $b->string(true);
  }
}
