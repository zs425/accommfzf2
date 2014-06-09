<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BaoDestinations
 *
 * @ORM\Table(name="bao_destinations")
 * @ORM\Entity
 */
class BaoDestination
{
    /**
     * @var integer
     *
     * @ORM\Column(name="baodestination_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $baodestinationId;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_name", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationName;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_url", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_type", type="string", length=15, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationType;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_area", type="string", length=150, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationArea;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_region", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_state", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationState;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_country", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_lat", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationLat;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_lon", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationLon;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_source", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationSource;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_source_id", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationSourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="baodestination_parent_id", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationParentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="baodestination_created", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="baodestination_modified", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baodestinationModified;


    /**
     * Get baodestinationId
     *
     * @return integer 
     */
    public function getBaodestinationId()
    {
        return $this->baodestinationId;
    }

    /**
     * Set baodestinationName
     *
     * @param string $baodestinationName
     * @return BaoDestinations
     */
    public function setBaodestinationName($baodestinationName)
    {
        $this->baodestinationName = $baodestinationName;
    
        return $this;
    }

    /**
     * Get baodestinationName
     *
     * @return string 
     */
    public function getBaodestinationName()
    {
        return $this->baodestinationName;
    }

    /**
     * Set baodestinationUrl
     *
     * @param string $baodestinationUrl
     * @return BaoDestinations
     */
    public function setBaodestinationUrl($baodestinationUrl)
    {
        $this->baodestinationUrl = $baodestinationUrl;
    
        return $this;
    }

    /**
     * Get baodestinationUrl
     *
     * @return string 
     */
    public function getBaodestinationUrl()
    {
        return $this->baodestinationUrl;
    }

    /**
     * Set baodestinationType
     *
     * @param string $baodestinationType
     * @return BaoDestinations
     */
    public function setBaodestinationType($baodestinationType)
    {
        $this->baodestinationType = $baodestinationType;
    
        return $this;
    }

    /**
     * Get baodestinationType
     *
     * @return string 
     */
    public function getBaodestinationType()
    {
        return $this->baodestinationType;
    }

    /**
     * Set baodestinationArea
     *
     * @param string $baodestinationArea
     * @return BaoDestinations
     */
    public function setBaodestinationArea($baodestinationArea)
    {
        $this->baodestinationArea = $baodestinationArea;
    
        return $this;
    }

    /**
     * Get baodestinationArea
     *
     * @return string 
     */
    public function getBaodestinationArea()
    {
        return $this->baodestinationArea;
    }

    /**
     * Set baodestinationRegion
     *
     * @param string $baodestinationRegion
     * @return BaoDestinations
     */
    public function setBaodestinationRegion($baodestinationRegion)
    {
        $this->baodestinationRegion = $baodestinationRegion;
    
        return $this;
    }

    /**
     * Get baodestinationRegion
     *
     * @return string 
     */
    public function getBaodestinationRegion()
    {
        return $this->baodestinationRegion;
    }

    /**
     * Set baodestinationState
     *
     * @param string $baodestinationState
     * @return BaoDestinations
     */
    public function setBaodestinationState($baodestinationState)
    {
        $this->baodestinationState = $baodestinationState;
    
        return $this;
    }

    /**
     * Get baodestinationState
     *
     * @return string 
     */
    public function getBaodestinationState()
    {
        return $this->baodestinationState;
    }

    /**
     * Set baodestinationCountry
     *
     * @param string $baodestinationCountry
     * @return BaoDestinations
     */
    public function setBaodestinationCountry($baodestinationCountry)
    {
        $this->baodestinationCountry = $baodestinationCountry;
    
        return $this;
    }

    /**
     * Get baodestinationCountry
     *
     * @return string 
     */
    public function getBaodestinationCountry()
    {
        return $this->baodestinationCountry;
    }

    /**
     * Set baodestinationDescription
     *
     * @param string $baodestinationDescription
     * @return BaoDestinations
     */
    public function setBaodestinationDescription($baodestinationDescription)
    {
        $this->baodestinationDescription = $baodestinationDescription;
    
        return $this;
    }

    /**
     * Get baodestinationDescription
     *
     * @return string 
     */
    public function getBaodestinationDescription()
    {
        return $this->baodestinationDescription;
    }

    /**
     * Set baodestinationLat
     *
     * @param string $baodestinationLat
     * @return BaoDestinations
     */
    public function setBaodestinationLat($baodestinationLat)
    {
        $this->baodestinationLat = $baodestinationLat;
    
        return $this;
    }

    /**
     * Get baodestinationLat
     *
     * @return string 
     */
    public function getBaodestinationLat()
    {
        return $this->baodestinationLat;
    }

    /**
     * Set baodestinationLon
     *
     * @param string $baodestinationLon
     * @return BaoDestinations
     */
    public function setBaodestinationLon($baodestinationLon)
    {
        $this->baodestinationLon = $baodestinationLon;
    
        return $this;
    }

    /**
     * Get baodestinationLon
     *
     * @return string 
     */
    public function getBaodestinationLon()
    {
        return $this->baodestinationLon;
    }

    /**
     * Set baodestinationSource
     *
     * @param string $baodestinationSource
     * @return BaoDestinations
     */
    public function setBaodestinationSource($baodestinationSource)
    {
        $this->baodestinationSource = $baodestinationSource;
    
        return $this;
    }

    /**
     * Get baodestinationSource
     *
     * @return string 
     */
    public function getBaodestinationSource()
    {
        return $this->baodestinationSource;
    }

    /**
     * Set baodestinationSourceId
     *
     * @param string $baodestinationSourceId
     * @return BaoDestinations
     */
    public function setBaodestinationSourceId($baodestinationSourceId)
    {
        $this->baodestinationSourceId = $baodestinationSourceId;
    
        return $this;
    }

    /**
     * Get baodestinationSourceId
     *
     * @return string 
     */
    public function getBaodestinationSourceId()
    {
        return $this->baodestinationSourceId;
    }

    /**
     * Set baodestinationParentId
     *
     * @param string $baodestinationParentId
     * @return BaoDestinations
     */
    public function setBaodestinationParentId($baodestinationParentId)
    {
        $this->baodestinationParentId = $baodestinationParentId;
    
        return $this;
    }

    /**
     * Get baodestinationParentId
     *
     * @return string 
     */
    public function getBaodestinationParentId()
    {
        return $this->baodestinationParentId;
    }

    /**
     * Set baodestinationCreated
     *
     * @param integer $baodestinationCreated
     * @return BaoDestinations
     */
    public function setBaodestinationCreated($baodestinationCreated)
    {
        $this->baodestinationCreated = $baodestinationCreated;
    
        return $this;
    }

    /**
     * Get baodestinationCreated
     *
     * @return integer 
     */
    public function getBaodestinationCreated()
    {
        return $this->baodestinationCreated;
    }

    /**
     * Set baodestinationModified
     *
     * @param integer $baodestinationModified
     * @return BaoDestinations
     */
    public function setBaodestinationModified($baodestinationModified)
    {
        $this->baodestinationModified = $baodestinationModified;
    
        return $this;
    }

    /**
     * Get baodestinationModified
     *
     * @return integer 
     */
    public function getBaodestinationModified()
    {
        return $this->baodestinationModified;
    }
}
