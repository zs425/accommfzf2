<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Websitecategories
 *
 * @ORM\Table(name="websitecategories")
 * @ORM\Entity
 */
class Websitecategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="websitecategory_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $websitecategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="websitecategory_name", type="string", length=30, precision=0, scale=0, nullable=true, unique=false)
     */
    private $websitecategoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="websitecategory_slug", type="string", length=30, precision=0, scale=0, nullable=true, unique=false)
     */
    private $websitecategorySlug;

    /**
     * @var string
     *
     * @ORM\Column(name="websitecategory_shortdesc", type="string", length=1000, precision=0, scale=0, nullable=true, unique=false)
     */
    private $websitecategoryShortdesc;


    /**
     * Get websitecategoryId
     *
     * @return integer 
     */
    public function getWebsitecategoryId()
    {
        return $this->websitecategoryId;
    }

    /**
     * Set websitecategoryName
     *
     * @param string $websitecategoryName
     * @return Websitecategories
     */
    public function setWebsitecategoryName($websitecategoryName)
    {
        $this->websitecategoryName = $websitecategoryName;
    
        return $this;
    }

    /**
     * Get websitecategoryName
     *
     * @return string 
     */
    public function getWebsitecategoryName()
    {
        return $this->websitecategoryName;
    }

    /**
     * Set websitecategorySlug
     *
     * @param string $websitecategorySlug
     * @return Websitecategories
     */
    public function setWebsitecategorySlug($websitecategorySlug)
    {
        $this->websitecategorySlug = $websitecategorySlug;
    
        return $this;
    }

    /**
     * Get websitecategorySlug
     *
     * @return string 
     */
    public function getWebsitecategorySlug()
    {
        return $this->websitecategorySlug;
    }

    /**
     * Set websitecategoryShortdesc
     *
     * @param string $websitecategoryShortdesc
     * @return Websitecategories
     */
    public function setWebsitecategoryShortdesc($websitecategoryShortdesc)
    {
        $this->websitecategoryShortdesc = $websitecategoryShortdesc;
    
        return $this;
    }

    /**
     * Get websitecategoryShortdesc
     *
     * @return string 
     */
    public function getWebsitecategoryShortdesc()
    {
        return $this->websitecategoryShortdesc;
    }
}
