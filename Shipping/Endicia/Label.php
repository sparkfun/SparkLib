<?php
namespace SparkLib\Shipping\Endicia;

use SparkLib\Shipping\Endicia;
use SparkLib\Xml\Builder;
use \SimpleXMLElement;

class Label extends Endicia {
  public $to, $from, $dimmensions, $weight;

  public $items = array();

  public function add_item($value, $quantity, $weight, $description, $hs_tariff = null, $origin_country = null){
    $i = new \stdClass();
    $i->value       = $value;
    $i->quantity    = $quantity;
    $i->weight      = $weight;
    $i->description = $description;
    $i->hs_tariff   = $hs_tariff;
    $i->origin_country = $origin_country;

    $this->items[] = $i;
  }

  public function label(){
    if ( ! $this->from instanceof Address)
      throw new \LogicException("From address must be a SparkLib\Shipping\Address. Set Quote#from before fetching quotes");
    if ( ! $this->to instanceof Address)
      throw new \LogicException("To address must be a SparkLib\Shipping\Address. Set Quote#to before fetching quotes");
    if ($this->dimensions === null || ! is_array($this->dimensions) || count($this->dimensions) != 3)
      throw new \LogicException('Dimensions must be set to 3 slot array before quoting');


    $this->request_type = 'GetPostageLabelXML';
    $this->post_prefix  = 'labelRequestXML';
    $this->xml          = $this->labelXML();

    $this->request();

    $this->parse_response();
    $this->check_status();

    return $this->rates;
  }

  public function labelXML(){
    $b = new Builder;
    $b->LabelRequest
      ->attribs(array(
        'Test'            => $this->test ? 'YES' : 'NO',
        'LabelType'       => 'Default', //Page 24: TODO Domestic?, International
        'LabelSubtype'    => 'None', //TODO Integrated
        'LabelSize'       => '4x6',
        'ImageFormat'     => 'ZPLII',
        // 'ImageResolution' => 203, // or 300
        // 'ImageRotation'   => 'Rotate180',
      ))
      ->nest( $this->mailClassXML($b)   )
      ->nest( $this->authXML($b)        )
      ->nest( $this->packageSpecXML($b)   )
      ->nest( $this->fromAddressXML($b) )
      ->nest( $this->toAddressXML()   )
      ->nest( $this->customsXML()     )
      ->nest( $b->child()
        // Functional flags
        ->ShowReturnAddress( 'TRUE' )
        ->Stealth( 'TRUE' )  // Hide the postage amount
        ->ValidateAddress( 'TRUE' )
      );

    return $b->string(true);
  }

  private function mailClassXML($b){
    return
      $b->child()
        //todo
        ->MailClass()
      ;
  }


  private function packageSpecXML($b){
    return
      $b->child()
        ->WeightOz( number_format( $this->weight, 1 ) )
        ->MailpieceShape( 'Parcel' )
        ->MailpieceDimensions
        ->nest( $b->child()
           ->Length( number_format( $this->dimensions[0], 3) )
           ->Width(  number_format( $this->dimensions[1], 3) )
           ->Height( number_format( $this->dimensions[2], 3) )
        )
    ;
  }

  private function fromAddressXML($b){
    // Starting point (or return address)
    return
    $b->child()
      ->FromName( $this->from->first_name . ' ' . $this->from->last_name )
      ->FromCompany( $this->from->company )
      ->ReturnAddress1( $this->from->address )
      ->ReturnAddress2( $this->from->address2 )
      ->FromCity( $this->from->city )
      ->FromState( $this->from->state )
      ->FromPostalCode( $this->from->postal_code )
      // ->FromZIP4( )
      // ->FromPhone( )
      // ->FromEMail( )
    ;
  }

  private function toAddressXML(){
    $b = new Builder;
    return
    $b->child()
      ->ToName( $this->to->first_name . ' ' . $this->to->last_name )
      ->ToCompany( $this->to->company )
      ->ToAddress1( $this->to->address )
      ->ToAddress2( $this->to->address2 )
      ->ToCity( $this->to->city )
      ->ToState( $this->to->state )
      ->ToPostalCode( $this->to->postal_code )
      // ->ToZIP4()
      ->ToCountryCode( $this->to->country )
      // ->ToPhone( )
      // ->ToEMail( )
    ;
  }

  public function customsXML(){
    $b = new Builder;
    $xml = $b->child()
        ->IntegratedFormType( 'Form2976' ) // Form2976A
        ->CustomsItems
        ->nest( $this->customsItemsXML() )
    ;

    return $xml;
  }

  public function customsItemsXML(){
    $f = function ($e) {
      $b = new Builder;
      return
        $b->child()
          ->CustomsItem
          ->nest( $b->child()
            ->Description(     $e->description    )
            ->Quantity(        $e->quantity       )
            ->Weight(          $e->weight         )
            ->Value(           $e->value          )
            ->HSTariffNumber(  $e->hs_tariff      )
            ->CountryOfOrigin( $e->origin_country )
          );
    };

    return array_map($f, $this->items);
  }

}
