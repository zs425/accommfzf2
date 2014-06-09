<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Websites
 *
 * @ORM\Table(name="websites")
 * @ORM\Entity
 */
class Website
{
    /**
     * @var integer
     *
     * @ORM\Column(name="website_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $websiteId;

    /**
     * @var string
     *
     * @ORM\Column(name="website_name", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $websiteName;

    /**
     * @var string
     *
     * @ORM\Column(name="website_url", type="string", length=150, precision=0, scale=0, nullable=false, unique=false)
     */
    private $websiteUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="website_slug", type="string", length=30, precision=0, scale=0, nullable=false, unique=false)
     */
    private $websiteSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="website_previewsmall", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $websitePreviewsmall;

    /**
     * @var string
     *
     * @ORM\Column(name="website_previewlarge", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $websitePreviewlarge;

    /**
     * @var string
     *
     * @ORM\Column(name="website_categories", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $websiteCategories;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="website_added", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $websiteAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="website_expecteddate", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $websiteExpecteddate;

    /**
     * @var string
     *
     * @ORM\Column(name="website_shortdesc", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $websiteShortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="website_path", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $websitePath;

    /**
     * @var string
     *
     * @ORM\Column(name="website_autoupdate", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    private $websiteAutoupdate;


    /**
     * Get websiteId
     *
     * @return integer 
     */
    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    /**
     * Set websiteName
     *
     * @param string $websiteName
     * @return Websites
     */
    public function setWebsiteName($websiteName)
    {
        $this->websiteName = $websiteName;
    
        return $this;
    }

    /**
     * Get websiteName
     *
     * @return string 
     */
    public function getWebsiteName()
    {
        return $this->websiteName;
    }

    /**
     * Set websiteUrl
     *
     * @param string $websiteUrl
     * @return Websites
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    
        return $this;
    }

    /**
     * Get websiteUrl
     *
     * @return string 
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * Set websiteSlug
     *
     * @param string $websiteSlug
     * @return Websites
     */
    public function setWebsiteSlug($websiteSlug)
    {
        $this->websiteSlug = $websiteSlug;
    
        return $this;
    }

    /**
     * Get websiteSlug
     *
     * @return string 
     */
    public function getWebsiteSlug()
    {
        return $this->websiteSlug;
    }

    /**
     * Set websitePreviewsmall
     *
     * @param string $websitePreviewsmall
     * @return Websites
     */
    public function setWebsitePreviewsmall($websitePreviewsmall)
    {
        $this->websitePreviewsmall = $websitePreviewsmall;
    
        return $this;
    }

    /**
     * Get websitePreviewsmall
     *
     * @return string 
     */
    public function getWebsitePreviewsmall()
    {
        return $this->websitePreviewsmall;
    }

    /**
     * Set websitePreviewlarge
     *
     * @param string $websitePreviewlarge
     * @return Websites
     */
    public function setWebsitePreviewlarge($websitePreviewlarge)
    {
        $this->websitePreviewlarge = $websitePreviewlarge;
    
        return $this;
    }

    /**
     * Get websitePreviewlarge
     *
     * @return string 
     */
    public function getWebsitePreviewlarge()
    {
        return $this->websitePreviewlarge;
    }

    /**
     * Set websiteCategories
     *
     * @param string $websiteCategories
     * @return Websites
     */
    public function setWebsiteCategories($websiteCategories)
    {
        $this->websiteCategories = $websiteCategories;
    
        return $this;
    }

    /**
     * Get websiteCategories
     *
     * @return string 
     */
    public function getWebsiteCategories()
    {
        return $this->websiteCategories;
    }

    /**
     * Set websiteAdded
     *
     * @param \DateTime $websiteAdded
     * @return Websites
     */
    public function setWebsiteAdded($websiteAdded)
    {
        $this->websiteAdded = $websiteAdded;
    
        return $this;
    }

    /**
     * Get websiteAdded
     *
     * @return \DateTime 
     */
    public function getWebsiteAdded()
    {
        return $this->websiteAdded;
    }

    /**
     * Set websiteExpecteddate
     *
     * @param \DateTime $websiteExpecteddate
     * @return Websites
     */
    public function setWebsiteExpecteddate($websiteExpecteddate)
    {
        $this->websiteExpecteddate = $websiteExpecteddate;
    
        return $this;
    }

    /**
     * Get websiteExpecteddate
     *
     * @return \DateTime 
     */
    public function getWebsiteExpecteddate()
    {
        return $this->websiteExpecteddate;
    }

    /**
     * Set websiteShortdesc
     *
     * @param string $websiteShortdesc
     * @return Websites
     */
    public function setWebsiteShortdesc($websiteShortdesc)
    {
        $this->websiteShortdesc = $websiteShortdesc;
    
        return $this;
    }

    /**
     * Get websiteShortdesc
     *
     * @return string 
     */
    public function getWebsiteShortdesc()
    {
        return $this->websiteShortdesc;
    }

    /**
     * Set websitePath
     *
     * @param string $websitePath
     * @return Websites
     */
    public function setWebsitePath($websitePath)
    {
        $this->websitePath = $websitePath;
    
        return $this;
    }

    /**
     * Get websitePath
     *
     * @return string 
     */
    public function getWebsitePath()
    {
        return $this->websitePath;
    }

    /**
     * Set websiteAutoupdate
     *
     * @param string $websiteAutoupdate
     * @return Websites
     */
    public function setWebsiteAutoupdate($websiteAutoupdate)
    {
        $this->websiteAutoupdate = $websiteAutoupdate;
    
        return $this;
    }

    /**
     * Get websiteAutoupdate
     *
     * @return string 
     */
    public function getWebsiteAutoupdate()
    {
        return $this->websiteAutoupdate;
    }
    
    public function setByArray($array){
        foreach($array as $key => $value) {
            if(method_exists($this, 'set'.ucfirst($key))) {
                $this->{'set'.ucfirst($key)}($value);    
            }            
        }
        return $this;
    }
    
    public function getByArray() {
        return get_object_vars($this);        
    }
}
