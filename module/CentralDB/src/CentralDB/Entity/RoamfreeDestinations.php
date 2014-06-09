<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoamfreeDestinations
 *
 * @ORM\Table(name="roamfree_destinations")
 * @ORM\Entity
 */
class RoamfreeDestinations
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
     * @ORM\Column(name="roamfree_name", type="string", length=255, nullable=true)
     */
    private $roamfreeName;

    /**
     * @var integer
     *
     * @ORM\Column(name="roamfree_id", type="integer", nullable=true)
     */
    private $roamfreeId;

    /**
     * @var string
     *
     * @ORM\Column(name="dest_type", type="string", length=255, nullable=true)
     */
    private $destType;

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
     * @ORM\Column(name="live_hotels", type="integer", nullable=true)
     */
    private $liveHotels;

    /**
     * @var integer
     *
     * @ORM\Column(name="roamfree_parent", type="integer", nullable=true)
     */
    private $roamfreeParent;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="destination_id", type="integer", nullable=true)
     */
    private $destinationId;

    /**
     * @var string
     *
     * @ORM\Column(name="added", type="string", length=20, nullable=true)
     */
    private $added;

    /**
     * @var string
     *
     * @ORM\Column(name="modified", type="string", length=20, nullable=true)
     */
    private $modified;



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
     * Set roamfreeName
     *
     * @param string $roamfreeName
     * @return RoamfreeDestinations
     */
    public function setRoamfreeName($roamfreeName)
    {
        $this->roamfreeName = $roamfreeName;

        return $this;
    }

    /**
     * Get roamfreeName
     *
     * @return string 
     */
    public function getRoamfreeName()
    {
        return $this->roamfreeName;
    }

    /**
     * Set roamfreeId
     *
     * @param integer $roamfreeId
     * @return RoamfreeDestinations
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
     * Set destType
     *
     * @param string $destType
     * @return RoamfreeDestinations
     */
    public function setDestType($destType)
    {
        $this->destType = $destType;

        return $this;
    }

    /**
     * Get destType
     *
     * @return string 
     */
    public function getDestType()
    {
        return $this->destType;
    }

    /**
     * Set stateName
     *
     * @param string $stateName
     * @return RoamfreeDestinations
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
     * @return RoamfreeDestinations
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
     * @return RoamfreeDestinations
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
     * @return RoamfreeDestinations
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
     * @return RoamfreeDestinations
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
     * @return RoamfreeDestinations
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
     * Set liveHotels
     *
     * @param integer $liveHotels
     * @return RoamfreeDestinations
     */
    public function setLiveHotels($liveHotels)
    {
        $this->liveHotels = $liveHotels;

        return $this;
    }

    /**
     * Get liveHotels
     *
     * @return integer 
     */
    public function getLiveHotels()
    {
        return $this->liveHotels;
    }

    /**
     * Set roamfreeParent
     *
     * @param integer $roamfreeParent
     * @return RoamfreeDestinations
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
     * Set level
     *
     * @param integer $level
     * @return RoamfreeDestinations
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set destinationId
     *
     * @param integer $destinationId
     * @return RoamfreeDestinations
     */
    public function setDestinationId($destinationId)
    {
        $this->destinationId = $destinationId;

        return $this;
    }

    /**
     * Get destinationId
     *
     * @return integer 
     */
    public function getDestinationId()
    {
        return $this->destinationId;
    }

    /**
     * Set added
     *
     * @param string $added
     * @return RoamfreeDestinations
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * Get added
     *
     * @return string 
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set modified
     *
     * @param string $modified
     * @return RoamfreeDestinations
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return string 
     */
    public function getModified()
    {
        return $this->modified;
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
