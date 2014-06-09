<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statsind
 *
 * @ORM\Table(name="statsind")
 * @ORM\Entity
 */
class Statsind
{
    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $statsindId;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_accomm_id", type="integer", nullable=true)
     */
    private $statsindAccommId;

    /**
     * @var string
     *
     * @ORM\Column(name="statsind_date", type="string", length=30, nullable=true)
     */
    private $statsindDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_rooms_avail", type="integer", nullable=true)
     */
    private $statsindRoomsAvail;

    /**
     * @var string
     *
     * @ORM\Column(name="statsind_type", type="string", length=30, nullable=true)
     */
    private $statsindType;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_nights", type="integer", nullable=true)
     */
    private $statsindNights;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_adults", type="integer", nullable=true)
     */
    private $statsindAdults;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_children", type="integer", nullable=true)
     */
    private $statsindChildren;

    /**
     * @var string
     *
     * @ORM\Column(name="statsind_provider", type="string", length=45, nullable=true)
     */
    private $statsindProvider;

    /**
     * @var string
     *
     * @ORM\Column(name="statsind_session", type="string", length=36, nullable=true)
     */
    private $statsindSession;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_sessionstart", type="integer", nullable=true)
     */
    private $statsindSessionstart;

    /**
     * @var boolean
     *
     * @ORM\Column(name="statsind_status", type="boolean", nullable=true)
     */
    private $statsindStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsind_guests", type="integer", nullable=true)
     */
    private $statsindGuests;
	/**
	 * @return the $statsindId
	 */
	public function getStatsindId() {
		return $this->statsindId;
	}

	/**
	 * @param number $statsindId
	 */
	public function setStatsindId($statsindId) {
		$this->statsindId = $statsindId;
	}

	/**
	 * @return the $statsindAccommId
	 */
	public function getStatsindAccommId() {
		return $this->statsindAccommId;
	}

	/**
	 * @param number $statsindAccommId
	 */
	public function setStatsindAccommId($statsindAccommId) {
		$this->statsindAccommId = $statsindAccommId;
	}

	/**
	 * @return the $statsindDate
	 */
	public function getStatsindDate() {
		return $this->statsindDate;
	}

	/**
	 * @param string $statsindDate
	 */
	public function setStatsindDate($statsindDate) {
		$this->statsindDate = $statsindDate;
	}

	/**
	 * @return the $statsindRoomsAvail
	 */
	public function getStatsindRoomsAvail() {
		return $this->statsindRoomsAvail;
	}

	/**
	 * @param number $statsindRoomsAvail
	 */
	public function setStatsindRoomsAvail($statsindRoomsAvail) {
		$this->statsindRoomsAvail = $statsindRoomsAvail;
	}

	/**
	 * @return the $statsindType
	 */
	public function getStatsindType() {
		return $this->statsindType;
	}

	/**
	 * @param string $statsindType
	 */
	public function setStatsindType($statsindType) {
		$this->statsindType = $statsindType;
	}

	/**
	 * @return the $statsindNights
	 */
	public function getStatsindNights() {
		return $this->statsindNights;
	}

	/**
	 * @param number $statsindNights
	 */
	public function setStatsindNights($statsindNights) {
		$this->statsindNights = $statsindNights;
	}

	/**
	 * @return the $statsindAdults
	 */
	public function getStatsindAdults() {
		return $this->statsindAdults;
	}

	/**
	 * @param number $statsindAdults
	 */
	public function setStatsindAdults($statsindAdults) {
		$this->statsindAdults = $statsindAdults;
	}

	/**
	 * @return the $statsindChildren
	 */
	public function getStatsindChildren() {
		return $this->statsindChildren;
	}

	/**
	 * @param number $statsindChildren
	 */
	public function setStatsindChildren($statsindChildren) {
		$this->statsindChildren = $statsindChildren;
	}

	/**
	 * @return the $statsindProvider
	 */
	public function getStatsindProvider() {
		return $this->statsindProvider;
	}

	/**
	 * @param string $statsindProvider
	 */
	public function setStatsindProvider($statsindProvider) {
		$this->statsindProvider = $statsindProvider;
	}

	/**
	 * @return the $statsindSession
	 */
	public function getStatsindSession() {
		return $this->statsindSession;
	}

	/**
	 * @param string $statsindSession
	 */
	public function setStatsindSession($statsindSession) {
		$this->statsindSession = $statsindSession;
	}

	/**
	 * @return the $statsindSessionstart
	 */
	public function getStatsindSessionstart() {
		return $this->statsindSessionstart;
	}

	/**
	 * @param number $statsindSessionstart
	 */
	public function setStatsindSessionstart($statsindSessionstart) {
		$this->statsindSessionstart = $statsindSessionstart;
	}

	/**
	 * @return the $statsindStatus
	 */
	public function getStatsindStatus() {
		return $this->statsindStatus;
	}

	/**
	 * @param boolean $statsindStatus
	 */
	public function setStatsindStatus($statsindStatus) {
		$this->statsindStatus = $statsindStatus;
	}

	/**
	 * @return the $statsindGuests
	 */
	public function getStatsindGuests() {
		return $this->statsindGuests;
	}

	/**
	 * @param number $statsindGuests
	 */
	public function setStatsindGuests($statsindGuests) {
		$this->statsindGuests = $statsindGuests;
	}
}
