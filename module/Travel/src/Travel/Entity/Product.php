<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="products")
 * @ORM\Entity
 */
class Product
{
    
    /**
     * @ORM\OneToMany(targetEntity="Travel\Entity\ProductMultimedia", mappedBy="multimediaRecordId")
     */
    protected $productMultimedia;
    
    public function __construct() {
        $this->$productMultimedia = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255, nullable=true)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="product_shortdesc", type="text", nullable=true)
     */
    private $productShortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="product_description", type="text", nullable=true)
     */
    private $productDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="product_category", type="string", length=45, nullable=true)
     */
    private $productCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="product_source", type="string", length=45, nullable=true)
     */
    private $productSource;

    /**
     * @var string
     *
     * @ORM\Column(name="product_source_id", type="string", length=255, nullable=true)
     */
    private $productSourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_country", type="string", length=45, nullable=true)
     */
    private $productCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="product_state", type="string", length=3, nullable=true)
     */
    private $productState;

    /**
     * @var string
     *
     * @ORM\Column(name="product_region", type="string", length=255, nullable=true)
     */
    private $productRegion;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_region_id", type="integer", nullable=true)
     */
    private $productRegionId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_area", type="string", length=255, nullable=true)
     */
    private $productArea;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_area_id", type="integer", nullable=true)
     */
    private $productAreaId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_city", type="string", length=255, nullable=true)
     */
    private $productCity;

    /**
     * @var string
     *
     * @ORM\Column(name="product_address", type="text", nullable=true)
     */
    private $productAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="product_phone", type="string", length=90, nullable=true)
     */
    private $productPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="product_email", type="string", length=255, nullable=true)
     */
    private $productEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="product_website", type="string", length=255, nullable=true)
     */
    private $productWebsite;

    /**
     * @var string
     *
     * @ORM\Column(name="product_lat", type="string", length=45, nullable=true)
     */
    private $productLat;

    /**
     * @var string
     *
     * @ORM\Column(name="product_lon", type="string", length=45, nullable=true)
     */
    private $productLon;

    /**
     * @var string
     *
     * @ORM\Column(name="product_photo", type="string", length=255, nullable=true)
     */
    private $productPhoto;

    /**
     * @var float
     *
     * @ORM\Column(name="product_star_rating", type="decimal", nullable=true)
     */
    private $productStarRating;

    /**
     * @var float
     *
     * @ORM\Column(name="product_lowrate", type="decimal", nullable=true)
     */
    private $productLowrate;

    /**
     * @var float
     *
     * @ORM\Column(name="product_highrate", type="decimal", nullable=true)
     */
    private $productHighrate;

    /**
     * @var string
     *
     * @ORM\Column(name="product_rate_basis", type="string", length=45, nullable=true)
     */
    private $productRateBasis;

    /**
     * @var string
     *
     * @ORM\Column(name="product_checkin", type="string", length=255, nullable=true)
     */
    private $productCheckin;

    /**
     * @var string
     *
     * @ORM\Column(name="product_checkout", type="string", length=45, nullable=true)
     */
    private $productCheckout;

    /**
     * @var string
     *
     * @ORM\Column(name="product_bookable", type="string", length=90, nullable=true)
     */
    private $productBookable;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_created", type="integer", nullable=true)
     */
    private $productCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_modified", type="integer", nullable=true)
     */
    private $productModified;

    /**
     * @var boolean
     *
     * @ORM\Column(name="product_deleted", type="boolean", nullable=true)
     */
    private $productDeleted;

	/**
	 * @return the $productId
	 */
	public function getProductId() {
		return $this->productId;
	}

	/**
	 * @param number $productId
	 */
	public function setProductId($productId) {
		$this->productId = $productId;
	}

	/**
	 * @return the $productName
	 */
	public function getProductName() {
		return $this->productName;
	}

	/**
	 * @param string $productName
	 */
	public function setProductName($productName) {
		$this->productName = $productName;
	}

	/**
	 * @return the $productShortdesc
	 */
	public function getProductShortdesc() {
		return $this->productShortdesc;
	}

	/**
	 * @param string $productShortdesc
	 */
	public function setProductShortdesc($productShortdesc) {
		$this->productShortdesc = $productShortdesc;
	}

	/**
	 * @return the $productDescription
	 */
	public function getProductDescription() {
		return $this->productDescription;
	}

	/**
	 * @param string $productDescription
	 */
	public function setProductDescription($productDescription) {
		$this->productDescription = $productDescription;
	}

	/**
	 * @return the $productCategory
	 */
	public function getProductCategory() {
		return $this->productCategory;
	}

	/**
	 * @param string $productCategory
	 */
	public function setProductCategory($productCategory) {
		$this->productCategory = $productCategory;
	}

	/**
	 * @return the $productSource
	 */
	public function getProductSource() {
		return $this->productSource;
	}

	/**
	 * @param string $productSource
	 */
	public function setProductSource($productSource) {
		$this->productSource = $productSource;
	}

	/**
	 * @return the $productSourceId
	 */
	public function getProductSourceId() {
		return $this->productSourceId;
	}

	/**
	 * @param string $productSourceId
	 */
	public function setProductSourceId($productSourceId) {
		$this->productSourceId = $productSourceId;
	}

	/**
	 * @return the $productCountry
	 */
	public function getProductCountry() {
		return $this->productCountry;
	}

	/**
	 * @param string $productCountry
	 */
	public function setProductCountry($productCountry) {
		$this->productCountry = $productCountry;
	}

	/**
	 * @return the $productState
	 */
	public function getProductState() {
		return $this->productState;
	}

	/**
	 * @param string $productState
	 */
	public function setProductState($productState) {
		$this->productState = $productState;
	}

	/**
	 * @return the $productRegion
	 */
	public function getProductRegion() {
		return $this->productRegion;
	}

	/**
	 * @param string $productRegion
	 */
	public function setProductRegion($productRegion) {
		$this->productRegion = $productRegion;
	}

	/**
	 * @return the $productRegionId
	 */
	public function getProductRegionId() {
		return $this->productRegionId;
	}

	/**
	 * @param number $productRegionId
	 */
	public function setProductRegionId($productRegionId) {
		$this->productRegionId = $productRegionId;
	}

	/**
	 * @return the $productArea
	 */
	public function getProductArea() {
		return $this->productArea;
	}

	/**
	 * @param string $productArea
	 */
	public function setProductArea($productArea) {
		$this->productArea = $productArea;
	}

	/**
	 * @return the $productAreaId
	 */
	public function getProductAreaId() {
		return $this->productAreaId;
	}

	/**
	 * @param number $productAreaId
	 */
	public function setProductAreaId($productAreaId) {
		$this->productAreaId = $productAreaId;
	}

	/**
	 * @return the $productCity
	 */
	public function getProductCity() {
		return $this->productCity;
	}

	/**
	 * @param string $productCity
	 */
	public function setProductCity($productCity) {
		$this->productCity = $productCity;
	}

	/**
	 * @return the $productAddress
	 */
	public function getProductAddress() {
		return $this->productAddress;
	}

	/**
	 * @param string $productAddress
	 */
	public function setProductAddress($productAddress) {
		$this->productAddress = $productAddress;
	}

	/**
	 * @return the $productPhone
	 */
	public function getProductPhone() {
		return $this->productPhone;
	}

	/**
	 * @param string $productPhone
	 */
	public function setProductPhone($productPhone) {
		$this->productPhone = $productPhone;
	}

	/**
	 * @return the $productEmail
	 */
	public function getProductEmail() {
		return $this->productEmail;
	}

	/**
	 * @param string $productEmail
	 */
	public function setProductEmail($productEmail) {
		$this->productEmail = $productEmail;
	}

	/**
	 * @return the $productWebsite
	 */
	public function getProductWebsite() {
		return $this->productWebsite;
	}

	/**
	 * @param string $productWebsite
	 */
	public function setProductWebsite($productWebsite) {
		$this->productWebsite = $productWebsite;
	}

	/**
	 * @return the $productLat
	 */
	public function getProductLat() {
		return $this->productLat;
	}

	/**
	 * @param string $productLat
	 */
	public function setProductLat($productLat) {
		$this->productLat = $productLat;
	}

	/**
	 * @return the $productLon
	 */
	public function getProductLon() {
		return $this->productLon;
	}

	/**
	 * @param string $productLon
	 */
	public function setProductLon($productLon) {
		$this->productLon = $productLon;
	}

	/**
	 * @return the $productPhoto
	 */
	public function getProductPhoto() {
		return $this->productPhoto;
	}

	/**
	 * @param string $productPhoto
	 */
	public function setProductPhoto($productPhoto) {
		$this->productPhoto = $productPhoto;
	}

	/**
	 * @return the $productStarRating
	 */
	public function getProductStarRating() {
		return $this->productStarRating;
	}

	/**
	 * @param number $productStarRating
	 */
	public function setProductStarRating($productStarRating) {
		$this->productStarRating = $productStarRating;
	}

	/**
	 * @return the $productLowrate
	 */
	public function getProductLowrate() {
		return $this->productLowrate;
	}

	/**
	 * @param number $productLowrate
	 */
	public function setProductLowrate($productLowrate) {
		$this->productLowrate = $productLowrate;
	}

	/**
	 * @return the $productHighrate
	 */
	public function getProductHighrate() {
		return $this->productHighrate;
	}

	/**
	 * @param number $productHighrate
	 */
	public function setProductHighrate($productHighrate) {
		$this->productHighrate = $productHighrate;
	}

	/**
	 * @return the $productRateBasis
	 */
	public function getProductRateBasis() {
		return $this->productRateBasis;
	}

	/**
	 * @param string $productRateBasis
	 */
	public function setProductRateBasis($productRateBasis) {
		$this->productRateBasis = $productRateBasis;
	}

	/**
	 * @return the $productCheckin
	 */
	public function getProductCheckin() {
		return $this->productCheckin;
	}

	/**
	 * @param string $productCheckin
	 */
	public function setProductCheckin($productCheckin) {
		$this->productCheckin = $productCheckin;
	}

	/**
	 * @return the $productCheckout
	 */
	public function getProductCheckout() {
		return $this->productCheckout;
	}

	/**
	 * @param string $productCheckout
	 */
	public function setProductCheckout($productCheckout) {
		$this->productCheckout = $productCheckout;
	}

	/**
	 * @return the $productBookable
	 */
	public function getProductBookable() {
		return $this->productBookable;
	}

	/**
	 * @param string $productBookable
	 */
	public function setProductBookable($productBookable) {
		$this->productBookable = $productBookable;
	}

	/**
	 * @return the $productCreated
	 */
	public function getProductCreated() {
		return $this->productCreated;
	}

	/**
	 * @param number $productCreated
	 */
	public function setProductCreated($productCreated) {
		$this->productCreated = $productCreated;
	}

	/**
	 * @return the $productModified
	 */
	public function getProductModified() {
		return $this->productModified;
	}

	/**
	 * @param number $productModified
	 */
	public function setProductModified($productModified) {
		$this->productModified = $productModified;
	}

	/**
	 * @return the $productDeleted
	 */
	public function getProductDeleted() {
		return $this->productDeleted;
	}

	/**
	 * @param boolean $productDeleted
	 */
	public function setProductDeleted($productDeleted) {
		$this->productDeleted = $productDeleted;
	}
	
	public function getProductMultimedia() {
	    return $this->productMultimedia;
	}
	
	public function setProductMultimedia($productMultimedia) {
	    $this->productMultimedia = $productMultimedia;
	}
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function set($key, $value){
        $this->{'set'.ucfirst($key)}($value);
    }
	
	public function setByArray($array){
        foreach($array as $key => $value) {
            if(method_exists($this, 'set'.ucfirst($key))) {
                $this->{'set'.ucfirst($key)}($value);    
            }            
        }
        return $this;
    }
}