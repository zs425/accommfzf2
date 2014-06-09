<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plans
 *
 * @ORM\Table(name="plans")
 * @ORM\Entity
 */
class Plan
{
    /**
     * @var integer
     *
     * @ORM\Column(name="plan_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $planId;

    /**
     * @var integer
     *
     * @ORM\Column(name="plan_user_id", type="integer", nullable=false)
     */
    private $planUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="plan_name", type="string", length=255, nullable=false)
     */
    private $planName;

    /**
     * @var string
     *
     * @ORM\Column(name="plan_array", type="text", nullable=false)
     */
    private $planArray;

    /**
     * @var integer
     *
     * @ORM\Column(name="plan_arrival", type="integer", nullable=true)
     */
    private $planArrival;

    /**
     * @var integer
     *
     * @ORM\Column(name="plan_departure", type="integer", nullable=true)
     */
    private $planDeparture;

    /**
     * @var integer
     *
     * @ORM\Column(name="plan_days", type="integer", nullable=true)
     */
    private $planDays;

    /**
     * @var boolean
     *
     * @ORM\Column(name="plan_public", type="boolean", nullable=false)
     */
    private $planPublic;

    /**
     * @var integer
     *
     * @ORM\Column(name="plan_created", type="integer", nullable=false)
     */
    private $planCreated;

	/**
	 * @return the $planId
	 */
	public function getPlanId() {
		return $this->planId;
	}

	/**
	 * @param number $planId
	 */
	public function setPlanId($planId) {
		$this->planId = $planId;
	}

	/**
	 * @return the $planUserId
	 */
	public function getPlanUserId() {
		return $this->planUserId;
	}

	/**
	 * @param number $planUserId
	 */
	public function setPlanUserId($planUserId) {
		$this->planUserId = $planUserId;
	}

	/**
	 * @return the $planName
	 */
	public function getPlanName() {
		return $this->planName;
	}

	/**
	 * @param string $planName
	 */
	public function setPlanName($planName) {
		$this->planName = $planName;
	}

	/**
	 * @return the $planArray
	 */
	public function getPlanArray() {
		return $this->planArray;
	}

	/**
	 * @param string $planArray
	 */
	public function setPlanArray($planArray) {
		$this->planArray = $planArray;
	}

	/**
	 * @return the $planArrival
	 */
	public function getPlanArrival() {
		return $this->planArrival;
	}

	/**
	 * @param number $planArrival
	 */
	public function setPlanArrival($planArrival) {
		$this->planArrival = $planArrival;
	}

	/**
	 * @return the $planDeparture
	 */
	public function getPlanDeparture() {
		return $this->planDeparture;
	}

	/**
	 * @param number $planDeparture
	 */
	public function setPlanDeparture($planDeparture) {
		$this->planDeparture = $planDeparture;
	}

	/**
	 * @return the $planDays
	 */
	public function getPlanDays() {
		return $this->planDays;
	}

	/**
	 * @param number $planDays
	 */
	public function setPlanDays($planDays) {
		$this->planDays = $planDays;
	}

	/**
	 * @return the $planPublic
	 */
	public function getPlanPublic() {
		return $this->planPublic;
	}

	/**
	 * @param boolean $planPublic
	 */
	public function setPlanPublic($planPublic) {
		$this->planPublic = $planPublic;
	}

	/**
	 * @return the $planCreated
	 */
	public function getPlanCreated() {
		return $this->planCreated;
	}

	/**
	 * @param number $planCreated
	 */
	public function setPlanCreated($planCreated) {
		$this->planCreated = $planCreated;
	}
}