<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Newareadomains
 *
 * @ORM\Table(name="newareadomains")
 * @ORM\Entity
 */
class Newareadomain
{
    /**
     * @var integer
     *
     * @ORM\Column(name="newareadomain_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $newareadomainId;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=120, precision=0, scale=0, nullable=true, unique=false)
     */
    private $domain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="area_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $areaId;


    /**
     * Get newareadomainId
     *
     * @return integer 
     */
    public function getNewareadomainId()
    {
        return $this->newareadomainId;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Newareadomains
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    
        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Newareadomains
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set areaId
     *
     * @param integer $areaId
     * @return Newareadomains
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;
    
        return $this;
    }

    /**
     * Get areaId
     *
     * @return integer 
     */
    public function getAreaId()
    {
        return $this->areaId;
    }
}
