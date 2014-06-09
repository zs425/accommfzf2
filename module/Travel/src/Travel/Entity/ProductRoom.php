<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductRooms
 *
 * @ORM\Table(name="product_rooms")
 * @ORM\Entity
 */
class ProductRoom
{
    /**
     * @var integer
     *
     * @ORM\Column(name="room_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $roomId;

    /**
     * @var string
     *
     * @ORM\Column(name="room_name", type="string", length=255, nullable=true)
     */
    private $roomName;

    /**
     * @var string
     *
     * @ORM\Column(name="room_shortdesc", type="text", nullable=true)
     */
    private $roomShortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="room_description", type="text", nullable=true)
     */
    private $roomDescription;

    /**
     * @var float
     *
     * @ORM\Column(name="room_lowrate", type="decimal", nullable=true)
     */
    private $roomLowrate;

    /**
     * @var float
     *
     * @ORM\Column(name="room_highrate", type="decimal", nullable=true)
     */
    private $roomHighrate;

    /**
     * @var string
     *
     * @ORM\Column(name="room_rate_basis", type="string", length=45, nullable=true)
     */
    private $roomRateBasis;

    /**
     * @var float
     *
     * @ORM\Column(name="room_extraperson", type="decimal", nullable=true)
     */
    private $roomExtraperson;

    /**
     * @var boolean
     *
     * @ORM\Column(name="room_guestmax", type="boolean", nullable=true)
     */
    private $roomGuestmax;

    /**
     * @var string
     *
     * @ORM\Column(name="room_source", type="string", length=45, nullable=true)
     */
    private $roomSource;

    /**
     * @var string
     *
     * @ORM\Column(name="room_source_id", type="string", length=45, nullable=true)
     */
    private $roomSourceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="room_record_id", type="integer", nullable=true)
     */
    private $roomRecordId;

	/**
	 * @return the $roomId
	 */
	public function getRoomId() {
		return $this->roomId;
	}

	/**
	 * @param number $roomId
	 */
	public function setRoomId($roomId) {
		$this->roomId = $roomId;
	}

	/**
	 * @return the $roomName
	 */
	public function getRoomName() {
		return $this->roomName;
	}

	/**
	 * @param string $roomName
	 */
	public function setRoomName($roomName) {
		$this->roomName = $roomName;
	}

	/**
	 * @return the $roomShortdesc
	 */
	public function getRoomShortdesc() {
		return $this->roomShortdesc;
	}

	/**
	 * @param string $roomShortdesc
	 */
	public function setRoomShortdesc($roomShortdesc) {
		$this->roomShortdesc = $roomShortdesc;
	}

	/**
	 * @return the $roomDescription
	 */
	public function getRoomDescription() {
		return $this->roomDescription;
	}

	/**
	 * @param string $roomDescription
	 */
	public function setRoomDescription($roomDescription) {
		$this->roomDescription = $roomDescription;
	}

	/**
	 * @return the $roomLowrate
	 */
	public function getRoomLowrate() {
		return $this->roomLowrate;
	}

	/**
	 * @param number $roomLowrate
	 */
	public function setRoomLowrate($roomLowrate) {
		$this->roomLowrate = $roomLowrate;
	}

	/**
	 * @return the $roomHighrate
	 */
	public function getRoomHighrate() {
		return $this->roomHighrate;
	}

	/**
	 * @param number $roomHighrate
	 */
	public function setRoomHighrate($roomHighrate) {
		$this->roomHighrate = $roomHighrate;
	}

	/**
	 * @return the $roomRateBasis
	 */
	public function getRoomRateBasis() {
		return $this->roomRateBasis;
	}

	/**
	 * @param string $roomRateBasis
	 */
	public function setRoomRateBasis($roomRateBasis) {
		$this->roomRateBasis = $roomRateBasis;
	}

	/**
	 * @return the $roomExtraperson
	 */
	public function getRoomExtraperson() {
		return $this->roomExtraperson;
	}

	/**
	 * @param number $roomExtraperson
	 */
	public function setRoomExtraperson($roomExtraperson) {
		$this->roomExtraperson = $roomExtraperson;
	}

	/**
	 * @return the $roomGuestmax
	 */
	public function getRoomGuestmax() {
		return $this->roomGuestmax;
	}

	/**
	 * @param boolean $roomGuestmax
	 */
	public function setRoomGuestmax($roomGuestmax) {
		$this->roomGuestmax = $roomGuestmax;
	}

	/**
	 * @return the $roomSource
	 */
	public function getRoomSource() {
		return $this->roomSource;
	}

	/**
	 * @param string $roomSource
	 */
	public function setRoomSource($roomSource) {
		$this->roomSource = $roomSource;
	}

	/**
	 * @return the $roomSourceId
	 */
	public function getRoomSourceId() {
		return $this->roomSourceId;
	}

	/**
	 * @param string $roomSourceId
	 */
	public function setRoomSourceId($roomSourceId) {
		$this->roomSourceId = $roomSourceId;
	}

	/**
	 * @return the $roomRecordId
	 */
	public function getRoomRecordId() {
		return $this->roomRecordId;
	}

	/**
	 * @param number $roomRecordId
	 */
	public function setRoomRecordId($roomRecordId) {
		$this->roomRecordId = $roomRecordId;
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