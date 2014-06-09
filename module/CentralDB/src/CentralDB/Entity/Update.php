<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Updates
 *
 * @ORM\Table(name="updates")
 * @ORM\Entity
 */
class Update
{
    /**
     * @var integer
     *
     * @ORM\Column(name="update_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $updateId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $end;


    /**
     * Get updateId
     *
     * @return integer 
     */
    public function getUpdateId()
    {
        return $this->updateId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Updates
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return Updates
     */
    public function setStart($start)
    {
        $this->start = $start;
    
        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Updates
     */
    public function setEnd($end)
    {
        $this->end = $end;
    
        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }
}
