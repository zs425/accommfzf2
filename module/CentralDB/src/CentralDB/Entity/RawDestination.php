<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RawDestinations
 *
 * @ORM\Table(name="raw_destinations")
 * @ORM\Entity
 */
class RawDestination
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rawdest_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rawdestId;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_name", type="string", length=150, precision=0, scale=0, nullable=false, unique=false)
     */
    private $rawdestName;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_source", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestSource;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_source_id", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestSourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_source_name", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestSourceName;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_type", type="string", length=15, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestType;

    /**
     * @var integer
     *
     * @ORM\Column(name="rawdest_bao_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestBaoId;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_country", type="string", length=3, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_country_source", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestCountrySource;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_state", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestState;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_state_source", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestStateSource;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_region", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_region_source", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestRegionSource;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_area", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestArea;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_area_source", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestAreaSource;

    /**
     * @var integer
     *
     * @ORM\Column(name="rawdest_parent_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestParentId;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_shortdesc", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestShortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_lat", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestLat;

    /**
     * @var string
     *
     * @ORM\Column(name="rawdest_lon", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $rawdestLon;

    /**
     * @var integer
     *
     * @ORM\Column(name="rawdest_created", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $rawdestCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="rawdest_modified", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $rawdestModified;

    /**
     * @var integer
     *
     * @ORM\Column(name="rawdest_merged", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $rawdestMerged;


    /**
     * Get rawdestId
     *
     * @return integer 
     */
    public function getRawdestId()
    {
        return $this->rawdestId;
    }

    /**
     * Set rawdestName
     *
     * @param string $rawdestName
     * @return RawDestinations
     */
    public function setRawdestName($rawdestName)
    {
        $this->rawdestName = $rawdestName;
    
        return $this;
    }

    /**
     * Get rawdestName
     *
     * @return string 
     */
    public function getRawdestName()
    {
        return $this->rawdestName;
    }

    /**
     * Set rawdestSource
     *
     * @param string $rawdestSource
     * @return RawDestinations
     */
    public function setRawdestSource($rawdestSource)
    {
        $this->rawdestSource = $rawdestSource;
    
        return $this;
    }

    /**
     * Get rawdestSource
     *
     * @return string 
     */
    public function getRawdestSource()
    {
        return $this->rawdestSource;
    }

    /**
     * Set rawdestSourceId
     *
     * @param string $rawdestSourceId
     * @return RawDestinations
     */
    public function setRawdestSourceId($rawdestSourceId)
    {
        $this->rawdestSourceId = $rawdestSourceId;
    
        return $this;
    }

    /**
     * Get rawdestSourceId
     *
     * @return string 
     */
    public function getRawdestSourceId()
    {
        return $this->rawdestSourceId;
    }

    /**
     * Set rawdestSourceName
     *
     * @param string $rawdestSourceName
     * @return RawDestinations
     */
    public function setRawdestSourceName($rawdestSourceName)
    {
        $this->rawdestSourceName = $rawdestSourceName;
    
        return $this;
    }

    /**
     * Get rawdestSourceName
     *
     * @return string 
     */
    public function getRawdestSourceName()
    {
        return $this->rawdestSourceName;
    }

    /**
     * Set rawdestType
     *
     * @param string $rawdestType
     * @return RawDestinations
     */
    public function setRawdestType($rawdestType)
    {
        $this->rawdestType = $rawdestType;
    
        return $this;
    }

    /**
     * Get rawdestType
     *
     * @return string 
     */
    public function getRawdestType()
    {
        return $this->rawdestType;
    }

    /**
     * Set rawdestBaoId
     *
     * @param integer $rawdestBaoId
     * @return RawDestinations
     */
    public function setRawdestBaoId($rawdestBaoId)
    {
        $this->rawdestBaoId = $rawdestBaoId;
    
        return $this;
    }

    /**
     * Get rawdestBaoId
     *
     * @return integer 
     */
    public function getRawdestBaoId()
    {
        return $this->rawdestBaoId;
    }

    /**
     * Set rawdestCountry
     *
     * @param string $rawdestCountry
     * @return RawDestinations
     */
    public function setRawdestCountry($rawdestCountry)
    {
        $this->rawdestCountry = $rawdestCountry;
    
        return $this;
    }

    /**
     * Get rawdestCountry
     *
     * @return string 
     */
    public function getRawdestCountry()
    {
        return $this->rawdestCountry;
    }

    /**
     * Set rawdestCountrySource
     *
     * @param string $rawdestCountrySource
     * @return RawDestinations
     */
    public function setRawdestCountrySource($rawdestCountrySource)
    {
        $this->rawdestCountrySource = $rawdestCountrySource;
    
        return $this;
    }

    /**
     * Get rawdestCountrySource
     *
     * @return string 
     */
    public function getRawdestCountrySource()
    {
        return $this->rawdestCountrySource;
    }

    /**
     * Set rawdestState
     *
     * @param string $rawdestState
     * @return RawDestinations
     */
    public function setRawdestState($rawdestState)
    {
        $this->rawdestState = $rawdestState;
    
        return $this;
    }

    /**
     * Get rawdestState
     *
     * @return string 
     */
    public function getRawdestState()
    {
        return $this->rawdestState;
    }

    /**
     * Set rawdestStateSource
     *
     * @param string $rawdestStateSource
     * @return RawDestinations
     */
    public function setRawdestStateSource($rawdestStateSource)
    {
        $this->rawdestStateSource = $rawdestStateSource;
    
        return $this;
    }

    /**
     * Get rawdestStateSource
     *
     * @return string 
     */
    public function getRawdestStateSource()
    {
        return $this->rawdestStateSource;
    }

    /**
     * Set rawdestRegion
     *
     * @param string $rawdestRegion
     * @return RawDestinations
     */
    public function setRawdestRegion($rawdestRegion)
    {
        $this->rawdestRegion = $rawdestRegion;
    
        return $this;
    }

    /**
     * Get rawdestRegion
     *
     * @return string 
     */
    public function getRawdestRegion()
    {
        return $this->rawdestRegion;
    }

    /**
     * Set rawdestRegionSource
     *
     * @param string $rawdestRegionSource
     * @return RawDestinations
     */
    public function setRawdestRegionSource($rawdestRegionSource)
    {
        $this->rawdestRegionSource = $rawdestRegionSource;
    
        return $this;
    }

    /**
     * Get rawdestRegionSource
     *
     * @return string 
     */
    public function getRawdestRegionSource()
    {
        return $this->rawdestRegionSource;
    }

    /**
     * Set rawdestArea
     *
     * @param string $rawdestArea
     * @return RawDestinations
     */
    public function setRawdestArea($rawdestArea)
    {
        $this->rawdestArea = $rawdestArea;
    
        return $this;
    }

    /**
     * Get rawdestArea
     *
     * @return string 
     */
    public function getRawdestArea()
    {
        return $this->rawdestArea;
    }

    /**
     * Set rawdestAreaSource
     *
     * @param string $rawdestAreaSource
     * @return RawDestinations
     */
    public function setRawdestAreaSource($rawdestAreaSource)
    {
        $this->rawdestAreaSource = $rawdestAreaSource;
    
        return $this;
    }

    /**
     * Get rawdestAreaSource
     *
     * @return string 
     */
    public function getRawdestAreaSource()
    {
        return $this->rawdestAreaSource;
    }

    /**
     * Set rawdestParentId
     *
     * @param integer $rawdestParentId
     * @return RawDestinations
     */
    public function setRawdestParentId($rawdestParentId)
    {
        $this->rawdestParentId = $rawdestParentId;
    
        return $this;
    }

    /**
     * Get rawdestParentId
     *
     * @return integer 
     */
    public function getRawdestParentId()
    {
        return $this->rawdestParentId;
    }

    /**
     * Set rawdestDescription
     *
     * @param string $rawdestDescription
     * @return RawDestinations
     */
    public function setRawdestDescription($rawdestDescription)
    {
        $this->rawdestDescription = $rawdestDescription;
    
        return $this;
    }

    /**
     * Get rawdestDescription
     *
     * @return string 
     */
    public function getRawdestDescription()
    {
        return $this->rawdestDescription;
    }

    /**
     * Set rawdestShortdesc
     *
     * @param string $rawdestShortdesc
     * @return RawDestinations
     */
    public function setRawdestShortdesc($rawdestShortdesc)
    {
        $this->rawdestShortdesc = $rawdestShortdesc;
    
        return $this;
    }

    /**
     * Get rawdestShortdesc
     *
     * @return string 
     */
    public function getRawdestShortdesc()
    {
        return $this->rawdestShortdesc;
    }

    /**
     * Set rawdestLat
     *
     * @param string $rawdestLat
     * @return RawDestinations
     */
    public function setRawdestLat($rawdestLat)
    {
        $this->rawdestLat = $rawdestLat;
    
        return $this;
    }

    /**
     * Get rawdestLat
     *
     * @return string 
     */
    public function getRawdestLat()
    {
        return $this->rawdestLat;
    }

    /**
     * Set rawdestLon
     *
     * @param string $rawdestLon
     * @return RawDestinations
     */
    public function setRawdestLon($rawdestLon)
    {
        $this->rawdestLon = $rawdestLon;
    
        return $this;
    }

    /**
     * Get rawdestLon
     *
     * @return string 
     */
    public function getRawdestLon()
    {
        return $this->rawdestLon;
    }

    /**
     * Set rawdestCreated
     *
     * @param integer $rawdestCreated
     * @return RawDestinations
     */
    public function setRawdestCreated($rawdestCreated)
    {
        $this->rawdestCreated = $rawdestCreated;
    
        return $this;
    }

    /**
     * Get rawdestCreated
     *
     * @return integer 
     */
    public function getRawdestCreated()
    {
        return $this->rawdestCreated;
    }

    /**
     * Set rawdestModified
     *
     * @param integer $rawdestModified
     * @return RawDestinations
     */
    public function setRawdestModified($rawdestModified)
    {
        $this->rawdestModified = $rawdestModified;
    
        return $this;
    }

    /**
     * Get rawdestModified
     *
     * @return integer 
     */
    public function getRawdestModified()
    {
        return $this->rawdestModified;
    }

    /**
     * Set rawdestMerged
     *
     * @param integer $rawdestMerged
     * @return RawDestinations
     */
    public function setRawdestMerged($rawdestMerged)
    {
        $this->rawdestMerged = $rawdestMerged;
    
        return $this;
    }

    /**
     * Get rawdestMerged
     *
     * @return integer 
     */
    public function getRawdestMerged()
    {
        return $this->rawdestMerged;
    }
}
