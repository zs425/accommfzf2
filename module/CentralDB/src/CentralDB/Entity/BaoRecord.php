<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaoRecords
 *
 * @ORM\Table(name="bao_records")
 * @ORM\Entity
 */
class BaoRecord
{
    /**
     * @var integer
     *
     * @ORM\Column(name="baorecord_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $baorecordId;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_name", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordName;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_shortdesc", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordShortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_category", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_source", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordSource;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_source_id", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordSourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_country", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_state", type="string", length=3, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordState;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_region", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordRegion;

    /**
     * @var integer
     *
     * @ORM\Column(name="baorecord_region_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordRegionId;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_area", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordArea;

    /**
     * @var integer
     *
     * @ORM\Column(name="baorecord_area_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordAreaId;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_city", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordCity;

    /**
     * @var integer
     *
     * @ORM\Column(name="baorecord_city_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordCityId;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_address", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_postcode", type="string", length=10, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordPostcode;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_phone", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_email", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_website", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordWebsite;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_lat", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordLat;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_lon", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordLon;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_photo", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordPhoto;

    /**
     * @var float
     *
     * @ORM\Column(name="baorecord_star_rating", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordStarRating;

    /**
     * @var float
     *
     * @ORM\Column(name="baorecord_lowrate", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordLowrate;

    /**
     * @var float
     *
     * @ORM\Column(name="baorecord_highrate", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordHighrate;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_rate_basis", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordRateBasis;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_checkin", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordCheckin;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_checkout", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordCheckout;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_frequency", type="string", length=180, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordFrequency;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_start", type="string", length=10, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordStart;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_end", type="string", length=10, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordEnd;

    /**
     * @var integer
     *
     * @ORM\Column(name="baorecord_created", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="baorecord_modified", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordModified;

    /**
     * @var boolean
     *
     * @ORM\Column(name="baorecord_deleted", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordDeleted;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_has_duplicate", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordHasDuplicate;

    /**
     * @var integer
     *
     * @ORM\Column(name="baorecord_duplicate_of", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordDuplicateOf;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecord_is_default", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordIsDefault;


    /**
     * Get baorecordId
     *
     * @return integer 
     */
    public function getBaorecordId()
    {
        return $this->baorecordId;
    }

    /**
     * Set baorecordName
     *
     * @param string $baorecordName
     * @return BaoRecords
     */
    public function setBaorecordName($baorecordName)
    {
        $this->baorecordName = $baorecordName;
    
        return $this;
    }

    /**
     * Get baorecordName
     *
     * @return string 
     */
    public function getBaorecordName()
    {
        return $this->baorecordName;
    }

    /**
     * Set baorecordShortdesc
     *
     * @param string $baorecordShortdesc
     * @return BaoRecords
     */
    public function setBaorecordShortdesc($baorecordShortdesc)
    {
        $this->baorecordShortdesc = $baorecordShortdesc;
    
        return $this;
    }

    /**
     * Get baorecordShortdesc
     *
     * @return string 
     */
    public function getBaorecordShortdesc()
    {
        return $this->baorecordShortdesc;
    }

    /**
     * Set baorecordDescription
     *
     * @param string $baorecordDescription
     * @return BaoRecords
     */
    public function setBaorecordDescription($baorecordDescription)
    {
        $this->baorecordDescription = $baorecordDescription;
    
        return $this;
    }

    /**
     * Get baorecordDescription
     *
     * @return string 
     */
    public function getBaorecordDescription()
    {
        return $this->baorecordDescription;
    }

    /**
     * Set baorecordCategory
     *
     * @param string $baorecordCategory
     * @return BaoRecords
     */
    public function setBaorecordCategory($baorecordCategory)
    {
        $this->baorecordCategory = $baorecordCategory;
    
        return $this;
    }

    /**
     * Get baorecordCategory
     *
     * @return string 
     */
    public function getBaorecordCategory()
    {
        return $this->baorecordCategory;
    }

    /**
     * Set baorecordSource
     *
     * @param string $baorecordSource
     * @return BaoRecords
     */
    public function setBaorecordSource($baorecordSource)
    {
        $this->baorecordSource = $baorecordSource;
    
        return $this;
    }

    /**
     * Get baorecordSource
     *
     * @return string 
     */
    public function getBaorecordSource()
    {
        return $this->baorecordSource;
    }

    /**
     * Set baorecordSourceId
     *
     * @param string $baorecordSourceId
     * @return BaoRecords
     */
    public function setBaorecordSourceId($baorecordSourceId)
    {
        $this->baorecordSourceId = $baorecordSourceId;
    
        return $this;
    }

