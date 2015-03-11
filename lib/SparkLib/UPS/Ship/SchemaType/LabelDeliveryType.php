<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class LabelDeliveryType
{

  /**
   *
   * @var EmailDetailsType $EMail
   * @access public
   */
  public $EMail = null;

  /**
   *
   * @var string $LabelLinksIndicator
   * @access public
   */
  public $LabelLinksIndicator = null;

  /**
   *
   * @param EmailDetailsType $EMail
   * @param string $LabelLinksIndicator
   * @access public
   */
  public function __construct($EMail = null, $LabelLinksIndicator = null)
  {
    $this->EMail = $EMail;
    $this->LabelLinksIndicator = $LabelLinksIndicator;
  }

  /**
   *
   * @return EmailDetailsType
   */
  public function getEMail()
  {
    return $this->EMail;
  }

  /**
   *
   * @param EmailDetailsType $EMail
   */
  public function setEMail($EMail)
  {
    $this->EMail = $EMail;
  }

  /**
   *
   * @return string
   */
  public function getLabelLinksIndicator()
  {
    return $this->LabelLinksIndicator;
  }

  /**
   *
   * @param string $LabelLinksIndicator
   */
  public function setLabelLinksIndicator($LabelLinksIndicator)
  {
    $this->LabelLinksIndicator = $LabelLinksIndicator;
  }

}
