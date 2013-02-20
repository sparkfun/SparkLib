<?php
namespace SparkLib\Shipping\Endicia;

use SparkLib\Shipping\Endicia,
    SparkLib\Shipping\Address;

use SparkLib\Xml\Builder;

class Quote extends Endicia {
  public $to_address, $from_address, $dimensions, $weight;

  public function quote(){
    if ( ! $this->from_address instanceof Address)
      throw new \LogicException("From address must be a SparkLib\Shipping\Address. Set Quote#from_address before fetching quotes");
    if ( ! $this->to_address instanceof Address)
      throw new \LogicException("From address must be a SparkLib\Shipping\Address. Set Quote#to_address before fetching quotes");
    if ($this->dimensions === null || ! is_array($this->dimensions) || count($this->dimensions) != 3)
      throw new \LogicException('Dimensions must be set to 3 slot array before quoting');


    $this->request_type = 'CalculatePostageRatesXML';
    $this->post_prefix  = 'postageRatesRequestXML';
    $this->xml          = $this->fetchQuoteXML($this->from_address, $this->to_address, $this->dimensions, $this->weight);

    $this->request();

    $this->parse_response();
    $this->check_status();

    $this->buildQuotes();

    return $this->rates;
  }

  public function fetchQuoteXML(Address $from, Address $to, array $dimensions, $weight){
    $international = ! $to->domestic;

    // domestic postal codes can only be 5 digits
    $postal_code = $international ? $to->postal_code
                                  : substr($to->postal_code, 0, 5);

    $b = new Builder();
    $b->PostageRatesRequest
      ->nest(
        $this->authXML( $b )
        ->MailClass( $international ? 'International' : 'Domestic' )
        ->WeightOz( $weight )
        ->MailpieceShape('Parcel')
         ->MailpieceDimensions
           ->nest( $b->child()
             // Undocumented: Endicia can't handle dimensions with more than 3 decimal places. :|
             ->Length( number_format( $dimensions[0], 3) )
             ->Width(  number_format( $dimensions[1], 3) )
             ->Height( number_format( $dimensions[2], 3) )
           )
        ->FromPostalCode( $from->postal_code )
        ->ToPostalCode( $postal_code )
        ->ToCountryCode( $to->country )
      );

    return $b->string(true);
  }


  public function buildQuotes(){
    if ($this->response === null || $this->sxml === null)
      throw new \LogicException('buildQuote requires a parsed quote response before quotes can be assembled');

    $this->rates = array();
    foreach ($this->sxml->PostagePrice as $rate_response) {
      $this->rates[] = array(
        'MailClass'   => (string) $rate_response->MailClass,
        'MailService' => (string) $rate_response->Postage->MailService,
        'Postage'     => (float)  $rate_response['TotalAmount'],
      );
    }

  }
}
