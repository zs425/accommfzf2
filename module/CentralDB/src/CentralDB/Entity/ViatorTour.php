<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ViatorTours
 *
 * @ORM\Table(name="viator_tours")
 * @ORM\Entity
 */
class ViatorTour
{
    /**
     * @var integer
     *
     * @ORM\Column(name="viatortour_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $viatortourId;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_code", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCode;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_name", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourName;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_introduction", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourIntroduction;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="viatortour_special", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourSpecial;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_duration", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourDuration;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_commences", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCommences;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_image", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourImage;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_thumb", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourThumb;

    /**
     * @var integer
     *
     * @ORM\Column(name="viatortour_destination_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourDestinationId;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_country", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_region", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_city", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCity;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_destination_code", type="string", length=10, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourDestinationCode;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_group1", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourGroup1;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_category1", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCategory1;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_subcategory1", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourSubcategory1;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_group2", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourGroup2;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_category2", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCategory2;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_subcategory2", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourSubcategory2;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_group3", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourGroup3;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_category3", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCategory3;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_subcategory3", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourSubcategory3;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_url", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourUrl;

    /**
     * @var float
     *
     * @ORM\Column(name="viatortour_price", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_pricefrom", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourPricefrom;

    /**
     * @var float
     *
     * @ORM\Column(name="viatortour_rating", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourRating;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_rating_star_url", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourRatingStarUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="viatortour_booking_type", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourBookingType;

    /**
     * @var integer
     *
     * @ORM\Column(name="viatortour_created", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="viatortour_modified", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $viatortourModified;


    /**
     * Get viatortourId
     *
     * @return integer 
     */
    public function getViatortourId()
    {
        return $this->viatortourId;
    }

    /**
     * Set viatortourCode
     *
     * @param string $viatortourCode
     * @return ViatorTours
     */
    public function setViatortourCode($viatortourCode)
    {
        $this->viatortourCode = $viatortourCode;
    
        return $this;
    }

    /**
     * Get viatortourCode
     *
     * @return string 
     */
    public function getViatortourCode()
    {
        return $this->viatortourCode;
    }

    /**
     * Set viatortourName
     *
     * @param string $viatortourName
     * @return ViatorTours
     */
    public function setViatortourName($viatortourName)
    {
        $this->viatortourName = $viatortourName;
    
        return $this;
    }

    /**
     * Get viatortourName
     *
     * @return string 
     */
    public function getViatortourName()
    {
        return $this->viatortourName;
    }

    /**
     * Set viatortourIntroduction
     *
     * @param string $viatortourIntroduction
     * @return ViatorTours
     */
    public function setViatortourIntroduction($viatortourIntroduction)
    {
        $this->viatortourIntroduction = $viatortourIntroduction;
    
        return $this;
    }

    /**
     * Get viatortourIntroduction
     *
     * @return string 
     */
    public function getViatortourIntroduction()
    {
        return $this->viatortourIntroduction;
    }

    /**
     * Set viatortourDescription
     *
     * @param string $viatortourDescription
     * @return ViatorTours
     */
    public function setViatortourDescription($viatortourDescription)
    {
        $this->viatortourDescription = $viatortourDescription;
    
        return $this;
    }

    /**
     * Get viatortourDescription
     *
     * @return string 
     */
    public function getViatortourDescription()
    {
        return $this->viatortourDescription;
    }

    /**
     * Set viatortourSpecial
     *
     * @param boolean $viatortourSpecial
     * @return ViatorTours
     */
    public function setViatortourSpecial($viatortourSpecial)
    {
        $this->viatortourSpecial = $viatortourSpecial;
    
        return $this;
    }

    /**
     * Get viatortourSpecial
     *
     * @return boolean 
     */
    public function getViatortourSpecial()
    {
        return $this->viatortourSpecial;
    }

    /**
     * Set viatortourDuration
     *
     * @param string $viatortourDuration
     * @return ViatorTours
     */
    public function setViatortourDuration($viatortourDuration)
    {
        $this->viatortourDuration = $viatortourDuration;
    
        return $this;
    }

    /**
     * Get viatortourDuration
     *
     * @return string 
     */
    public function getViatortourDuration()
    {
        return $this->viatortourDuration;
    }

    /**
     * Set viatortourCommences
     *
     * @param string $viatortourCommences
     * @return ViatorTours
     */
    public function setViatortourCommences($viatortourCommences)
    {
        $this->viatortourCommences = $viatortourCommences;
    
        return $this;
    }

    /**
     * Get viatortourCommences
     *
     * @return string 
     */
    public function getViatortourCommences()
    {
        return $this->viatortourCommences;
    }

    /**
     * Set viatortourImage
     *
     * @param string $viatortourImage
     * @return ViatorTours
     */
    public function setViatortourImage($viatortourImage)
    {
        $this->viatortourImage = $viatortourImage;
    
        return $this;
    }

    /**
     * Get viatortourImage
     *
     * @return string 
     */
    public function getViatortourImage()
    {
        return $this->viatortourImage;
    }

