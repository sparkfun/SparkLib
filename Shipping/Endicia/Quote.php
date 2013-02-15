<?php
namespace SparkLib\Shipping\Endicia;

use SparkLib\Shipping\Endicia;
use SparkLib\Xml\Builder;
use \SimpleXMLElement,
    \AddressBookSaurus,
    \ShippingBoxSaurus;

class Quote extends Endicia {
  public $to_address, $from_address, $box, $weight;

  public function quote(){
    if ($this->from_address === null)
      throw new \LogicException('From address can\'t be null. Set Quote#from_address before fetching quotes');
    if ($this->to_address === null)
      throw new \LogicException('From address can\'t be null. Set Quote#to_address before fetching quotes');
    if ($this->box === null)
      throw new \LogicException('From address can\'t be null. Set Quote#box before fetching quotes');


    $this->request_type = 'CalculatePostageRatesXML';
    $this->post_prefix  = 'postageRatesRequestXML';
    $this->xml          = $this->fetchQuoteXML($this->from_address, $this->to_address, $this->box, $this->weight);

    $this->request();

    $this->parse_response();
    $this->check_status();

    $this->buildQuotes();
    print_r($this->rate_responses);
  }

  public function fetchQuoteXML(AddressBookSaurus $from, AddressBookSaurus $to, ShippingBoxSaurus $box, $weight){
    $international = ! $to->isDomestic();

    // array(length, height, width)
    $dimmensions = $box->outerDims('in');

    // domestic postal codes can only be 5 digits
    $postal_code = $international ? $to->entry_postcode
                                  : substr($to->entry_postcode, 0, 5);

    $b = new Builder();
    $b->PostageRatesRequest
      ->nest(
        $this->authXML( $b )
        ->MailClass( $international ? 'International' : 'Domestic' )
        ->WeightOz( $weight )
        ->MailpieceShape('Parcel')
        // ->MailpieceDimensions
        //   ->nest( $b->child()
        //     ->Length( $dimmensions[0] )
        //     ->Width(  $dimmensions[2] )
        //     ->Height( $dimmensions[1] )
        //   )
        ->FromPostalCode( $from->entry_postcode )
        ->ToPostalCode( $postal_code )
        ->ToCountryCode( $to->Country->countries_iso_code_2 )
      );

    return $b->string(true);
  }

  public function buildQuotes(){
    if ($this->response === null || $this->sxml === null)
      throw new \LogicException('buildQuote requires a parsed quote response before quotes can be assembled');

    $this->rate_responses = array();
    foreach ($this->sxml->PostagePrice as $rate_response) {
      $this->rate_responses[] = array(
        'MailClass'   => (string) $rate_response->MailClass,
        'MailService' => (string) $rate_response->Postage->MailService,
        'Postage'     => (float)  $rate_response['TotalAmount'],
      );
    }

  }
}
