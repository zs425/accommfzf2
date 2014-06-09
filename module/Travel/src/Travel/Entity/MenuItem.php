<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItems
 *
 * @ORM\Table(name="menu_items")
 * @ORM\Entity
 */
class MenuItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="menuitem_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $menuitemId;

    /**
     * @var integer
     *
     * @ORM\Column(name="menuitem_menu_id", type="integer", nullable=false)
     */
    private $menuitemMenuId;

    /**
     * @var integer
     *
     * @ORM\Column(name="menuitem_parent_id", type="integer", nullable=false)
     */
    private $menuitemParentId;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_type", type="string", length=45, nullable=true)
     */
    private $menuitemType;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_label", type="string", length=255, nullable=false)
     */
    private $menuitemLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_title", type="string", length=255, nullable=false)
     */
    private $menuitemTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_uri", type="string", length=255, nullable=false)
     */
    private $menuitemUri;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_target", type="string", length=15, nullable=false)
     */
    private $menuitemTarget;

    /**
     * @var boolean
     *
     * @ORM\Column(name="menuitem_visible", type="boolean", nullable=false)
     */
    private $menuitemVisible;

    /**
     * @var integer
     *
     * @ORM\Column(name="menuitem_weight", type="integer", nullable=false)
     */
    private $menuitemWeight;

	/**
	 * @return the $menuitemId
	 */
	public function getMenuitemId() {
		return $this->menuitemId;
	}

	/**
	 * @param number $menuitemId
	 */
	public function setMenuitemId($menuitemId) {
		$this->menuitemId = $menuitemId;
	}

	/**
	 * @return the $menuitemMenuId
	 */
	public function getMenuitemMenuId() {
		return $this->menuitemMenuId;
	}

	/**
	 * @param number $menuitemMenuId
	 */
	public function setMenuitemMenuId($menuitemMenuId) {
		$this->menuitemMenuId = $menuitemMenuId;
	}

	/**
	 * @return the $menuitemParentId
	 */
	public function getMenuitemParentId() {
		return $this->menuitemParentId;
	}

	/**
	 * @param number $menuitemParentId
	 */
	public function setMenuitemParentId($menuitemParentId) {
		$this->menuitemParentId = $menuitemParentId;
	}

	/**
	 * @return the $menuitemType
	 */
	public function getMenuitemType() {
		return $this->menuitemType;
	}

	/**
	 * @param string $menuitemType
	 */
	public function setMenuitemType($menuitemType) {
		$this->menuitemType = $menuitemType;
	}

	/**
	 * @return the $menuitemLabel
	 */
	public function getMenuitemLabel() {
		return $this->menuitemLabel;
	}

	/**
	 * @param string $menuitemLabel
	 */
	public function setMenuitemLabel($menuitemLabel) {
		$this->menuitemLabel = $menuitemLabel;
	}

	/**
	 * @return the $menuitemTitle
	 */
	public function getMenuitemTitle() {
		return $this->menuitemTitle;
	}

	/**
	 * @param string $menuitemTitle
	 */
	public function setMenuitemTitle($menuitemTitle) {
		$this->menuitemTitle = $menuitemTitle;
	}

	/**
	 * @return the $menuitemUri
	 */
	public function getMenuitemUri() {
		return $this->menuitemUri;
	}

	/**
	 * @param string $menuitemUri
	 */
	public function setMenuitemUri($menuitemUri) {
		$this->menuitemUri = $menuitemUri;
	}

	/**
	 * @return the $menuitemTarget
	 */
	public function getMenuitemTarget() {
		return $this->menuitemTarget;
	}

	/**
	 * @param string $menuitemTarget
	 */
	public function setMenuitemTarget($menuitemTarget) {
		$this->menuitemTarget = $menuitemTarget;
	}

	/**
	 * @return the $menuitemVisible
	 */
	public function getMenuitemVisible() {
		return $this->menuitemVisible;
	}

	/**
	 * @param boolean $menuitemVisible
	 */
	public function setMenuitemVisible($menuitemVisible) {
		$this->menuitemVisible = $menuitemVisible;
	}

	/**
	 * @return the $menuitemWeight
	 */
	public function getMenuitemWeight() {
		return $this->menuitemWeight;
	}

	/**
	 * @param number $menuitemWeight
	 */
	public function setMenuitemWeight($menuitemWeight) {
		$this->menuitemWeight = $menuitemWeight;
	}
    
    public function set($key, $value){
        $this->{'set'.ucfirst($key)}($value);
    }
}