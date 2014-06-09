<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotelRooms
 *
 * @ORM\Table(name="hotel_rooms")
 * @ORM\Entity
 */
class HotelRoom
{
    /**
     * @var integer
     *
     * @ORM\Column(name="hotelroom_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $hotelroomId;

    /**
     * @var string
     *
     * @ORM\Column(name="hotelroom_name", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomName;

    /**
     * @var string
     *
     * @ORM\Column(name="hotelroom_shortdesc", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomShortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="hotelroom_description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomDescription;

    /**
     * @var float
     *
     * @ORM\Column(name="hotelroom_lowrate", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomLowrate;

    /**
     * @var float
     *
     * @ORM\Column(name="hotelroom_highrate", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomHighrate;

    /**
     * @var string
     *
     * @ORM\Column(name="hotelroom_rate_basis", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomRateBasis;

    /**
     * @var float
     *
     * @ORM\Column(name="hotelroom_extraperson", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomExtraperson;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hotelroom_guestmax", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomGuestmax;

    /**
     * @var string
     *
     * @ORM\Column(name="hotelroom_source", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomSource;

    /**
     * @var string
     *
     * @ORM\Column(name="hotelroom_source_id", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomSourceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="hotelroom_record_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotelroomRecordId;


    /**
     * Get hotelroomId
     *
     * @return integer 
     */
    public function getHotelroomId()
    {
        return $this->hotelroomId;
    }

    /**
     * Set hotelroomName
     *
     * @param string $hotelroomName
     * @return HotelRooms
     */
    public function setHotelroomName($hotelroomName)
    {
        $this->hotelroomName = $hotelroomName;
    
        return $this;
    }

    /**
     * Get hotelroomName
     *
     * @return string 
     */
    public function getHotelroomName()
    {
        return $this->hotelroomName;
    }

    /**
     * Set hotelroomShortdesc
     *
     * @param string $hotelroomShortdesc
     * @return HotelRooms
     */
    public function setHotelroomShortdesc($hotelroomShortdesc)
    {
        $this->hotelroomShortdesc = $hotelroomShortdesc;
    
        return $this;
    }

    /**
     * Get hotelroomShortdesc
     *
     * @return string 
     */
    public function getHotelroomShortdesc()
    {
        return $this->hotelroomShortdesc;
    }

    /**
     * Set hotelroomDescription
     *
     * @param string $hotelroomDescription
     * @return HotelRooms
     */
    public function setHotelroomDescription($hotelroomDescription)
    {
        $this->hotelroomDescription = $hotelroomDescription;
    
        return $this;
    }

    /**
     * Get hotelroomDescription
     *
     * @return string 
     */
    public function getHotelroomDescription()
    {
        return $this->hotelroomDescription;
    }

    /**
     * Set hotelroomLowrate
     *
     * @param float $hotelroomLowrate
     * @return HotelRooms
     */
    public function setHotelroomLowrate($hotelroomLowrate)
    {
        $this->hotelroomLowrate = $hotelroomLowrate;
    
        return $this;
    }

    /**
     * Get hotelroomLowrate
     *
     * @return float 
     */
    public function getHotelroomLowrate()
    {
        return $this->hotelroomLowrate;
    }

    /**
     * Set hotelroomHighrate
     *
     * @param float $hotelroomHighrate
     * @return HotelRooms
     */
    public function setHotelroomHighrate($hotelroomHighrate)
    {
        $this->hotelroomHighrate = $hotelroomHighrate;
    
        return $this;
    }

    /**
     * Get hotelroomHighrate
     *
     * @return float 
     */
    public function getHotelroomHighrate()
    {
        return $this->hotelroomHighrate;
    }

    /**
     * Set hotelroomRateBasis
     *
     * @param string $hotelroomRateBasis
     * @return HotelRooms
     */
    public function setHotelroomRateBasis($hotelroomRateBasis)
    {
        $this->hotelroomRateBasis = $hotelroomRateBasis;
    
        return $this;
    }

    /**
     * Get hotelroomRateBasis
     *
     * @return string 
     */
    public function getHotelroomRateBasis()
    {
        return $this->hotelroomRateBasis;
    }

    /**
     * Set hotelroomExtraperson
     *
     * @param float $hotelroomExtraperson
     * @return HotelRooms
     */
    public function setHotelroomExtraperson($hotelroomExtraperson)
    {
        $this->hotelroomExtraperson = $hotelroomExtraperson;
    
        return $this;
    }

    /**
     * Get hotelroomExtraperson
     *
     * @return float 
     */
    public function getHotelroomExtraperson()
    {
        return $this->hotelroomExtraperson;
    }

    /**
     * Set hotelroomGuestmax
     *
     * @param boolean $hotelroomGuestmax
     * @return HotelRooms
     */
    public function setHotelroomGuestmax($hotelroomGuestmax)
    {
        $this->hotelroomGuestmax = $hotelroomGuestmax;
    
        return $this;
    }

    /**
     * Get hotelroomGuestmax
     *
     * @return boolean 
     */
    public function getHotelroomGuestmax()
    {
        return $this->hotelroomGuestmax;
    }

    /**
     * Set hotelroomSource
     *
     * @param string $hotelroomSource
     * @return HotelRooms
     */
    public function setHotelroomSource($hotelroomSource)
    {
        $this->hotelroomSource = $hotelroomSource;
    
        return $this;
    }

    /**
     * Get hotelroomSource
     *
     * @return string 
     */
    public function getHotelroomSource()
    {
        return $this->hotelroomSource;
    }

    /**
     * Set hotelroomSourceId
     *
     * @param string $hotelroomSourceId
     * @return HotelRooms
     */
    public function setHotelroomSourceId($hotelroomSourceId)
    {
        $this->hotelroomSourceId = $hotelroomSourceId;
    
        return $this;
    }

    /**
     * Get hotelroomSourceId
     *
     * @return string 
     */
    public function getHotelroomSourceId()
    {
        return $this->hotelroomSourceId;
    }

    /**
     * Set hotelroomRecordId
     *
     * @param integer $hotelroomRecordId
     * @return HotelRooms
     */
    public function setHotelroomRecordId($hotelroomRecordId)
    {
        $this->hotelroomRecordId = $hotelroomRecordId;
    
        return $this;
    }

    /**
     * Get hotelroomRecordId
     *
     * @return integer 
     */
    public function getHotelroomRecordId()
    {
        return $this->hotelroomRecordId;
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