    /**
     * Get baorecordSourceId
     *
     * @return string 
     */
    public function getBaorecordSourceId()
    {
        return $this->baorecordSourceId;
    }

    /**
     * Set baorecordCountry
     *
     * @param string $baorecordCountry
     * @return BaoRecords
     */
    public function setBaorecordCountry($baorecordCountry)
    {
        $this->baorecordCountry = $baorecordCountry;
    
        return $this;
    }

    /**
     * Get baorecordCountry
     *
     * @return string 
     */
    public function getBaorecordCountry()
    {
        return $this->baorecordCountry;
    }

    /**
     * Set baorecordState
     *
     * @param string $baorecordState
     * @return BaoRecords
     */
    public function setBaorecordState($baorecordState)
    {
        $this->baorecordState = $baorecordState;
    
        return $this;
    }

    /**
     * Get baorecordState
     *
     * @return string 
     */
    public function getBaorecordState()
    {
        return $this->baorecordState;
    }

    /**
     * Set baorecordRegion
     *
     * @param string $baorecordRegion
     * @return BaoRecords
     */
    public function setBaorecordRegion($baorecordRegion)
    {
        $this->baorecordRegion = $baorecordRegion;
    
        return $this;
    }

    /**
     * Get baorecordRegion
     *
     * @return string 
     */
    public function getBaorecordRegion()
    {
        return $this->baorecordRegion;
    }

    /**
     * Set baorecordRegionId
     *
     * @param integer $baorecordRegionId
     * @return BaoRecords
     */
    public function setBaorecordRegionId($baorecordRegionId)
    {
        $this->baorecordRegionId = $baorecordRegionId;
    
        return $this;
    }

    /**
     * Get baorecordRegionId
     *
     * @return integer 
     */
    public function getBaorecordRegionId()
    {
        return $this->baorecordRegionId;
    }

    /**
     * Set baorecordArea
     *
     * @param string $baorecordArea
     * @return BaoRecords
     */
    public function setBaorecordArea($baorecordArea)
    {
        $this->baorecordArea = $baorecordArea;
    
        return $this;
    }

    /**
     * Get baorecordArea
     *
     * @return string 
     */
    public function getBaorecordArea()
    {
        return $this->baorecordArea;
    }

    /**
     * Set baorecordAreaId
     *
     * @param integer $baorecordAreaId
     * @return BaoRecords
     */
    public function setBaorecordAreaId($baorecordAreaId)
    {
        $this->baorecordAreaId = $baorecordAreaId;
    
        return $this;
    }

    /**
     * Get baorecordAreaId
     *
     * @return integer 
     */
    public function getBaorecordAreaId()
    {
        return $this->baorecordAreaId;
    }

    /**
     * Set baorecordCity
     *
     * @param string $baorecordCity
     * @return BaoRecords
     */
    public function setBaorecordCity($baorecordCity)
    {
        $this->baorecordCity = $baorecordCity;
    
        return $this;
    }

    /**
     * Get baorecordCity
     *
     * @return string 
     */
    public function getBaorecordCity()
    {
        return $this->baorecordCity;
    }

    /**
     * Set baorecordCityId
     *
     * @param integer $baorecordCityId
     * @return BaoRecords
     */
    public function setBaorecordCityId($baorecordCityId)
    {
        $this->baorecordCityId = $baorecordCityId;
    
        return $this;
    }

    /**
     * Get baorecordCityId
     *
     * @return integer 
     */
    public function getBaorecordCityId()
    {
        return $this->baorecordCityId;
    }

    /**
     * Set baorecordAddress
     *
     * @param string $baorecordAddress
     * @return BaoRecords
     */
    public function setBaorecordAddress($baorecordAddress)
    {
        $this->baorecordAddress = $baorecordAddress;
    
        return $this;
    }

    /**
     * Get baorecordAddress
     *
     * @return string 
     */
    public function getBaorecordAddress()
    {
        return $this->baorecordAddress;
    }

    /**
     * Set baorecordPostcode
     *
     * @param string $baorecordPostcode
     * @return BaoRecords
     */
    public function setBaorecordPostcode($baorecordPostcode)
    {
        $this->baorecordPostcode = $baorecordPostcode;
    
        return $this;
    }

    /**
     * Get baorecordPostcode
     *
     * @return string 
     */
    public function getBaorecordPostcode()
    {
        return $this->baorecordPostcode;
    }

    /**
     * Set baorecordPhone
     *
     * @param string $baorecordPhone
     * @return BaoRecords
     */
    public function setBaorecordPhone($baorecordPhone)
    {
        $this->baorecordPhone = $baorecordPhone;
    
        return $this;
    }

