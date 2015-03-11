<?php

namespace  SparkLib\UPS\Ship\SchemaType;

class PackingListInfoType
{

  /**
   *
   * @var PackageAssociatedType $PackageAssociated
   * @access public
   */
  public $PackageAssociated = null;

  /**
   *
   * @param PackageAssociatedType $PackageAssociated
   * @access public
   */
  public function __construct($PackageAssociated = null)
  {
    $this->PackageAssociated = $PackageAssociated;
  }

  /**
   *
   * @return PackageAssociatedType
   */
  public function getPackageAssociated()
  {
    return $this->PackageAssociated;
  }

  /**
   *
   * @param PackageAssociatedType $PackageAssociated
   */
  public function setPackageAssociated($PackageAssociated)
  {
    $this->PackageAssociated = $PackageAssociated;
  }

}
