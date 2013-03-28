<?php
namespace SparkLib\Shipping\Endicia;

use SparkLib\Shipping\Endicia,
  SparkLib\Shipping\Endicia\MailClass,
  SparkLib\Shipping\Address;

use SparkLib\Xml\Builder;
use \SimpleXMLElement;

class Label extends Endicia {
  public $to, $from, $dimmensions, $weight, $mail_class;

  public $items = array();

  public $label;

  public function addItem($value, $quantity, $weight, $description, $hs_tariff = null, $origin_country = null){
    $i = new \stdClass();
    $i->value       = $value;
    $i->quantity    = $quantity;
    $i->weight      = $weight;
    $i->description = $description;
    $i->hs_tariff   = $hs_tariff;
    $i->origin_country = $origin_country;

    $this->items[] = $i;
  }

  public function removeItems(){
    $this->items = array();
  }

  public function isValid(){
    try {
      return $this->validate();
    } catch (\LogicException $e) {
      return false;
    } catch (\InvalidArgumentException $e){
      return false;
    }
  }

  public function validate(){
    if ( ! $this->from instanceof Address)
      throw new \InvalidArgumentException("From address must be a SparkLib\Shipping\Address. Set Label#from before fetching quotes");


    if ( ! $this->to instanceof Address)
      throw new \InvalidArgumentException("To address must be a SparkLib\Shipping\Address. Set Label#to before fetching quotes");


    if ($this->dimensions === null || ! is_array($this->dimensions) || count($this->dimensions) != 3)
      throw new \LogicException('Dimensions must be set to 3 slot array before quoting: array(length, width, height)');


    if ( ! $this->mail_class instanceof MailCLass )
      throw new \InvalidArgumentException('$mail_class must be a SparkLib\Shipping\Endicia\MailClass.');

    if ( isset($this->mail_class->max_items) && $this->mail_class->max_items < count($this->items) )
      throw new \LogicException("Mail class {$this->mail_class->name} can only take {$this->mail_class->max_items} items. " . count($this->items) . " items given.");

    return true;
  }

  public function label(){
    $this->validate();

    $this->request_type = 'GetPostageLabelXML';
    $this->post_prefix  = 'labelRequestXML';
    $this->xml          = $this->labelXML();

    $this->request();

    $this->parse_response();
    $this->check_status();
    $this->fetchLabels();

    return $this->response;
  }

  public function labelXML(){
    $b = new Builder;
    $b->LabelRequest
      ->attribs(array(
        'Test'            => $this->test ? 'YES' : 'NO',
        'LabelType'       => $this->to->isDomestic() ? 'Default' : 'International', //Page 24: TODO Domestic?, International
        'LabelSubtype'    => $this->to->isDomestic() ? 'None'    : 'Integrated',
        'LabelSize'       => $this->labelSize(),
        'ImageFormat'     => $this->imageFormat(),
        // 'ImageResolution' => 203, // or 300
        // 'ImageRotation'   => 'Rotate180',
      ))
      ->nest( $this->mailClassXML($b)   )
      // ->nest( $this->authXML($b)        )
      ->nest( $b->child()
        ->RequesterID( $this->requester_id )
        ->AccountID( $this->account_number )
        ->PassPhrase( $this->password )
      )
      ->nest( $this->packageSpecXML($b)   )
      ->nest( $this->fromAddressXML($b) )
      ->nest( $this->toAddressXML()   )
      ->nest( $this->customsXML()     )
      ->nest( $b->child()
        // Functional flags
        ->ShowReturnAddress( 'TRUE' )
        ->Stealth( 'TRUE' )  // Hide the postage amount
        ->ValidateAddress( 'TRUE' )

        ->PartnerTransactionID('1234')
      );

    return $b->string(true);
  }

  private function labelSize(){
    if ($this->to->isDomestic())
      return '4x6';
    elseif ( count($this->items) <= 5 )
      return '4x6c';
    else
      return '';
  }

  private function imageFormat(){
    $labelSize = $this->labelSize();
    return $labelSize == '4x6' || $labelSize == '4x6c' ? 'ZPLII' : 'PDF' ;
  }

  private function mailClassXML(){
    $b = new Builder;
    $b->MailClass( $this->mail_class->name );

    return $b;
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

    $b->ToCity( $this->to->city );

    if ( isset($this->to->state) )
      $b->ToState( $this->to->state );

    $b->ToPostalCode( $postal_code )
      ->ToCountryCode( $this->to->country );

    if ( ! $this->to->blankPhone() )
      $b->ToPhone( $this->to->phone_number );

    if ( ! $this->from->blankEmail() )
      $b->ToEMail( $this->to->email );

      // ->ToZIP4( )
    return $b;
  }

  public function customsXML(){
    $b = new Builder;

    if ( ! $this->mail_class->isInternational() )
      return '';

    $xml = $b->child()
        ->IntegratedFormType( $this->mail_class->integrated_form )
        // ->CustomsCertify('TRUE')  // the customes information is certified to be correct and the CustomsSigner name should be printed
        // ->CustomsSigner('Yo Mamma')
        ->CustomsSendersCopy('FALSE')
        ->CustomsInfo
        ->nest( $this->customsInfoXML() )
    ;

    return $xml;
  }

  public function customsInfoXML() {
    $b = new Builder;
    $xml = $b->ContentsType('Merchandise') // Documents, Gift, Other (need explain), ReturnedGoods, Sample, HumanitarianDonation, DangerousGoods
              // ->ContentsExplanation('')       // 25 characters
              // ->RestrictionType('None')       // Other Quarantine SanitaryPhytosanitaryInspection
              // ->RestrictionComments('')       // 25 characters
              // ->SendersLcustomsReference('')  // 14 characters
              // ->ImportersCustomsReference('') // 40 characters
              // ->LicenseNumber('')             // 16 characters
              // ->CertificateNumber('')         // 12 characters
              // ->InvoiceNumber('')             // 15 characters
              // ->NonDeliveryOption('Abandon')  // Return
              // ->InsuredNumber('')             // 13 characters
              // ->EelPfc('')                    // 35 characters
             ->CustomsItems
             ->nest( $this->customsItemsXML() )
    ;

    return $xml;
  }

  public function customsItemsXML(){
    $f = function ($e) {
      $item_info = new Builder;
      $item_info->Description(     $e->description    )
                ->Quantity(        $e->quantity       )
                ->Weight(          $e->weight         )
                ->Value(           $e->value          )
      ->HSTariffNumber(  $e->hs_tariff      )
      ->CountryOfOrigin( $e->origin_country );

      $b = new Builder();
      return $b->CustomsItem->nest( $item_info );
    };

    return array_map($f, $this->items);
  }

  public function fetchLabels(){
    if ($this->response === null || $this->sxml === null)
      throw new \LogicException('fetchLabels requires a parsed and valid label response before quotes can be assembled');

    if ( isset($this->sxml->Base64LabelImage) ) {
      $data = $this->sxml->Base64LabelImage;
    } elseif ( isset($this->sxml->Label) )  {
      $data = $this->sxml->Label->Image;
    }

    $this->label = base64_decode( $data );


  }

}
