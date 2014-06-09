<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flags
 *
 * @ORM\Table(name="flags")
 * @ORM\Entity
 */
class Flag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="flag_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $flagId;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_item_id", type="string", length=100, nullable=true)
     */
    private $flagItemId;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_item_type", type="string", length=50, nullable=true)
     */
    private $flagItemType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="flag_date", type="date", nullable=true)
     */
    private $flagDate;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_details", type="string", length=100, nullable=true)
     */
    private $flagDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="flag_modified", type="date", nullable=true)
     */
    private $flagModified;

	/**
	 * @return the $flagId
	 */
	public function getFlagId() {
		return $this->flagId;
	}

	/**
	 * @param number $flagId
	 */
	public function setFlagId($flagId) {
		$this->flagId = $flagId;
	}

	/**
	 * @return the $flagItemId
	 */
	public function getFlagItemId() {
		return $this->flagItemId;
	}

	/**
	 * @param string $flagItemId
	 */
	public function setFlagItemId($flagItemId) {
		$this->flagItemId = $flagItemId;
	}

	/**
	 * @return the $flagItemType
	 */
	public function getFlagItemType() {
		return $this->flagItemType;
	}

	/**
	 * @param string $flagItemType
	 */
	public function setFlagItemType($flagItemType) {
		$this->flagItemType = $flagItemType;
	}

	/**
	 * @return the $flagDate
	 */
	public function getFlagDate() {
		return $this->flagDate;
	}

	/**
	 * @param DateTime $flagDate
	 */
	public function setFlagDate($flagDate) {
		$this->flagDate = $flagDate;
	}

	/**
	 * @return the $flagDetails
	 */
	public function getFlagDetails() {
		return $this->flagDetails;
	}

	/**
	 * @param string $flagDetails
	 */
	public function setFlagDetails($flagDetails) {
		$this->flagDetails = $flagDetails;
	}

	/**
	 * @return the $flagModified
	 */
	public function getFlagModified() {
		return $this->flagModified;
	}

	/**
	 * @param DateTime $flagModified
	 */
	public function setFlagModified($flagModified) {
		$this->flagModified = $flagModified;
	}
}