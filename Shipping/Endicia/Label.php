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

  private function fromAddressXML(){
    // Starting point (or return address)
    $b = new Builder;

    $postal_code = $this->from->isDomestic()  ? $this->from->trimPostalCode()
                                              : $this->from->postal_code;

    if ( ! $this->from->blankName() )
      $b->FromName( $this->from->fullName() );

    if ( ! $this->from->blankCompany() )
      $b->FromCompany( $this->from->company );

    $b->ReturnAddress1( $this->from->address );

    if ( ! $this->from->blankAddress2() )
      $b->ReturnAddress2( $this->from->address2 );

    $b->FromCity( $this->from->city )
      ->FromState( $this->from->state )
      ->FromPostalCode( $postal_code );

    if ( ! $this->from->blankPhone() )
      $b->FromPhone( $this->from->phone_number );

    if ( ! $this->from->blankEmail() )
      $b->FromEMail( $this->from->email );

      // ->FromZIP4( )
    return $b;
  }

  /* In an ideal world, this would be the same code as the from address,
   * perhaps with a different container or something.  Instead, we have to
   * copypasta.
   */
  private function toAddressXML(){
    $b = new Builder;

    $postal_code = $this->to->isDomestic()  ? $this->to->trimPostalCode()
                                              : $this->to->postal_code;

    if ( ! $this->to->blankName() )
      $b->ToName( $this->to->fullName() );

    if ( ! $this->to->blankCompany() )
      $b->ToCompany( $this->from->company );

    $b->ToAddress1( $this->to->address );

    if ( ! $this->to->blankAddress2() )
      $b->ToAddress2( $this->to->address2 );

    $b->ToCity( $this->to->city )
      ->ToState( $this->to->state )
      ->ToPostalCode( $postal_code )
      ->ToCountryCode( $this->to->country )
    ;

    if ( ! $this->to->blankPhone() )
      $b->ToPhone( $this->to->phone_number );

    if ( ! $this->from->blankEmail() )
      $b->ToEMail( $this->to->email );

      // ->ToZIP4( )
    return $b;
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
