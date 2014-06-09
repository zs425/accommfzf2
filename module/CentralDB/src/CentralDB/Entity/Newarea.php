<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Newareas
 *
 * @ORM\Table(name="newareas")
 * @ORM\Entity
 */
class Newarea
{
    /**
     * @var integer
     *
     * @ORM\Column(name="newarea_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $newareaId;

    /**
     * @var string
     *
     * @ORM\Column(name="newarea_name", type="string", length=80, precision=0, scale=0, nullable=true, unique=false)
     */
    private $newareaName;

    /**
     * @var integer
     *
     * @ORM\Column(name="newarea_searchglobal", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newareaSearchglobal;

    /**
     * @var integer
     *
     * @ORM\Column(name="newarea_searchlocal", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newareaSearchlocal;

    /**
     * @var float
     *
     * @ORM\Column(name="newarea_difficulty", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newareaDifficulty;

    /**
     * @var integer
     *
     * @ORM\Column(name="newarea_weight", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newareaWeight;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="checked", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    private $checked;

    /**
     * @var integer
     *
     * @ORM\Column(name="hotels", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $hotels;

    /**
     * @var integer
     *
     * @ORM\Column(name="destination_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $destinationId;


    /**
     * Get newareaId
     *
     * @return integer 
     */
    public function getNewareaId()
    {
        return $this->newareaId;
    }

    /**
     * Set newareaName
     *
     * @param string $newareaName
     * @return Newareas
     */
    public function setNewareaName($newareaName)
    {
        $this->newareaName = $newareaName;
    
        return $this;
    }

    /**
     * Get newareaName
     *
     * @return string 
     */
    public function getNewareaName()
    {
        return $this->newareaName;
    }

    /**
     * Set newareaSearchglobal
     *
     * @param integer $newareaSearchglobal
     * @return Newareas
     */
    public function setNewareaSearchglobal($newareaSearchglobal)
    {
        $this->newareaSearchglobal = $newareaSearchglobal;
    
        return $this;
    }

    /**
     * Get newareaSearchglobal
     *
     * @return integer 
     */
    public function getNewareaSearchglobal()
    {
        return $this->newareaSearchglobal;
    }

    /**
     * Set newareaSearchlocal
     *
     * @param integer $newareaSearchlocal
     * @return Newareas
     */
    public function setNewareaSearchlocal($newareaSearchlocal)
    {
        $this->newareaSearchlocal = $newareaSearchlocal;
    
        return $this;
    }

    /**
     * Get newareaSearchlocal
     *
     * @return integer 
     */
    public function getNewareaSearchlocal()
    {
        return $this->newareaSearchlocal;
    }

    /**
     * Set newareaDifficulty
     *
     * @param float $newareaDifficulty
     * @return Newareas
     */
    public function setNewareaDifficulty($newareaDifficulty)
    {
        $this->newareaDifficulty = $newareaDifficulty;
    
        return $this;
    }

    /**
     * Get newareaDifficulty
     *
     * @return float 
     */
    public function getNewareaDifficulty()
    {
        return $this->newareaDifficulty;
    }

    /**
     * Set newareaWeight
     *
     * @param integer $newareaWeight
     * @return Newareas
     */
    public function setNewareaWeight($newareaWeight)
    {
        $this->newareaWeight = $newareaWeight;
    
        return $this;
    }

    /**
     * Get newareaWeight
     *
     * @return integer 
     */
    public function getNewareaWeight()
    {
        return $this->newareaWeight;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Newareas
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set checked
     *
     * @param string $checked
     * @return Newareas
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;
    
        return $this;
    }

    /**
     * Get checked
     *
     * @return string 
     */
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * Set hotels
     *
     * @param integer $hotels
     * @return Newareas
     */
    public function setHotels($hotels)
    {
        $this->hotels = $hotels;
    
        return $this;
    }

    /**
     * Get hotels
     *
     * @return integer 
     */
    public function getHotels()
    {
        return $this->hotels;
    }

    /**
     * Set destinationId
     *
     * @param integer $destinationId
     * @return Newareas
     */
    public function setDestinationId($destinationId)
    {
        $this->destinationId = $destinationId;
    
        return $this;
    }

    /**
     * Get destinationId
     *
     * @return integer 
     */
    public function getDestinationId()
    {
        return $this->destinationId;
    }
}