    /**
     * Get baorecordPhone
     *
     * @return string 
     */
    public function getBaorecordPhone()
    {
        return $this->baorecordPhone;
    }

    /**
     * Set baorecordEmail
     *
     * @param string $baorecordEmail
     * @return BaoRecords
     */
    public function setBaorecordEmail($baorecordEmail)
    {
        $this->baorecordEmail = $baorecordEmail;
    
        return $this;
    }

    /**
     * Get baorecordEmail
     *
     * @return string 
     */
    public function getBaorecordEmail()
    {
        return $this->baorecordEmail;
    }

    /**
     * Set baorecordWebsite
     *
     * @param string $baorecordWebsite
     * @return BaoRecords
     */
    public function setBaorecordWebsite($baorecordWebsite)
    {
        $this->baorecordWebsite = $baorecordWebsite;
    
        return $this;
    }

    /**
     * Get baorecordWebsite
     *
     * @return string 
     */
    public function getBaorecordWebsite()
    {
        return $this->baorecordWebsite;
    }

    /**
     * Set baorecordLat
     *
     * @param string $baorecordLat
     * @return BaoRecords
     */
    public function setBaorecordLat($baorecordLat)
    {
        $this->baorecordLat = $baorecordLat;
    
        return $this;
    }

    /**
     * Get baorecordLat
     *
     * @return string 
     */
    public function getBaorecordLat()
    {
        return $this->baorecordLat;
    }

    /**
     * Set baorecordLon
     *
     * @param string $baorecordLon
     * @return BaoRecords
     */
    public function setBaorecordLon($baorecordLon)
    {
        $this->baorecordLon = $baorecordLon;
    
        return $this;
    }

    /**
     * Get baorecordLon
     *
     * @return string 
     */
    public function getBaorecordLon()
    {
        return $this->baorecordLon;
    }

    /**
     * Set baorecordPhoto
     *
     * @param string $baorecordPhoto
     * @return BaoRecords
     */
    public function setBaorecordPhoto($baorecordPhoto)
    {
        $this->baorecordPhoto = $baorecordPhoto;
    
        return $this;
    }

    /**
     * Get baorecordPhoto
     *
     * @return string 
     */
    public function getBaorecordPhoto()
    {
        return $this->baorecordPhoto;
    }

    /**
     * Set baorecordStarRating
     *
     * @param float $baorecordStarRating
     * @return BaoRecords
     */
    public function setBaorecordStarRating($baorecordStarRating)
    {
        $this->baorecordStarRating = $baorecordStarRating;
    
        return $this;
    }

    /**
     * Get baorecordStarRating
     *
     * @return float 
     */
    public function getBaorecordStarRating()
    {
        return $this->baorecordStarRating;
    }

    /**
     * Set baorecordLowrate
     *
     * @param float $baorecordLowrate
     * @return BaoRecords
     */
    public function setBaorecordLowrate($baorecordLowrate)
    {
        $this->baorecordLowrate = $baorecordLowrate;
    
        return $this;
    }

    /**
     * Get baorecordLowrate
     *
     * @return float 
     */
    public function getBaorecordLowrate()
    {
        return $this->baorecordLowrate;
    }

    /**
     * Set baorecordHighrate
     *
     * @param float $baorecordHighrate
     * @return BaoRecords
     */
    public function setBaorecordHighrate($baorecordHighrate)
    {
        $this->baorecordHighrate = $baorecordHighrate;
    
        return $this;
    }

    /**
     * Get baorecordHighrate
     *
     * @return float 
     */
    public function getBaorecordHighrate()
    {
        return $this->baorecordHighrate;
    }

    /**
     * Set baorecordRateBasis
     *
     * @param string $baorecordRateBasis
     * @return BaoRecords
     */
    public function setBaorecordRateBasis($baorecordRateBasis)
    {
        $this->baorecordRateBasis = $baorecordRateBasis;
    
        return $this;
    }

    /**
     * Get baorecordRateBasis
     *
     * @return string 
     */
    public function getBaorecordRateBasis()
    {
        return $this->baorecordRateBasis;
    }

    /**
     * Set baorecordCheckin
     *
     * @param string $baorecordCheckin
     * @return BaoRecords
     */
    public function setBaorecordCheckin($baorecordCheckin)
    {
        $this->baorecordCheckin = $baorecordCheckin;
    
        return $this;
    }

    /**
     * Get baorecordCheckin
     *
     * @return string 
     */
    public function getBaorecordCheckin()
    {
        return $this->baorecordCheckin;
    }

    /**
     * Set baorecordCheckout
     *
     * @param string $baorecordCheckout
     * @return BaoRecords
     */
    public function setBaorecordCheckout($baorecordCheckout)
    {
        $this->baorecordCheckout = $baorecordCheckout;
    
        return $this;
    }

