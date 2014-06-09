<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * V3Areas
 *
 * @ORM\Table(name="v3_areas")
 * @ORM\Entity
 */
class V3Area
{
    /**
     * @var integer
     *
     * @ORM\Column(name="v3area_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $v3areaId;

    /**
     * @var string
     *
     * @ORM\Column(name="v3area_code", type="string", length=255, nullable=false)
     */
    private $v3areaCode;

    /**
     * @var string
     *
     * @ORM\Column(name="v3area_name", type="string", length=255, nullable=false)
     */
    private $v3areaName;

    /**
     * @var string
     *
     * @ORM\Column(name="v3area_state", type="string", length=255, nullable=false)
     */
    private $v3areaState;
	/**
	 * @return the $v3areaId
	 */
	public function getV3areaId() {
		return $this->v3areaId;
	}

	/**
	 * @param number $v3areaId
	 */
	public function setV3areaId($v3areaId) {
		$this->v3areaId = $v3areaId;
	}

	/**
	 * @return the $v3areaCode
	 */
	public function getV3areaCode() {
		return $this->v3areaCode;
	}

	/**
	 * @param string $v3areaCode
	 */
	public function setV3areaCode($v3areaCode) {
		$this->v3areaCode = $v3areaCode;
	}

	/**
	 * @return the $v3areaName
	 */
	public function getV3areaName() {
		return $this->v3areaName;
	}

	/**
	 * @param string $v3areaName
	 */
	public function setV3areaName($v3areaName) {
		$this->v3areaName = $v3areaName;
	}

	/**
	 * @return the $v3areaState
	 */
	public function getV3areaState() {
		return $this->v3areaState;
	}

	/**
	 * @param string $v3areaState
	 */
	public function setV3areaState($v3areaState) {
		$this->v3areaState = $v3areaState;
	}
}