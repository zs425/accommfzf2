<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menus
 *
 * @ORM\Table(name="menus")
 * @ORM\Entity
 */
class Menu
{
    /**
     * @var integer
     *
     * @ORM\Column(name="menu_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $menuId;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_title", type="string", length=255, nullable=false)
     */
    private $menuTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_description", type="string", length=255, nullable=false)
     */
    private $menuDescription;

	/**
	 * @return the $menuId
	 */
	public function getMenuId() {
		return $this->menuId;
	}

	/**
	 * @param number $menuId
	 */
	public function setMenuId($menuId) {
		$this->menuId = $menuId;
	}

	/**
	 * @return the $menuTitle
	 */
	public function getMenuTitle() {
		return $this->menuTitle;
	}

	/**
	 * @param string $menuTitle
	 */
	public function setMenuTitle($menuTitle) {
		$this->menuTitle = $menuTitle;
	}

	/**
	 * @return the $menuDescription
	 */
	public function getMenuDescription() {
		return $this->menuDescription;
	}

	/**
	 * @param string $menuDescription
	 */
	public function setMenuDescription($menuDescription) {
		$this->menuDescription = $menuDescription;
	}
}