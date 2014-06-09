<?php

namespace CentralDB\Entity;

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
     * @ORM\Column(name="menu_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $menuId;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_title", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="menu_description", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $menuDescription;


    /**
     * Get menuId
     *
     * @return integer 
     */
    public function getMenuId()
    {
        return $this->menuId;
    }

    /**
     * Set menuTitle
     *
     * @param string $menuTitle
     * @return Menus
     */
    public function setMenuTitle($menuTitle)
    {
        $this->menuTitle = $menuTitle;
    
        return $this;
    }

    /**
     * Get menuTitle
     *
     * @return string 
     */
    public function getMenuTitle()
    {
        return $this->menuTitle;
    }

    /**
     * Set menuDescription
     *
     * @param string $menuDescription
     * @return Menus
     */
    public function setMenuDescription($menuDescription)
    {
        $this->menuDescription = $menuDescription;
    
        return $this;
    }

    /**
     * Get menuDescription
     *
     * @return string 
     */
    public function getMenuDescription()
    {
        return $this->menuDescription;
    }
}
