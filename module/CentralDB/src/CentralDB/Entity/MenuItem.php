<?php

namespace CentralDB\Entity;

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
     * @ORM\Column(name="menuitem_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $menuitemId;

    /**
     * @var integer
     *
     * @ORM\Column(name="menuitem_menu_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemMenuId;

    /**
     * @var integer
     *
     * @ORM\Column(name="menuitem_parent_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemParentId;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_label", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_title", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_uri", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemUri;

    /**
     * @var string
     *
     * @ORM\Column(name="menuitem_target", type="string", length=15, precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemTarget;

    /**
     * @var boolean
     *
     * @ORM\Column(name="menuitem_visible", type="boolean", precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemVisible;

    /**
     * @var integer
     *
     * @ORM\Column(name="menuitem_weight", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuitemWeight;


    /**
     * Get menuitemId
     *
     * @return integer 
     */
    public function getMenuitemId()
    {
        return $this->menuitemId;
    }

    /**
     * Set menuitemMenuId
     *
     * @param integer $menuitemMenuId
     * @return MenuItems
     */
    public function setMenuitemMenuId($menuitemMenuId)
    {
        $this->menuitemMenuId = $menuitemMenuId;
    
        return $this;
    }

    /**
     * Get menuitemMenuId
     *
     * @return integer 
     */
    public function getMenuitemMenuId()
    {
        return $this->menuitemMenuId;
    }

    /**
     * Set menuitemParentId
     *
     * @param integer $menuitemParentId
     * @return MenuItems
     */
    public function setMenuitemParentId($menuitemParentId)
    {
        $this->menuitemParentId = $menuitemParentId;
    
        return $this;
    }

    /**
     * Get menuitemParentId
     *
     * @return integer 
     */
    public function getMenuitemParentId()
    {
        return $this->menuitemParentId;
    }

    /**
     * Set menuitemLabel
     *
     * @param string $menuitemLabel
     * @return MenuItems
     */
    public function setMenuitemLabel($menuitemLabel)
    {
        $this->menuitemLabel = $menuitemLabel;
    
        return $this;
    }

    /**
     * Get menuitemLabel
     *
     * @return string 
     */
    public function getMenuitemLabel()
    {
        return $this->menuitemLabel;
    }

    /**
     * Set menuitemTitle
     *
     * @param string $menuitemTitle
     * @return MenuItems
     */
    public function setMenuitemTitle($menuitemTitle)
    {
        $this->menuitemTitle = $menuitemTitle;
    
        return $this;
    }

    /**
     * Get menuitemTitle
     *
     * @return string 
     */
    public function getMenuitemTitle()
    {
        return $this->menuitemTitle;
    }

    /**
     * Set menuitemUri
     *
     * @param string $menuitemUri
     * @return MenuItems
     */
    public function setMenuitemUri($menuitemUri)
    {
        $this->menuitemUri = $menuitemUri;
    
        return $this;
    }

    /**
     * Get menuitemUri
     *
     * @return string 
     */
    public function getMenuitemUri()
    {
        return $this->menuitemUri;
    }

    /**
     * Set menuitemTarget
     *
     * @param string $menuitemTarget
     * @return MenuItems
     */
    public function setMenuitemTarget($menuitemTarget)
    {
        $this->menuitemTarget = $menuitemTarget;
    
        return $this;
    }

    /**
     * Get menuitemTarget
     *
     * @return string 
     */
    public function getMenuitemTarget()
    {
        return $this->menuitemTarget;
    }

    /**
     * Set menuitemVisible
     *
     * @param boolean $menuitemVisible
     * @return MenuItems
     */
    public function setMenuitemVisible($menuitemVisible)
    {
        $this->menuitemVisible = $menuitemVisible;
    
        return $this;
    }

    /**
     * Get menuitemVisible
     *
     * @return boolean 
     */
    public function getMenuitemVisible()
    {
        return $this->menuitemVisible;
    }

    /**
     * Set menuitemWeight
     *
     * @param integer $menuitemWeight
     * @return MenuItems
     */
    public function setMenuitemWeight($menuitemWeight)
    {
        $this->menuitemWeight = $menuitemWeight;
    
        return $this;
    }

    /**
     * Get menuitemWeight
     *
     * @return integer 
     */
    public function getMenuitemWeight()
    {
        return $this->menuitemWeight;
    }
}