    /**
     * Set viatortourThumb
     *
     * @param string $viatortourThumb
     * @return ViatorTours
     */
    public function setViatortourThumb($viatortourThumb)
    {
        $this->viatortourThumb = $viatortourThumb;
    
        return $this;
    }

    /**
     * Get viatortourThumb
     *
     * @return string 
     */
    public function getViatortourThumb()
    {
        return $this->viatortourThumb;
    }

    /**
     * Set viatortourDestinationId
     *
     * @param integer $viatortourDestinationId
     * @return ViatorTours
     */
    public function setViatortourDestinationId($viatortourDestinationId)
    {
        $this->viatortourDestinationId = $viatortourDestinationId;
    
        return $this;
    }

    /**
     * Get viatortourDestinationId
     *
     * @return integer 
     */
    public function getViatortourDestinationId()
    {
        return $this->viatortourDestinationId;
    }

    /**
     * Set viatortourCountry
     *
     * @param string $viatortourCountry
     * @return ViatorTours
     */
    public function setViatortourCountry($viatortourCountry)
    {
        $this->viatortourCountry = $viatortourCountry;
    
        return $this;
    }

    /**
     * Get viatortourCountry
     *
     * @return string 
     */
    public function getViatortourCountry()
    {
        return $this->viatortourCountry;
    }

    /**
     * Set viatortourRegion
     *
     * @param string $viatortourRegion
     * @return ViatorTours
     */
    public function setViatortourRegion($viatortourRegion)
    {
        $this->viatortourRegion = $viatortourRegion;
    
        return $this;
    }

    /**
     * Get viatortourRegion
     *
     * @return string 
     */
    public function getViatortourRegion()
    {
        return $this->viatortourRegion;
    }

    /**
     * Set viatortourCity
     *
     * @param string $viatortourCity
     * @return ViatorTours
     */
    public function setViatortourCity($viatortourCity)
    {
        $this->viatortourCity = $viatortourCity;
    
        return $this;
    }

    /**
     * Get viatortourCity
     *
     * @return string 
     */
    public function getViatortourCity()
    {
        return $this->viatortourCity;
    }

    /**
     * Set viatortourDestinationCode
     *
     * @param string $viatortourDestinationCode
     * @return ViatorTours
     */
    public function setViatortourDestinationCode($viatortourDestinationCode)
    {
        $this->viatortourDestinationCode = $viatortourDestinationCode;
    
        return $this;
    }

    /**
     * Get viatortourDestinationCode
     *
     * @return string 
     */
    public function getViatortourDestinationCode()
    {
        return $this->viatortourDestinationCode;
    }

    /**
     * Set viatortourGroup1
     *
     * @param string $viatortourGroup1
     * @return ViatorTours
     */
    public function setViatortourGroup1($viatortourGroup1)
    {
        $this->viatortourGroup1 = $viatortourGroup1;
    
        return $this;
    }

    /**
     * Get viatortourGroup1
     *
     * @return string 
     */
    public function getViatortourGroup1()
    {
        return $this->viatortourGroup1;
    }

    /**
     * Set viatortourCategory1
     *
     * @param string $viatortourCategory1
     * @return ViatorTours
     */
    public function setViatortourCategory1($viatortourCategory1)
    {
        $this->viatortourCategory1 = $viatortourCategory1;
    
        return $this;
    }

    /**
     * Get viatortourCategory1
     *
     * @return string 
     */
    public function getViatortourCategory1()
    {
        return $this->viatortourCategory1;
    }

    /**
     * Set viatortourSubcategory1
     *
     * @param string $viatortourSubcategory1
     * @return ViatorTours
     */
    public function setViatortourSubcategory1($viatortourSubcategory1)
    {
        $this->viatortourSubcategory1 = $viatortourSubcategory1;
    
        return $this;
    }

    /**
     * Get viatortourSubcategory1
     *
     * @return string 
     */
    public function getViatortourSubcategory1()
    {
        return $this->viatortourSubcategory1;
    }

    /**
     * Set viatortourGroup2
     *
     * @param string $viatortourGroup2
     * @return ViatorTours
     */
    public function setViatortourGroup2($viatortourGroup2)
    {
        $this->viatortourGroup2 = $viatortourGroup2;
    
        return $this;
    }

    /**
     * Get viatortourGroup2
     *
     * @return string 
     */
    public function getViatortourGroup2()
    {
        return $this->viatortourGroup2;
    }

    /**
     * Set viatortourCategory2
     *
     * @param string $viatortourCategory2
     * @return ViatorTours
     */
    public function setViatortourCategory2($viatortourCategory2)
    {
        $this->viatortourCategory2 = $viatortourCategory2;
    
        return $this;
    }

    /**
     * Get viatortourCategory2
     *
     * @return string 
     */
    public function getViatortourCategory2()
    {
        return $this->viatortourCategory2;
    }

    /**
     * Set viatortourSubcategory2
     *
     * @param string $viatortourSubcategory2
     * @return ViatorTours
     */
    public function setViatortourSubcategory2($viatortourSubcategory2)
    {
        $this->viatortourSubcategory2 = $viatortourSubcategory2;
    
        return $this;
    }

