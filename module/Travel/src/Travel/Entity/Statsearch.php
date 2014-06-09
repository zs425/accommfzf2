<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statsearches
 *
 * @ORM\Table(name="statsearches")
 * @ORM\Entity
 */
class Statsearch
{
    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $statsearchId;

    /**
     * @var string
     *
     * @ORM\Column(name="statsearch_session", type="string", length=36, nullable=false)
     */
    private $statsearchSession;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_sessionstart", type="integer", nullable=false)
     */
    private $statsearchSessionstart;

    /**
     * @var string
     *
     * @ORM\Column(name="statsearch_type", type="string", length=30, nullable=false)
     */
    private $statsearchType;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_time", type="integer", nullable=false)
     */
    private $statsearchTime;

    /**
     * @var string
     *
     * @ORM\Column(name="statsearch_area", type="string", length=255, nullable=false)
     */
    private $statsearchArea;

    /**
     * @var string
     *
     * @ORM\Column(name="statsearch_date", type="string", length=30, nullable=false)
     */
    private $statsearchDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_nights", type="integer", nullable=true)
     */
    private $statsearchNights;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_adults", type="integer", nullable=true)
     */
    private $statsearchAdults;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_children", type="integer", nullable=true)
     */
    private $statsearchChildren;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_v3count", type="integer", nullable=true)
     */
    private $statsearchV3count;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_roamfree", type="integer", nullable=true)
     */
    private $statsearchRoamfree;

    /**
     * @var boolean
     *
     * @ORM\Column(name="statsearch_status", type="boolean", nullable=true)
     */
    private $statsearchStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="statsearch_bookbutton", type="string", length=255, nullable=true)
     */
    private $statsearchBookbutton;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_hc", type="integer", nullable=true)
     */
    private $statsearchHc;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_expedia", type="integer", nullable=true)
     */
    private $statsearchExpedia;

    /**
     * @var integer
     *
     * @ORM\Column(name="statsearch_totalresults", type="integer", nullable=true)
     */
    private $statsearchTotalresults;
	/**
	 * @return the $statsearchId
	 */
	public function getStatsearchId() {
		return $this->statsearchId;
	}

	/**
	 * @param number $statsearchId
	 */
	public function setStatsearchId($statsearchId) {
		$this->statsearchId = $statsearchId;
	}

	/**
	 * @return the $statsearchSession
	 */
	public function getStatsearchSession() {
		return $this->statsearchSession;
	}

	/**
	 * @param string $statsearchSession
	 */
	public function setStatsearchSession($statsearchSession) {
		$this->statsearchSession = $statsearchSession;
	}

	/**
	 * @return the $statsearchSessionstart
	 */
	public function getStatsearchSessionstart() {
		return $this->statsearchSessionstart;
	}

	/**
	 * @param number $statsearchSessionstart
	 */
	public function setStatsearchSessionstart($statsearchSessionstart) {
		$this->statsearchSessionstart = $statsearchSessionstart;
	}

	/**
	 * @return the $statsearchType
	 */
	public function getStatsearchType() {
		return $this->statsearchType;
	}

	/**
	 * @param string $statsearchType
	 */
	public function setStatsearchType($statsearchType) {
		$this->statsearchType = $statsearchType;
	}

	/**
	 * @return the $statsearchTime
	 */
	public function getStatsearchTime() {
		return $this->statsearchTime;
	}

	/**
	 * @param number $statsearchTime
	 */
	public function setStatsearchTime($statsearchTime) {
		$this->statsearchTime = $statsearchTime;
	}

	/**
	 * @return the $statsearchArea
	 */
	public function getStatsearchArea() {
		return $this->statsearchArea;
	}

	/**
	 * @param string $statsearchArea
	 */
	public function setStatsearchArea($statsearchArea) {
		$this->statsearchArea = $statsearchArea;
	}

	/**
	 * @return the $statsearchDate
	 */
	public function getStatsearchDate() {
		return $this->statsearchDate;
	}

	/**
	 * @param string $statsearchDate
	 */
	public function setStatsearchDate($statsearchDate) {
		$this->statsearchDate = $statsearchDate;
	}

	/**
	 * @return the $statsearchNights
	 */
	public function getStatsearchNights() {
		return $this->statsearchNights;
	}

	/**
	 * @param number $statsearchNights
	 */
	public function setStatsearchNights($statsearchNights) {
		$this->statsearchNights = $statsearchNights;
	}

	/**
	 * @return the $statsearchAdults
	 */
	public function getStatsearchAdults() {
		return $this->statsearchAdults;
	}

	/**
	 * @param number $statsearchAdults
	 */
	public function setStatsearchAdults($statsearchAdults) {
		$this->statsearchAdults = $statsearchAdults;
	}

	/**
	 * @return the $statsearchChildren
	 */
	public function getStatsearchChildren() {
		return $this->statsearchChildren;
	}

	/**
	 * @param number $statsearchChildren
	 */
	public function setStatsearchChildren($statsearchChildren) {
		$this->statsearchChildren = $statsearchChildren;
	}

	/**
	 * @return the $statsearchV3count
	 */
	public function getStatsearchV3count() {
		return $this->statsearchV3count;
	}

	/**
	 * @param number $statsearchV3count
	 */
	public function setStatsearchV3count($statsearchV3count) {
		$this->statsearchV3count = $statsearchV3count;
	}

	/**
	 * @return the $statsearchRoamfree
	 */
	public function getStatsearchRoamfree() {
		return $this->statsearchRoamfree;
	}

	/**
	 * @param number $statsearchRoamfree
	 */
	public function setStatsearchRoamfree($statsearchRoamfree) {
		$this->statsearchRoamfree = $statsearchRoamfree;
	}

	/**
	 * @return the $statsearchStatus
	 */
	public function getStatsearchStatus() {
		return $this->statsearchStatus;
	}

	/**
	 * @param boolean $statsearchStatus
	 */
	public function setStatsearchStatus($statsearchStatus) {
		$this->statsearchStatus = $statsearchStatus;
	}

	/**
	 * @return the $statsearchBookbutton
	 */
	public function getStatsearchBookbutton() {
		return $this->statsearchBookbutton;
	}

	/**
	 * @param string $statsearchBookbutton
	 */
	public function setStatsearchBookbutton($statsearchBookbutton) {
		$this->statsearchBookbutton = $statsearchBookbutton;
	}

	/**
	 * @return the $statsearchHc
	 */
	public function getStatsearchHc() {
		return $this->statsearchHc;
	}

	/**
	 * @param number $statsearchHc
	 */
	public function setStatsearchHc($statsearchHc) {
		$this->statsearchHc = $statsearchHc;
	}

	/**
	 * @return the $statsearchExpedia
	 */
	public function getStatsearchExpedia() {
		return $this->statsearchExpedia;
	}

	/**
	 * @param number $statsearchExpedia
	 */
	public function setStatsearchExpedia($statsearchExpedia) {
		$this->statsearchExpedia = $statsearchExpedia;
	}

	/**
	 * @return the $statsearchTotalresults
	 */
	public function getStatsearchTotalresults() {
		return $this->statsearchTotalresults;
	}

	/**
	 * @param number $statsearchTotalresults
	 */
	public function setStatsearchTotalresults($statsearchTotalresults) {
		$this->statsearchTotalresults = $statsearchTotalresults;
	}
}