    /**
     * Get baorecordCheckout
     *
     * @return string 
     */
    public function getBaorecordCheckout()
    {
        return $this->baorecordCheckout;
    }

    /**
     * Set baorecordFrequency
     *
     * @param string $baorecordFrequency
     * @return BaoRecords
     */
    public function setBaorecordFrequency($baorecordFrequency)
    {
        $this->baorecordFrequency = $baorecordFrequency;
    
        return $this;
    }

    /**
     * Get baorecordFrequency
     *
     * @return string 
     */
    public function getBaorecordFrequency()
    {
        return $this->baorecordFrequency;
    }

    /**
     * Set baorecordStart
     *
     * @param string $baorecordStart
     * @return BaoRecords
     */
    public function setBaorecordStart($baorecordStart)
    {
        $this->baorecordStart = $baorecordStart;
    
        return $this;
    }

    /**
     * Get baorecordStart
     *
     * @return string 
     */
    public function getBaorecordStart()
    {
        return $this->baorecordStart;
    }

    /**
     * Set baorecordEnd
     *
     * @param string $baorecordEnd
     * @return BaoRecords
     */
    public function setBaorecordEnd($baorecordEnd)
    {
        $this->baorecordEnd = $baorecordEnd;
    
        return $this;
    }

    /**
     * Get baorecordEnd
     *
     * @return string 
     */
    public function getBaorecordEnd()
    {
        return $this->baorecordEnd;
    }

    /**
     * Set baorecordCreated
     *
     * @param integer $baorecordCreated
     * @return BaoRecords
     */
    public function setBaorecordCreated($baorecordCreated)
    {
        $this->baorecordCreated = $baorecordCreated;
    
        return $this;
    }

    /**
     * Get baorecordCreated
     *
     * @return integer 
     */
    public function getBaorecordCreated()
    {
        return $this->baorecordCreated;
    }

    /**
     * Set baorecordModified
     *
     * @param integer $baorecordModified
     * @return BaoRecords
     */
    public function setBaorecordModified($baorecordModified)
    {
        $this->baorecordModified = $baorecordModified;
    
        return $this;
    }

    /**
     * Get baorecordModified
     *
     * @return integer 
     */
    public function getBaorecordModified()
    {
        return $this->baorecordModified;
    }

    /**
     * Set baorecordDeleted
     *
     * @param boolean $baorecordDeleted
     * @return BaoRecords
     */
    public function setBaorecordDeleted($baorecordDeleted)
    {
        $this->baorecordDeleted = $baorecordDeleted;
    
        return $this;
    }

    /**
     * Get baorecordDeleted
     *
     * @return boolean 
     */
    public function getBaorecordDeleted()
    {
        return $this->baorecordDeleted;
    }

    /**
     * Set baorecordHasDuplicate
     *
     * @param string $baorecordHasDuplicate
     * @return BaoRecords
     */
    public function setBaorecordHasDuplicate($baorecordHasDuplicate)
    {
        $this->baorecordHasDuplicate = $baorecordHasDuplicate;
    
        return $this;
    }

    /**
     * Get baorecordHasDuplicate
     *
     * @return string 
     */
    public function getBaorecordHasDuplicate()
    {
        return $this->baorecordHasDuplicate;
    }

    /**
     * Set baorecordDuplicateOf
     *
     * @param integer $baorecordDuplicateOf
     * @return BaoRecords
     */
    public function setBaorecordDuplicateOf($baorecordDuplicateOf)
    {
        $this->baorecordDuplicateOf = $baorecordDuplicateOf;
    
        return $this;
    }

    /**
     * Get baorecordDuplicateOf
     *
     * @return integer 
     */
    public function getBaorecordDuplicateOf()
    {
        return $this->baorecordDuplicateOf;
    }

    /**
     * Set baorecordIsDefault
     *
     * @param string $baorecordIsDefault
     * @return BaoRecords
     */
    public function setBaorecordIsDefault($baorecordIsDefault)
    {
        $this->baorecordIsDefault = $baorecordIsDefault;
    
        return $this;
    }

    /**
     * Get baorecordIsDefault
     *
     * @return string 
     */
    public function getBaorecordIsDefault()
    {
        return $this->baorecordIsDefault;
    }
	
	public function setByArray($array){
        foreach($array as $key => $value) {
            if(method_exists($this, 'set'.ucfirst($key))) {
                $this->{'set'.ucfirst($key)}($value);    
            }            
        }
        return $this;
    }
    
    public function getByArray() {
        return get_object_vars($this);        
    }
}
