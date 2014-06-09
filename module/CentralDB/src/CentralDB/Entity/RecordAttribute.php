<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecordsAttributes
 *
 * @ORM\Table(name="records_attributes")
 * @ORM\Entity
 */
class RecordAttribute
{
    /**
     * @var integer
     *
     * @ORM\Column(name="baorecordattr_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $baorecordattrId;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecordattr_type", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordattrType;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecordattr_code", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordattrCode;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecordattr_name", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordattrName;

    /**
     * @var string
     *
     * @ORM\Column(name="baorecordattr_record_type", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordattrRecordType;

    /**
     * @var integer
     *
     * @ORM\Column(name="baorecordattr_record_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $baorecordattrRecordId;


    /**
     * Get baorecordattrId
     *
     * @return integer 
     */
    public function getBaorecordattrId()
    {
        return $this->baorecordattrId;
    }

    /**
     * Set baorecordattrType
     *
     * @param string $baorecordattrType
     * @return RecordsAttributes
     */
    public function setBaorecordattrType($baorecordattrType)
    {
        $this->baorecordattrType = $baorecordattrType;
    
        return $this;
    }

    /**
     * Get baorecordattrType
     *
     * @return string 
     */
    public function getBaorecordattrType()
    {
        return $this->baorecordattrType;
    }

    /**
     * Set baorecordattrCode
     *
     * @param string $baorecordattrCode
     * @return RecordsAttributes
     */
    public function setBaorecordattrCode($baorecordattrCode)
    {
        $this->baorecordattrCode = $baorecordattrCode;
    
        return $this;
    }

    /**
     * Get baorecordattrCode
     *
     * @return string 
     */
    public function getBaorecordattrCode()
    {
        return $this->baorecordattrCode;
    }

    /**
     * Set baorecordattrName
     *
     * @param string $baorecordattrName
     * @return RecordsAttributes
     */
    public function setBaorecordattrName($baorecordattrName)
    {
        $this->baorecordattrName = $baorecordattrName;
    
        return $this;
    }

    /**
     * Get baorecordattrName
     *
     * @return string 
     */
    public function getBaorecordattrName()
    {
        return $this->baorecordattrName;
    }

    /**
     * Set baorecordattrRecordType
     *
     * @param string $baorecordattrRecordType
     * @return RecordsAttributes
     */
    public function setBaorecordattrRecordType($baorecordattrRecordType)
    {
        $this->baorecordattrRecordType = $baorecordattrRecordType;
    
        return $this;
    }

    /**
     * Get baorecordattrRecordType
     *
     * @return string 
     */
    public function getBaorecordattrRecordType()
    {
        return $this->baorecordattrRecordType;
    }

    /**
     * Set baorecordattrRecordId
     *
     * @param integer $baorecordattrRecordId
     * @return RecordsAttributes
     */
    public function setBaorecordattrRecordId($baorecordattrRecordId)
    {
        $this->baorecordattrRecordId = $baorecordattrRecordId;
    
        return $this;
    }

    /**
     * Get baorecordattrRecordId
     *
     * @return integer 
     */
    public function getBaorecordattrRecordId()
    {
        return $this->baorecordattrRecordId;
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
