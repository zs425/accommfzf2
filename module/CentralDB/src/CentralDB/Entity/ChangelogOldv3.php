<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChangelogsOldv3
 *
 * @ORM\Table(name="changelogs-oldv3")
 * @ORM\Entity
 */
class ChangelogOldv3
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
     * @return ChangelogsOldv3
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
     * @return ChangelogsOldv3
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
     * @return ChangelogsOldv3
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
     * @return ChangelogsOldv3
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
     * @return ChangelogsOldv3
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
     * @return ChangelogsOldv3
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
     * @return ChangelogsOldv3
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
}
