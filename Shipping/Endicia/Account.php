<?php
namespace Spark\Shipper\Endicia;

use \Spark\Shipper\Endicia;
use SparkLib\Xml\Builder;
use \SimpleXMLElement;

class Account extends Endicia{
  public $postage_balance = null;
  public $account_status = null;

  public function getAccountStatus(){
    $this->request_type = 'GetAccountStatusXML';
    $this->post_prefix  = 'accountStatusRequestXML';
    $this->xml          = $this->accountStatusRequestXML();
    $this->request();

    print_r($this->response);

    $resp = new SimpleXMLElement( $this->response );
    print $resp->AccountStatusResponse->CertifiedIntermediary->PostageBalance;
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
