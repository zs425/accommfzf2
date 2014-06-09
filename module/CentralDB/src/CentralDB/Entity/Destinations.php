<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Destinations
 *
 * @ORM\Table(name="destinations")
 * @ORM\Entity
 */
class Destinations
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="abbr", type="string", length=255, nullable=true)
     */
    private $abbr;

    /**
     * @var integer
     *
     * @ORM\Column(name="tier", type="integer", nullable=true)
     */
    private $tier;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var string
     *
     * @ORM\Column(name="children", type="string", length=2000, nullable=true)
     */
    private $children;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lon", type="string", length=255, nullable=true)
     */
    private $lon;

    /**
     * @var integer
     *
     * @ORM\Column(name="state_id", type="integer", nullable=true)
     */
    private $stateId;

    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer", nullable=true)
     */
    private $countryId;

    /**
     * @var integer
     *
     * @ORM\Column(name="geonames_id", type="integer", nullable=true)
     */
    private $geonamesId;

    /**
     * @var integer
     *
     * @ORM\Column(name="geonames_parent", type="integer", nullable=true)
     */
    private $geonamesParent;

    /**
     * @var integer
     *
     * @ORM\Column(name="roamfree_id", type="integer", nullable=true)
     */
    private $roamfreeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="roamfree_parent", type="integer", nullable=true)
     */
    private $roamfreeParent;

	/**
     * @var string
     *
     * @ORM\Column(name="destination_type", type="string", length=255, nullable=true)
     */
    private $destinationType;
	
    /**
     * @var string
     *
     * @ORM\Column(name="state_name", type="string", length=255, nullable=true)
     */
    private $stateName;

    /**
     * @var string
     *
     * @ORM\Column(name="state_source", type="string", length=255, nullable=true)
     */
    private $stateSource;

    /**
     * @var string
     *
     * @ORM\Column(name="region_name", type="string", length=255, nullable=true)
     */
    private $regionName;

    /**
     * @var string
     *
     * @ORM\Column(name="region_source", type="string", length=255, nullable=true)
     */
    private $regionSource;

    /**
     * @var string
     *
     * @ORM\Column(name="area_name", type="string", length=255, nullable=true)
     */
    private $areaName;

    /**
     * @var string
     *
     * @ORM\Column(name="area_source", type="string", length=255, nullable=true)
     */
    private $areaSource;

    /**
     * @var integer
     *
     * @ORM\Column(name="v3_id", type="integer", nullable=true)
     */
    private $v3Id;

    /**
     * @var string
     *
     * @ORM\Column(name="expedia_id", type="string", length=255, nullable=true)
     */
    private $expediaId;

    /**
     * @var integer
     *
     * @ORM\Column(name="laterooms_id", type="integer", nullable=true)
     */
    private $lateroomsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="viator_id", type="integer", nullable=true)
     */
    private $viatorId;

    /**
     * @var integer
     *
     * @ORM\Column(name="woe_id", type="integer", nullable=true)
     */
    private $woeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="wiki_id", type="integer", nullable=true)
     */
    private $wikiId;

    /**
     * @var integer
     *
     * @ORM\Column(name="osm_id", type="integer", nullable=true)
     */
    private $osmId;

    /**
     * @var string
     *
     * @ORM\Column(name="iata_code", type="string", length=20, nullable=true)
     */
    private $iataCode;

    /**
     * @var string
     *
     * @ORM\Column(name="iso", type="string", length=20, nullable=true)
     */
    private $iso;

    /**
     * @var string
     *
     * @ORM\Column(name="locode", type="string", length=20, nullable=true)
     */
    private $locode;

    /**
     * @var integer
     *
     * @ORM\Column(name="atdw_code", type="integer", nullable=true)
     */
    private $atdwCode;

    /**
     * @var string
     *
     * @ORM\Column(name="alternateNames", type="string", length=3000, nullable=true)
     */
    private $alternatenames;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminName1", type="string", length=255, nullable=true)
     */
    private $geonamesAdminname1;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminName2", type="string", length=255, nullable=true)
     */
    private $geonamesAdminname2;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminName3", type="string", length=255, nullable=true)
     */
    private $geonamesAdminname3;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminName4", type="string", length=255, nullable=true)
     */
    private $geonamesAdminname4;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminName5", type="string", length=255, nullable=true)
     */
    private $geonamesAdminname5;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_bbox", type="string", length=255, nullable=true)
     */
    private $geonamesBbox;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_fcode", type="string", length=255, nullable=true)
     */
    private $geonamesFcode;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_population", type="string", length=255, nullable=true)
     */
    private $geonamesPopulation;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_fclName", type="string", length=255, nullable=true)
     */
    private $geonamesFclname;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_srtm3", type="string", length=255, nullable=true)
     */
    private $geonamesSrtm3;

    /**
     * @var string
     *
     * @ORM\Column(name="wikipedia_url", type="string", length=255, nullable=true)
     */
    private $wikipediaUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=255, nullable=true)
     */
    private $timezone;

    /**
     * @var string
     *
     * @ORM\Column(name="bbox", type="string", length=255, nullable=true)
     */
    private $bbox;

    /**
     * @var string
     *
     * @ORM\Column(name="postCode", type="string", length=25, nullable=true)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_fcl", type="string", length=255, nullable=true)
     */
    private $geonamesFcl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="added", type="datetime", nullable=true)
     */
    private $added;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminId1", type="string", length=255, nullable=true)
     */
    private $geonamesAdminid1;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminId2", type="string", length=255, nullable=true)
     */
    private $geonamesAdminid2;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminId3", type="string", length=255, nullable=true)
     */
    private $geonamesAdminid3;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminId4", type="string", length=255, nullable=true)
     */
    private $geonamesAdminid4;

    /**
     * @var string
     *
     * @ORM\Column(name="geonames_adminId5", type="string", length=255, nullable=true)
     */
    private $geonamesAdminid5;

    /**
     * @var string
     *
     * @ORM\Column(name="original_source", type="string", length=50, nullable=false)
     */
    private $originalSource = 'geonames';

    /**
     * @var string
     *
     * @ORM\Column(name="placeTypeName", type="string", length=80, nullable=true)
     */
    private $placetypename;

    /**
     * @var string
     *
     * @ORM\Column(name="placeTypeCode", type="string", length=10, nullable=true)
     */
    private $placetypecode;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Destinations
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set abbr
     *
     * @param string $abbr
     * @return Destinations
     */
    public function setAbbr($abbr)
    {
        $this->abbr = $abbr;

        return $this;
    }

    /**
     * Get abbr
     *
     * @return string 
     */
    public function getAbbr()
    {
        return $this->abbr;
    }

    /**
     * Set tier
     *
     * @param integer $tier
     * @return Destinations
     */
    public function setTier($tier)
    {
        $this->tier = $tier;

        return $this;
    }

    /**
     * Get tier
     *
     * @return integer 
     */
    public function getTier()
    {
        return $this->tier;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return Destinations
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set children
     *
     * @param string $children
     * @return Destinations
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return string 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return Destinations
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param string $lon
     * @return Destinations
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * Get lon
     *
     * @return string 
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * Set stateId
     *
     * @param integer $stateId
     * @return Destinations
     */
    public function setStateId($stateId)
    {
        $this->stateId = $stateId;

        return $this;
    }

    /**
     * Get stateId
     *
     * @return integer 
     */
    public function getStateId()
    {
        return $this->stateId;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     * @return Destinations
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set geonamesId
     *
     * @param integer $geonamesId
     * @return Destinations
     */
    public function setGeonamesId($geonamesId)
    {
        $this->geonamesId = $geonamesId;

        return $this;
    }

    /**
     * Get geonamesId
     *
     * @return integer 
     */
    public function getGeonamesId()
    {
        return $this->geonamesId;
    }

    /**
     * Set geonamesParent
     *
     * @param integer $geonamesParent
     * @return Destinations
     */
    public function setGeonamesParent($geonamesParent)
    {
        $this->geonamesParent = $geonamesParent;

        return $this;
    }

    /**
     * Get geonamesParent
     *
     * @return integer 
     */
    public function getGeonamesParent()
    {
        return $this->geonamesParent;
    }

    /**
     * Set roamfreeId
     *
     * @param integer $roamfreeId
     * @return Destinations
     */
    public function setRoamfreeId($roamfreeId)
    {
        $this->roamfreeId = $roamfreeId;

        return $this;
    }

    /**
     * Get roamfreeId
     *
     * @return integer 
     */
    public function getRoamfreeId()
    {
        return $this->roamfreeId;
    }

    /**
     * Set roamfreeParent
     *
     * @param integer $roamfreeParent
     * @return Destinations
     */
    public function setRoamfreeParent($roamfreeParent)
    {
        $this->roamfreeParent = $roamfreeParent;

        return $this;
    }

    /**
     * Get roamfreeParent
     *
     * @return integer 
     */
    public function getRoamfreeParent()
    {
        return $this->roamfreeParent;
    }

	/**
     * Set destinationType
     *
     * @param string $destinationType
     * @return Destinations
     */
    public function setDestinationType($destinationType)
    {
        $this->destinationType = $destinationType;

        return $this;
    }

    /**
     * Get destinationType
     *
     * @return string 
     */
    public function getDestinationType()
    {
        return $this->destinationType;
    }
	
    /**
     * Set stateName
     *
     * @param string $stateName
     * @return Destinations
     */
    public function setStateName($stateName)
    {
        $this->stateName = $stateName;

        return $this;
    }

    /**
     * Get stateName
     *
     * @return string 
     */
    public function getStateName()
    {
        return $this->stateName;
    }

    /**
     * Set stateSource
     *
     * @param string $stateSource
     * @return Destinations
     */
    public function setStateSource($stateSource)
    {
        $this->stateSource = $stateSource;

        return $this;
    }

    /**
     * Get stateSource
     *
     * @return string 
     */
    public function getStateSource()
    {
        return $this->stateSource;
    }

    /**
     * Set regionName
     *
     * @param string $regionName
     * @return Destinations
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;

        return $this;
    }

    /**
     * Get regionName
     *
     * @return string 
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Set regionSource
     *
     * @param string $regionSource
     * @return Destinations
     */
    public function setRegionSource($regionSource)
    {
        $this->regionSource = $regionSource;

        return $this;
    }

    /**
     * Get regionSource
     *
     * @return string 
     */
    public function getRegionSource()
    {
        return $this->regionSource;
    }

    /**
     * Set areaName
     *
     * @param string $areaName
     * @return Destinations
     */
    public function setAreaName($areaName)
    {
        $this->areaName = $areaName;

        return $this;
    }

    /**
     * Get areaName
     *
     * @return string 
     */
    public function getAreaName()
    {
        return $this->areaName;
    }

    /**
     * Set areaSource
     *
     * @param string $areaSource
     * @return Destinations
     */
    public function setAreaSource($areaSource)
    {
        $this->areaSource = $areaSource;

        return $this;
    }

    /**
     * Get areaSource
     *
     * @return string 
     */
    public function getAreaSource()
    {
        return $this->areaSource;
    }

    /**
     * Set v3Id
     *
     * @param integer $v3Id
     * @return Destinations
     */
    public function setV3Id($v3Id)
    {
        $this->v3Id = $v3Id;

        return $this;
    }

    /**
     * Get v3Id
     *
     * @return integer 
     */
    public function getV3Id()
    {
        return $this->v3Id;
    }

    /**
     * Set expediaId
     *
     * @param string $expediaId
     * @return Destinations
     */
    public function setExpediaId($expediaId)
    {
        $this->expediaId = $expediaId;

        return $this;
    }

    /**
     * Get expediaId
     *
     * @return string 
     */
    public function getExpediaId()
    {
        return $this->expediaId;
    }

    /**
     * Set lateroomsId
     *
     * @param integer $lateroomsId
     * @return Destinations
     */
    public function setLateroomsId($lateroomsId)
    {
        $this->lateroomsId = $lateroomsId;

        return $this;
    }

    /**
     * Get lateroomsId
     *
     * @return integer 
     */
    public function getLateroomsId()
    {
        return $this->lateroomsId;
    }

    /**
     * Set viatorId
     *
     * @param integer $viatorId
     * @return Destinations
     */
    public function setViatorId($viatorId)
    {
        $this->viatorId = $viatorId;

        return $this;
    }

    /**
     * Get viatorId
     *
     * @return integer 
     */
    public function getViatorId()
    {
        return $this->viatorId;
    }

    /**
     * Set woeId
     *
     * @param integer $woeId
     * @return Destinations
     */
    public function setWoeId($woeId)
    {
        $this->woeId = $woeId;

        return $this;
    }

    /**
     * Get woeId
     *
     * @return integer 
     */
    public function getWoeId()
    {
        return $this->woeId;
    }

    /**
     * Set wikiId
     *
     * @param integer $wikiId
     * @return Destinations
     */
    public function setWikiId($wikiId)
    {
        $this->wikiId = $wikiId;

        return $this;
    }

    /**
     * Get wikiId
     *
     * @return integer 
     */
    public function getWikiId()
    {
        return $this->wikiId;
    }

    /**
     * Set osmId
     *
     * @param integer $osmId
     * @return Destinations
     */
    public function setOsmId($osmId)
    {
        $this->osmId = $osmId;

        return $this;
    }

    /**
     * Get osmId
     *
     * @return integer 
     */
    public function getOsmId()
    {
        return $this->osmId;
    }

    /**
     * Set iataCode
     *
     * @param string $iataCode
     * @return Destinations
     */
    public function setIataCode($iataCode)
    {
        $this->iataCode = $iataCode;

        return $this;
    }

    /**
     * Get iataCode
     *
     * @return string 
     */
    public function getIataCode()
    {
        return $this->iataCode;
    }

    /**
     * Set iso
     *
     * @param string $iso
     * @return Destinations
     */
    public function setIso($iso)
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * Get iso
     *
     * @return string 
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * Set locode
     *
     * @param string $locode
     * @return Destinations
     */
    public function setLocode($locode)
    {
        $this->locode = $locode;

        return $this;
    }

    /**
     * Get locode
     *
     * @return string 
     */
    public function getLocode()
    {
        return $this->locode;
    }

    /**
     * Set atdwCode
     *
     * @param integer $atdwCode
     * @return Destinations
     */
    public function setAtdwCode($atdwCode)
    {
        $this->atdwCode = $atdwCode;

        return $this;
    }

    /**
     * Get atdwCode
     *
     * @return integer 
     */
    public function getAtdwCode()
    {
        return $this->atdwCode;
    }

    /**
     * Set alternatenames
     *
     * @param string $alternatenames
     * @return Destinations
     */
    public function setAlternatenames($alternatenames)
    {
        $this->alternatenames = $alternatenames;

        return $this;
    }

    /**
     * Get alternatenames
     *
     * @return string 
     */
    public function getAlternatenames()
    {
        return $this->alternatenames;
    }

    /**
     * Set geonamesAdminname1
     *
     * @param string $geonamesAdminname1
     * @return Destinations
     */
    public function setGeonamesAdminname1($geonamesAdminname1)
    {
        $this->geonamesAdminname1 = $geonamesAdminname1;

        return $this;
    }

    /**
     * Get geonamesAdminname1
     *
     * @return string 
     */
    public function getGeonamesAdminname1()
    {
        return $this->geonamesAdminname1;
    }

    /**
     * Set geonamesAdminname2
     *
     * @param string $geonamesAdminname2
     * @return Destinations
     */
    public function setGeonamesAdminname2($geonamesAdminname2)
    {
        $this->geonamesAdminname2 = $geonamesAdminname2;

        return $this;
    }

    /**
     * Get geonamesAdminname2
     *
     * @return string 
     */
    public function getGeonamesAdminname2()
    {
        return $this->geonamesAdminname2;
    }

    /**
     * Set geonamesAdminname3
     *
     * @param string $geonamesAdminname3
     * @return Destinations
     */
    public function setGeonamesAdminname3($geonamesAdminname3)
    {
        $this->geonamesAdminname3 = $geonamesAdminname3;

        return $this;
    }

    /**
     * Get geonamesAdminname3
     *
     * @return string 
     */
    public function getGeonamesAdminname3()
    {
        return $this->geonamesAdminname3;
    }

    /**
     * Set geonamesAdminname4
     *
     * @param string $geonamesAdminname4
     * @return Destinations
     */
    public function setGeonamesAdminname4($geonamesAdminname4)
    {
        $this->geonamesAdminname4 = $geonamesAdminname4;

        return $this;
    }

    /**
     * Get geonamesAdminname4
     *
     * @return string 
     */
    public function getGeonamesAdminname4()
    {
        return $this->geonamesAdminname4;
    }

    /**
     * Set geonamesAdminname5
     *
     * @param string $geonamesAdminname5
     * @return Destinations
     */
    public function setGeonamesAdminname5($geonamesAdminname5)
    {
        $this->geonamesAdminname5 = $geonamesAdminname5;

        return $this;
    }

    /**
     * Get geonamesAdminname5
     *
     * @return string 
     */
    public function getGeonamesAdminname5()
    {
        return $this->geonamesAdminname5;
    }

    /**
     * Set geonamesBbox
     *
     * @param string $geonamesBbox
     * @return Destinations
     */
    public function setGeonamesBbox($geonamesBbox)
    {
        $this->geonamesBbox = $geonamesBbox;

        return $this;
    }

    /**
     * Get geonamesBbox
     *
     * @return string 
     */
    public function getGeonamesBbox()
    {
        return $this->geonamesBbox;
    }

    /**
     * Set geonamesFcode
     *
     * @param string $geonamesFcode
     * @return Destinations
     */
    public function setGeonamesFcode($geonamesFcode)
    {
        $this->geonamesFcode = $geonamesFcode;

        return $this;
    }

    /**
     * Get geonamesFcode
     *
     * @return string 
     */
    public function getGeonamesFcode()
    {
        return $this->geonamesFcode;
    }

    /**
     * Set geonamesPopulation
     *
     * @param string $geonamesPopulation
     * @return Destinations
     */
    public function setGeonamesPopulation($geonamesPopulation)
    {
        $this->geonamesPopulation = $geonamesPopulation;

        return $this;
    }

    /**
     * Get geonamesPopulation
     *
     * @return string 
     */
    public function getGeonamesPopulation()
    {
        return $this->geonamesPopulation;
    }

    /**
     * Set geonamesFclname
     *
     * @param string $geonamesFclname
     * @return Destinations
     */
    public function setGeonamesFclname($geonamesFclname)
    {
        $this->geonamesFclname = $geonamesFclname;

        return $this;
    }

    /**
     * Get geonamesFclname
     *
     * @return string 
     */
    public function getGeonamesFclname()
    {
        return $this->geonamesFclname;
    }

    /**
     * Set geonamesSrtm3
     *
     * @param string $geonamesSrtm3
     * @return Destinations
     */
    public function setGeonamesSrtm3($geonamesSrtm3)
    {
        $this->geonamesSrtm3 = $geonamesSrtm3;

        return $this;
    }

    /**
     * Get geonamesSrtm3
     *
     * @return string 
     */
    public function getGeonamesSrtm3()
    {
        return $this->geonamesSrtm3;
    }

    /**
     * Set wikipediaUrl
     *
     * @param string $wikipediaUrl
     * @return Destinations
     */
    public function setWikipediaUrl($wikipediaUrl)
    {
        $this->wikipediaUrl = $wikipediaUrl;

        return $this;
    }

    /**
     * Get wikipediaUrl
     *
     * @return string 
     */
    public function getWikipediaUrl()
    {
        return $this->wikipediaUrl;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return Destinations
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string 
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set bbox
     *
     * @param string $bbox
     * @return Destinations
     */
    public function setBbox($bbox)
    {
        $this->bbox = $bbox;

        return $this;
    }

    /**
     * Get bbox
     *
     * @return string 
     */
    public function getBbox()
    {
        return $this->bbox;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Destinations
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set geonamesFcl
     *
     * @param string $geonamesFcl
     * @return Destinations
     */
    public function setGeonamesFcl($geonamesFcl)
    {
        $this->geonamesFcl = $geonamesFcl;

        return $this;
    }

    /**
     * Get geonamesFcl
     *
     * @return string 
     */
    public function getGeonamesFcl()
    {
        return $this->geonamesFcl;
    }

    /**
     * Set added
     *
     * @param \DateTime $added
     * @return Destinations
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * Get added
     *
     * @return \DateTime 
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     * @return Destinations
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime 
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set geonamesAdminid1
     *
     * @param string $geonamesAdminid1
     * @return Destinations
     */
    public function setGeonamesAdminid1($geonamesAdminid1)
    {
        $this->geonamesAdminid1 = $geonamesAdminid1;

        return $this;
    }

    /**
     * Get geonamesAdminid1
     *
     * @return string 
     */
    public function getGeonamesAdminid1()
    {
        return $this->geonamesAdminid1;
    }

    /**
     * Set geonamesAdminid2
     *
     * @param string $geonamesAdminid2
     * @return Destinations
     */
    public function setGeonamesAdminid2($geonamesAdminid2)
    {
        $this->geonamesAdminid2 = $geonamesAdminid2;

        return $this;
    }

    /**
     * Get geonamesAdminid2
     *
     * @return string 
     */
    public function getGeonamesAdminid2()
    {
        return $this->geonamesAdminid2;
    }

    /**
     * Set geonamesAdminid3
     *
     * @param string $geonamesAdminid3
     * @return Destinations
     */
    public function setGeonamesAdminid3($geonamesAdminid3)
    {
        $this->geonamesAdminid3 = $geonamesAdminid3;

        return $this;
    }

    /**
     * Get geonamesAdminid3
     *
     * @return string 
     */
    public function getGeonamesAdminid3()
    {
        return $this->geonamesAdminid3;
    }

    /**
     * Set geonamesAdminid4
     *
     * @param string $geonamesAdminid4
     * @return Destinations
     */
    public function setGeonamesAdminid4($geonamesAdminid4)
    {
        $this->geonamesAdminid4 = $geonamesAdminid4;

        return $this;
    }

    /**
     * Get geonamesAdminid4
     *
     * @return string 
     */
    public function getGeonamesAdminid4()
    {
        return $this->geonamesAdminid4;
    }

    /**
     * Set geonamesAdminid5
     *
     * @param string $geonamesAdminid5
     * @return Destinations
     */
    public function setGeonamesAdminid5($geonamesAdminid5)
    {
        $this->geonamesAdminid5 = $geonamesAdminid5;

        return $this;
    }

    /**
     * Get geonamesAdminid5
     *
     * @return string 
     */
    public function getGeonamesAdminid5()
    {
        return $this->geonamesAdminid5;
    }

    /**
     * Set originalSource
     *
     * @param string $originalSource
     * @return Destinations
     */
    public function setOriginalSource($originalSource)
    {
        $this->originalSource = $originalSource;

        return $this;
    }

    /**
     * Get originalSource
     *
     * @return string 
     */
    public function getOriginalSource()
    {
        return $this->originalSource;
    }

    /**
     * Set placetypename
     *
     * @param string $placetypename
     * @return Destinations
     */
    public function setPlacetypename($placetypename)
    {
        $this->placetypename = $placetypename;

        return $this;
    }

    /**
     * Get placetypename
     *
     * @return string 
     */
    public function getPlacetypename()
    {
        return $this->placetypename;
    }

    /**
     * Set placetypecode
     *
     * @param string $placetypecode
     * @return Destinations
     */
    public function setPlacetypecode($placetypecode)
    {
        $this->placetypecode = $placetypecode;

        return $this;
    }

    /**
     * Get placetypecode
     *
     * @return string 
     */
    public function getPlacetypecode()
    {
        return $this->placetypecode;
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


