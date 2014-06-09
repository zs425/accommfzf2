<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flags
 *
 * @ORM\Table(name="flags")
 * @ORM\Entity
 */
class Flag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="flag_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $flagId;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_item_id", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $flagItemId;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_item_type", type="string", length=50, precision=0, scale=0, nullable=true, unique=false)
     */
    private $flagItemType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="flag_date", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $flagDate;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_details", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $flagDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="flag_modified", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $flagModified;

    /**
     * @var string
     *
     * @ORM\Column(name="flag_related_info", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $flagRelatedInfo;


    /**
     * Get flagId
     *
     * @return integer 
     */
    public function getFlagId()
    {
        return $this->flagId;
    }

    /**
     * Set flagItemId
     *
     * @param string $flagItemId
     * @return Flags
     */
    public function setFlagItemId($flagItemId)
    {
        $this->flagItemId = $flagItemId;
    
        return $this;
    }

    /**
     * Get flagItemId
     *
     * @return string 
     */
    public function getFlagItemId()
    {
        return $this->flagItemId;
    }

    /**
     * Set flagItemType
     *
     * @param string $flagItemType
     * @return Flags
     */
    public function setFlagItemType($flagItemType)
    {
        $this->flagItemType = $flagItemType;
    
        return $this;
    }

    /**
     * Get flagItemType
     *
     * @return string 
     */
    public function getFlagItemType()
    {
        return $this->flagItemType;
    }

    /**
     * Set flagDate
     *
     * @param \DateTime $flagDate
     * @return Flags
     */
    public function setFlagDate($flagDate)
    {
        $this->flagDate = $flagDate;
    
        return $this;
    }

    /**
     * Get flagDate
     *
     * @return \DateTime 
     */
    public function getFlagDate()
    {
        return $this->flagDate;
    }

    /**
     * Set flagDetails
     *
     * @param string $flagDetails
     * @return Flags
     */
    public function setFlagDetails($flagDetails)
    {
        $this->flagDetails = $flagDetails;
    
        return $this;
    }

    /**
     * Get flagDetails
     *
     * @return string 
     */
    public function getFlagDetails()
    {
        return $this->flagDetails;
    }

    /**
     * Set flagModified
     *
     * @param \DateTime $flagModified
     * @return Flags
     */
    public function setFlagModified($flagModified)
    {
        $this->flagModified = $flagModified;
    
        return $this;
    }

    /**
     * Get flagModified
     *
     * @return \DateTime 
     */
    public function getFlagModified()
    {
        return $this->flagModified;
    }

    /**
     * Set flagRelatedInfo
     *
     * @param string $flagRelatedInfo
     * @return Flags
     */
    public function setFlagRelatedInfo($flagRelatedInfo)
    {
        $this->flagRelatedInfo = $flagRelatedInfo;
    
        return $this;
    }

    /**
     * Get flagRelatedInfo
     *
     * @return string 
     */
    public function getFlagRelatedInfo()
    {
        return $this->flagRelatedInfo;
    }
}
