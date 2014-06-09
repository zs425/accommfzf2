<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aliases
 *
 * @ORM\Table(name="aliases")
 * @ORM\Entity
 */
class Alias
{
    /**
     * @var integer
     *
     * @ORM\Column(name="alias_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $aliasId;

    /**
     * @var string
     *
     * @ORM\Column(name="alias_system", type="string", length=255, nullable=false)
     */
    private $aliasSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="alias_route", type="string", length=180, nullable=false)
     */
    private $aliasRoute;

	/**
	 * @return the $aliasId
	 */
	public function getAliasId() {
		return $this->aliasId;
	}

	/**
	 * @param number $aliasId
	 */
	public function setAliasId($aliasId) {
		$this->aliasId = $aliasId;
	}

	/**
	 * @return the $aliasSystem
	 */
	public function getAliasSystem() {
		return $this->aliasSystem;
	}

	/**
	 * @param string $aliasSystem
	 */
	public function setAliasSystem($aliasSystem) {
		$this->aliasSystem = $aliasSystem;
	}

	/**
	 * @return the $aliasRoute
	 */
	public function getAliasRoute() {
		return $this->aliasRoute;
	}

	/**
	 * @param string $aliasRoute
	 */
	public function setAliasRoute($aliasRoute) {
		$this->aliasRoute = $aliasRoute;
	}
}