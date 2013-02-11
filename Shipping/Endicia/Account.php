<?php
namespace Spark\Shipper\Endicia;

use \Spark\Shipper\Endicia;
use SparkLib\Xml\Builder;
use \SimpleXMLElement;

class Account extends Endicia{
  public $balance = null;
  public $active  = null;

  public function getAccountStatus(){
    $this->request_type = 'GetAccountStatusXML';
    $this->post_prefix  = 'accountStatusRequestXML';
    $this->xml          = $this->accountStatusRequestXML();
    $this->request();
    $this->parse_response();

    $balance = $this->sxml->CertifiedIntermediary->PostageBalance;
    $status = $this->sxml->CertifiedIntermediary->AccountStatus;

    if ($balance === NULL)
      ;// ???
    else
      $this->balance = (float) $balance;

    if ($status === NULL)
      ;
    else
      $this->active = 'A' == (string) $status;
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
