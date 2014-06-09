<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecordsMultimedia
 *
 * @ORM\Table(name="records_multimedia")
 * @ORM\Entity
 */
class RecordMultimedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="recordmultimedia_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $recordmultimediaId;

    /**
     * @var string
     *
     * @ORM\Column(name="recordmultimedia_type", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaType;

    /**
     * @var string
     *
     * @ORM\Column(name="recordmultimedia_path", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaPath;

    /**
     * @var string
     *
     * @ORM\Column(name="recordmultimedia_description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="recordmultimedia_width", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaWidth;

    /**
     * @var integer
     *
     * @ORM\Column(name="recordmultimedia_height", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaHeight;

    /**
     * @var string
     *
     * @ORM\Column(name="recordmultimedia_source", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaSource;

    /**
     * @var string
     *
     * @ORM\Column(name="recordmultimedia_record_type", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaRecordType;

    /**
     * @var integer
     *
     * @ORM\Column(name="recordmultimedia_record_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaRecordId;

    /**
     * @var string
     *
     * @ORM\Column(name="recordmultimedia_s3bucket", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaS3bucket;

    /**
     * @var boolean
     *
     * @ORM\Column(name="recordmultimedia_exists", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $recordmultimediaExists;


    /**
     * Get recordmultimediaId
     *
     * @return integer 
     */
    public function getRecordmultimediaId()
    {
        return $this->recordmultimediaId;
    }

    /**
     * Set recordmultimediaType
     *
     * @param string $recordmultimediaType
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaType($recordmultimediaType)
    {
        $this->recordmultimediaType = $recordmultimediaType;
    
        return $this;
    }

    /**
     * Get recordmultimediaType
     *
     * @return string 
     */
    public function getRecordmultimediaType()
    {
        return $this->recordmultimediaType;
    }

    /**
     * Set recordmultimediaPath
     *
     * @param string $recordmultimediaPath
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaPath($recordmultimediaPath)
    {
        $this->recordmultimediaPath = $recordmultimediaPath;
    
        return $this;
    }

    /**
     * Get recordmultimediaPath
     *
     * @return string 
     */
    public function getRecordmultimediaPath()
    {
        return $this->recordmultimediaPath;
    }

    /**
     * Set recordmultimediaDescription
     *
     * @param string $recordmultimediaDescription
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaDescription($recordmultimediaDescription)
    {
        $this->recordmultimediaDescription = $recordmultimediaDescription;
    
        return $this;
    }

    /**
     * Get recordmultimediaDescription
     *
     * @return string 
     */
    public function getRecordmultimediaDescription()
    {
        return $this->recordmultimediaDescription;
    }

    /**
     * Set recordmultimediaWidth
     *
     * @param integer $recordmultimediaWidth
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaWidth($recordmultimediaWidth)
    {
        $this->recordmultimediaWidth = $recordmultimediaWidth;
    
        return $this;
    }

    /**
     * Get recordmultimediaWidth
     *
     * @return integer 
     */
    public function getRecordmultimediaWidth()
    {
        return $this->recordmultimediaWidth;
    }

    /**
     * Set recordmultimediaHeight
     *
     * @param integer $recordmultimediaHeight
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaHeight($recordmultimediaHeight)
    {
        $this->recordmultimediaHeight = $recordmultimediaHeight;
    
        return $this;
    }

    /**
     * Get recordmultimediaHeight
     *
     * @return integer 
     */
    public function getRecordmultimediaHeight()
    {
        return $this->recordmultimediaHeight;
    }

    /**
     * Set recordmultimediaSource
     *
     * @param string $recordmultimediaSource
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaSource($recordmultimediaSource)
    {
        $this->recordmultimediaSource = $recordmultimediaSource;
    
        return $this;
    }

    /**
     * Get recordmultimediaSource
     *
     * @return string 
     */
    public function getRecordmultimediaSource()
    {
        return $this->recordmultimediaSource;
    }

    /**
     * Set recordmultimediaRecordType
     *
     * @param string $recordmultimediaRecordType
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaRecordType($recordmultimediaRecordType)
    {
        $this->recordmultimediaRecordType = $recordmultimediaRecordType;
    
        return $this;
    }

    /**
     * Get recordmultimediaRecordType
     *
     * @return string 
     */
    public function getRecordmultimediaRecordType()
    {
        return $this->recordmultimediaRecordType;
    }

    /**
     * Set recordmultimediaRecordId
     *
     * @param integer $recordmultimediaRecordId
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaRecordId($recordmultimediaRecordId)
    {
        $this->recordmultimediaRecordId = $recordmultimediaRecordId;
    
        return $this;
    }

    /**
     * Get recordmultimediaRecordId
     *
     * @return integer 
     */
    public function getRecordmultimediaRecordId()
    {
        return $this->recordmultimediaRecordId;
    }

    /**
     * Set recordmultimediaS3bucket
     *
     * @param string $recordmultimediaS3bucket
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaS3bucket($recordmultimediaS3bucket)
    {
        $this->recordmultimediaS3bucket = $recordmultimediaS3bucket;
    
        return $this;
    }

    /**
     * Get recordmultimediaS3bucket
     *
     * @return string 
     */
    public function getRecordmultimediaS3bucket()
    {
        return $this->recordmultimediaS3bucket;
    }

    /**
     * Set recordmultimediaExists
     *
     * @param boolean $recordmultimediaExists
     * @return RecordsMultimedia
     */
    public function setRecordmultimediaExists($recordmultimediaExists)
    {
        $this->recordmultimediaExists = $recordmultimediaExists;
    
        return $this;
    }

    /**
     * Get recordmultimediaExists
     *
     * @return boolean 
     */
    public function getRecordmultimediaExists()
    {
        return $this->recordmultimediaExists;
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
