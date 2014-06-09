<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viatours
 *
 * @ORM\Table(name="viatours")
 * @ORM\Entity
 */
class Viatour
{
    /**
     * @var integer
     *
     * @ORM\Column(name="viatour_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $viatourId;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_group1", type="string", length=90, nullable=true)
     */
    private $viatourGroup1;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_category1", type="string", length=90, nullable=true)
     */
    private $viatourCategory1;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_subcategory1", type="string", length=90, nullable=true)
     */
    private $viatourSubcategory1;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_group2", type="string", length=90, nullable=true)
     */
    private $viatourGroup2;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_category2", type="string", length=90, nullable=true)
     */
    private $viatourCategory2;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_subcategory2", type="string", length=90, nullable=true)
     */
    private $viatourSubcategory2;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_group3", type="string", length=90, nullable=true)
     */
    private $viatourGroup3;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_category3", type="string", length=90, nullable=true)
     */
    private $viatourCategory3;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_subcategory3", type="string", length=90, nullable=true)
     */
    private $viatourSubcategory3;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_booktype", type="string", length=90, nullable=true)
     */
    private $viatourBooktype;

    /**
     * @var string
     *
     * @ORM\Column(name="viatour_ratingimg", type="string", length=255, nullable=true)
     */
    private $viatourRatingimg;

    /**
     * @var boolean
     *
     * @ORM\Column(name="viatour_special", type="boolean", nullable=true)
     */
    private $viatourSpecial;

    /**
     * @var integer
     *
     * @ORM\Column(name="viatour_destid", type="integer", nullable=true)
     */
    private $viatourDestid;
	/**
	 * @return the $viatourId
	 */
	public function getViatourId() {
		return $this->viatourId;
	}

	/**
	 * @param number $viatourId
	 */
	public function setViatourId($viatourId) {
		$this->viatourId = $viatourId;
	}

	/**
	 * @return the $viatourGroup1
	 */
	public function getViatourGroup1() {
		return $this->viatourGroup1;
	}

	/**
	 * @param string $viatourGroup1
	 */
	public function setViatourGroup1($viatourGroup1) {
		$this->viatourGroup1 = $viatourGroup1;
	}

	/**
	 * @return the $viatourCategory1
	 */
	public function getViatourCategory1() {
		return $this->viatourCategory1;
	}

	/**
	 * @param string $viatourCategory1
	 */
	public function setViatourCategory1($viatourCategory1) {
		$this->viatourCategory1 = $viatourCategory1;
	}

	/**
	 * @return the $viatourSubcategory1
	 */
	public function getViatourSubcategory1() {
		return $this->viatourSubcategory1;
	}

	/**
	 * @param string $viatourSubcategory1
	 */
	public function setViatourSubcategory1($viatourSubcategory1) {
		$this->viatourSubcategory1 = $viatourSubcategory1;
	}

	/**
	 * @return the $viatourGroup2
	 */
	public function getViatourGroup2() {
		return $this->viatourGroup2;
	}

	/**
	 * @param string $viatourGroup2
	 */
	public function setViatourGroup2($viatourGroup2) {
		$this->viatourGroup2 = $viatourGroup2;
	}

	/**
	 * @return the $viatourCategory2
	 */
	public function getViatourCategory2() {
		return $this->viatourCategory2;
	}

	/**
	 * @param string $viatourCategory2
	 */
	public function setViatourCategory2($viatourCategory2) {
		$this->viatourCategory2 = $viatourCategory2;
	}

	/**
	 * @return the $viatourSubcategory2
	 */
	public function getViatourSubcategory2() {
		return $this->viatourSubcategory2;
	}

	/**
	 * @param string $viatourSubcategory2
	 */
	public function setViatourSubcategory2($viatourSubcategory2) {
		$this->viatourSubcategory2 = $viatourSubcategory2;
	}

	/**
	 * @return the $viatourGroup3
	 */
	public function getViatourGroup3() {
		return $this->viatourGroup3;
	}

	/**
	 * @param string $viatourGroup3
	 */
	public function setViatourGroup3($viatourGroup3) {
		$this->viatourGroup3 = $viatourGroup3;
	}

	/**
	 * @return the $viatourCategory3
	 */
	public function getViatourCategory3() {
		return $this->viatourCategory3;
	}

	/**
	 * @param string $viatourCategory3
	 */
	public function setViatourCategory3($viatourCategory3) {
		$this->viatourCategory3 = $viatourCategory3;
	}

	/**
	 * @return the $viatourSubcategory3
	 */
	public function getViatourSubcategory3() {
		return $this->viatourSubcategory3;
	}

	/**
	 * @param string $viatourSubcategory3
	 */
	public function setViatourSubcategory3($viatourSubcategory3) {
		$this->viatourSubcategory3 = $viatourSubcategory3;
	}

	/**
	 * @return the $viatourBooktype
	 */
	public function getViatourBooktype() {
		return $this->viatourBooktype;
	}

	/**
	 * @param string $viatourBooktype
	 */
	public function setViatourBooktype($viatourBooktype) {
		$this->viatourBooktype = $viatourBooktype;
	}

	/**
	 * @return the $viatourRatingimg
	 */
	public function getViatourRatingimg() {
		return $this->viatourRatingimg;
	}

	/**
	 * @param string $viatourRatingimg
	 */
	public function setViatourRatingimg($viatourRatingimg) {
		$this->viatourRatingimg = $viatourRatingimg;
	}

	/**
	 * @return the $viatourSpecial
	 */
	public function getViatourSpecial() {
		return $this->viatourSpecial;
	}

	/**
	 * @param boolean $viatourSpecial
	 */
	public function setViatourSpecial($viatourSpecial) {
		$this->viatourSpecial = $viatourSpecial;
	}

	/**
	 * @return the $viatourDestid
	 */
	public function getViatourDestid() {
		return $this->viatourDestid;
	}

	/**
	 * @param number $viatourDestid
	 */
	public function setViatourDestid($viatourDestid) {
		$this->viatourDestid = $viatourDestid;
	}
}