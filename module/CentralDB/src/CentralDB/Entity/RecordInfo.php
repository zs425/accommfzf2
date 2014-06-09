<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecordsInfo
 *
 * @ORM\Table(name="records_info")
 * @ORM\Entity
 */
class RecordInfo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="recordinfo_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $recordinfoId;

    /**
     * @var string
     *
     * @ORM\Column(name="recordinfo_code", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordinfoCode;

    /**
     * @var string
     *
     * @ORM\Column(name="recordinfo_title", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordinfoTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="recordinfo_body", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordinfoBody;

    /**
     * @var integer
     *
     * @ORM\Column(name="recordinfo_record_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordinfoRecordId;


    /**
     * Get recordinfoId
     *
     * @return integer 
     */
    public function getRecordinfoId()
    {
        return $this->recordinfoId;
    }

    /**
     * Set recordinfoCode
     *
     * @param string $recordinfoCode
     * @return RecordsInfo
     */
    public function setRecordinfoCode($recordinfoCode)
    {
        $this->recordinfoCode = $recordinfoCode;
    
        return $this;
    }

    /**
     * Get recordinfoCode
     *
     * @return string 
     */
    public function getRecordinfoCode()
    {
        return $this->recordinfoCode;
    }

    /**
     * Set recordinfoTitle
     *
     * @param string $recordinfoTitle
     * @return RecordsInfo
     */
    public function setRecordinfoTitle($recordinfoTitle)
    {
        $this->recordinfoTitle = $recordinfoTitle;
    
        return $this;
    }

    /**
     * Get recordinfoTitle
     *
     * @return string 
     */
    public function getRecordinfoTitle()
    {
        return $this->recordinfoTitle;
    }

    /**
     * Set recordinfoBody
     *
     * @param string $recordinfoBody
     * @return RecordsInfo
     */
    public function setRecordinfoBody($recordinfoBody)
    {
        $this->recordinfoBody = $recordinfoBody;
    
        return $this;
    }

    /**
     * Get recordinfoBody
     *
     * @return string 
     */
    public function getRecordinfoBody()
    {
        return $this->recordinfoBody;
    }

    /**
     * Set recordinfoRecordId
     *
     * @param integer $recordinfoRecordId
     * @return RecordsInfo
     */
    public function setRecordinfoRecordId($recordinfoRecordId)
    {
        $this->recordinfoRecordId = $recordinfoRecordId;
    
        return $this;
    }

    /**
     * Get recordinfoRecordId
     *
     * @return integer 
     */
    public function getRecordinfoRecordId()
    {
        return $this->recordinfoRecordId;
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