    /**
     * Get viatortourSubcategory2
     *
     * @return string 
     */
    public function getViatortourSubcategory2()
    {
        return $this->viatortourSubcategory2;
    }

    /**
     * Set viatortourGroup3
     *
     * @param string $viatortourGroup3
     * @return ViatorTours
     */
    public function setViatortourGroup3($viatortourGroup3)
    {
        $this->viatortourGroup3 = $viatortourGroup3;
    
        return $this;
    }

    /**
     * Get viatortourGroup3
     *
     * @return string 
     */
    public function getViatortourGroup3()
    {
        return $this->viatortourGroup3;
    }

    /**
     * Set viatortourCategory3
     *
     * @param string $viatortourCategory3
     * @return ViatorTours
     */
    public function setViatortourCategory3($viatortourCategory3)
    {
        $this->viatortourCategory3 = $viatortourCategory3;
    
        return $this;
    }

    /**
     * Get viatortourCategory3
     *
     * @return string 
     */
    public function getViatortourCategory3()
    {
        return $this->viatortourCategory3;
    }

    /**
     * Set viatortourSubcategory3
     *
     * @param string $viatortourSubcategory3
     * @return ViatorTours
     */
    public function setViatortourSubcategory3($viatortourSubcategory3)
    {
        $this->viatortourSubcategory3 = $viatortourSubcategory3;
    
        return $this;
    }

    /**
     * Get viatortourSubcategory3
     *
     * @return string 
     */
    public function getViatortourSubcategory3()
    {
        return $this->viatortourSubcategory3;
    }

    /**
     * Set viatortourUrl
     *
     * @param string $viatortourUrl
     * @return ViatorTours
     */
    public function setViatortourUrl($viatortourUrl)
    {
        $this->viatortourUrl = $viatortourUrl;
    
        return $this;
    }

    /**
     * Get viatortourUrl
     *
     * @return string 
     */
    public function getViatortourUrl()
    {
        return $this->viatortourUrl;
    }

    /**
     * Set viatortourPrice
     *
     * @param float $viatortourPrice
     * @return ViatorTours
     */
    public function setViatortourPrice($viatortourPrice)
    {
        $this->viatortourPrice = $viatortourPrice;
    
        return $this;
    }

    /**
     * Get viatortourPrice
     *
     * @return float 
     */
    public function getViatortourPrice()
    {
        return $this->viatortourPrice;
    }

    /**
     * Set viatortourPricefrom
     *
     * @param string $viatortourPricefrom
     * @return ViatorTours
     */
    public function setViatortourPricefrom($viatortourPricefrom)
    {
        $this->viatortourPricefrom = $viatortourPricefrom;
    
        return $this;
    }

    /**
     * Get viatortourPricefrom
     *
     * @return string 
     */
    public function getViatortourPricefrom()
    {
        return $this->viatortourPricefrom;
    }

    /**
     * Set viatortourRating
     *
     * @param float $viatortourRating
     * @return ViatorTours
     */
    public function setViatortourRating($viatortourRating)
    {
        $this->viatortourRating = $viatortourRating;
    
        return $this;
    }

    /**
     * Get viatortourRating
     *
     * @return float 
     */
    public function getViatortourRating()
    {
        return $this->viatortourRating;
    }

    /**
     * Set viatortourRatingStarUrl
     *
     * @param string $viatortourRatingStarUrl
     * @return ViatorTours
     */
    public function setViatortourRatingStarUrl($viatortourRatingStarUrl)
    {
        $this->viatortourRatingStarUrl = $viatortourRatingStarUrl;
    
        return $this;
    }

    /**
     * Get viatortourRatingStarUrl
     *
     * @return string 
     */
    public function getViatortourRatingStarUrl()
    {
        return $this->viatortourRatingStarUrl;
    }

    /**
     * Set viatortourBookingType
     *
     * @param string $viatortourBookingType
     * @return ViatorTours
     */
    public function setViatortourBookingType($viatortourBookingType)
    {
        $this->viatortourBookingType = $viatortourBookingType;
    
        return $this;
    }

    /**
     * Get viatortourBookingType
     *
     * @return string 
     */
    public function getViatortourBookingType()
    {
        return $this->viatortourBookingType;
    }

    /**
     * Set viatortourCreated
     *
     * @param integer $viatortourCreated
     * @return ViatorTours
     */
    public function setViatortourCreated($viatortourCreated)
    {
        $this->viatortourCreated = $viatortourCreated;
    
        return $this;
    }

    /**
     * Get viatortourCreated
     *
     * @return integer 
     */
    public function getViatortourCreated()
    {
        return $this->viatortourCreated;
    }

    /**
     * Set viatortourModified
     *
     * @param integer $viatortourModified
     * @return ViatorTours
     */
    public function setViatortourModified($viatortourModified)
    {
        $this->viatortourModified = $viatortourModified;
    
        return $this;
    }

    /**
     * Get viatortourModified
     *
     * @return integer 
     */
    public function getViatortourModified()
    {
        return $this->viatortourModified;
    }
}
