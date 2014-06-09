<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Changelogs
 *
 * @ORM\Table(name="changelogs")
 * @ORM\Entity
 */
class Changelog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="record_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordId;

    /**
     * @var string
     *
     * @ORM\Column(name="record_type", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordType;

    /**
     * @var string
     *
     * @ORM\Column(name="record_field", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordField;

    /**
     * @var string
     *
     * @ORM\Column(name="originalvalue", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $originalvalue;

    /**
     * @var string
     *
     * @ORM\Column(name="newvalue", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newvalue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="changetype", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $changetype;

    /**
     * @var integer
     *
     * @ORM\Column(name="other_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $otherId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, precision=0, scale=0, nullable=true, unique=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="update_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $updateId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set recordId
     *
     * @param integer $recordId
     * @return Changelogs
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
    
        return $this;
    }

    /**
     * Get recordId
     *
     * @return integer 
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * Set recordType
     *
     * @param string $recordType
     * @return Changelogs
     */
    public function setRecordType($recordType)
    {
        $this->recordType = $recordType;
    
        return $this;
    }

    /**
     * Get recordType
     *
     * @return string 
     */
    public function getRecordType()
    {
        return $this->recordType;
    }

    /**
     * Set recordField
     *
     * @param string $recordField
     * @return Changelogs
     */
    public function setRecordField($recordField)
    {
        $this->recordField = $recordField;
    
        return $this;
    }

    /**
     * Get recordField
     *
     * @return string 
     */
    public function getRecordField()
    {
        return $this->recordField;
    }

    /**
     * Set originalvalue
     *
     * @param string $originalvalue
     * @return Changelogs
     */
    public function setOriginalvalue($originalvalue)
    {
        $this->originalvalue = $originalvalue;
    
        return $this;
    }

    /**
     * Get originalvalue
     *
     * @return string 
     */
    public function getOriginalvalue()
    {
        return $this->originalvalue;
    }

    /**
     * Set newvalue
     *
     * @param string $newvalue
     * @return Changelogs
     */
    public function setNewvalue($newvalue)
    {
        $this->newvalue = $newvalue;
    
        return $this;
    }

    /**
     * Get newvalue
     *
     * @return string 
     */
    public function getNewvalue()
    {
        return $this->newvalue;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Changelogs
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set changetype
     *
     * @param string $changetype
     * @return Changelogs
     */
    public function setChangetype($changetype)
    {
        $this->changetype = $changetype;
    
        return $this;
    }

    /**
     * Get changetype
     *
     * @return string 
     */
    public function getChangetype()
    {
        return $this->changetype;
    }

    /**
     * Set otherId
     *
     * @param integer $otherId
     * @return Changelogs
     */
    public function setOtherId($otherId)
    {
        $this->otherId = $otherId;
    
        return $this;
    }

    /**
     * Get otherId
     *
     * @return integer 
     */
    public function getOtherId()
    {
        return $this->otherId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Changelogs
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set updateId
     *
     * @param integer $updateId
     * @return Changelogs
     */
    public function setUpdateId($updateId)
    {
        $this->updateId = $updateId;
    
        return $this;
    }

    /**
     * Get updateId
     *
     * @return integer 
     */
    public function getUpdateId()
    {
        return $this->updateId;
    }
}
