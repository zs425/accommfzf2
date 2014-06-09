<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductMultimedia
 *
 * @ORM\Table(name="product_multimedia")
 * @ORM\Entity
 */
class ProductMultimedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="multimedia_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $multimediaId;

    /**
     * @var string
     *
     * @ORM\Column(name="multimedia_type", type="string", length=45, nullable=true)
     */
    private $multimediaType;

    /**
     * @var string
     *
     * @ORM\Column(name="multimedia_path", type="string", length=255, nullable=true)
     */
    private $multimediaPath;

    /**
     * @var string
     *
     * @ORM\Column(name="multimedia_description", type="text", nullable=true)
     */
    private $multimediaDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="multimedia_width", type="integer", nullable=true)
     */
    private $multimediaWidth;

    /**
     * @var integer
     *
     * @ORM\Column(name="multimedia_height", type="integer", nullable=true)
     */
    private $multimediaHeight;

    /**
     * @var string
     *
     * @ORM\Column(name="multimedia_source", type="string", length=45, nullable=true)
     */
    private $multimediaSource;

    /**
     * @var string
     *
     * @ORM\Column(name="multimedia_record_type", type="string", length=45, nullable=true)
     */
    private $multimediaRecordType;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Travel\Entity\Product", inversedBy="productMultimedia")
     * @ORM\JoinColumn(name="multimedia_record_id", referencedColumnName="product_id")
     * 
     */
    private $multimediaRecordId;

    /**
     * @var string
     *
     * @ORM\Column(name="multimedia_s3bucket", type="string", length=50, nullable=true)
     */
    private $multimediaS3bucket;

    /**
     * @var boolean
     *
     * @ORM\Column(name="multimedia_exists", type="boolean", nullable=true)
     */
    private $multimediaExists;

	/**
	 * @return the $multimediaId
	 */
	public function getMultimediaId() {
		return $this->multimediaId;
	}

	/**
	 * @param number $multimediaId
	 */
	public function setMultimediaId($multimediaId) {
		$this->multimediaId = $multimediaId;
	}

	/**
	 * @return the $multimediaType
	 */
	public function getMultimediaType() {
		return $this->multimediaType;
	}

	/**
	 * @param string $multimediaType
	 */
	public function setMultimediaType($multimediaType) {
		$this->multimediaType = $multimediaType;
	}

	/**
	 * @return the $multimediaPath
	 */
	public function getMultimediaPath() {
		return $this->multimediaPath;
	}

	/**
	 * @param string $multimediaPath
	 */
	public function setMultimediaPath($multimediaPath) {
		$this->multimediaPath = $multimediaPath;
	}

	/**
	 * @return the $multimediaDescription
	 */
	public function getMultimediaDescription() {
		return $this->multimediaDescription;
	}

	/**
	 * @param string $multimediaDescription
	 */
	public function setMultimediaDescription($multimediaDescription) {
		$this->multimediaDescription = $multimediaDescription;
	}

	/**
	 * @return the $multimediaWidth
	 */
	public function getMultimediaWidth() {
		return $this->multimediaWidth;
	}

	/**
	 * @param number $multimediaWidth
	 */
	public function setMultimediaWidth($multimediaWidth) {
		$this->multimediaWidth = $multimediaWidth;
	}

	/**
	 * @return the $multimediaHeight
	 */
	public function getMultimediaHeight() {
		return $this->multimediaHeight;
	}

	/**
	 * @param number $multimediaHeight
	 */
	public function setMultimediaHeight($multimediaHeight) {
		$this->multimediaHeight = $multimediaHeight;
	}

	/**
	 * @return the $multimediaSource
	 */
	public function getMultimediaSource() {
		return $this->multimediaSource;
	}

	/**
	 * @param string $multimediaSource
	 */
	public function setMultimediaSource($multimediaSource) {
		$this->multimediaSource = $multimediaSource;
	}

	/**
	 * @return the $multimediaRecordType
	 */
	public function getMultimediaRecordType() {
		return $this->multimediaRecordType;
	}

	/**
	 * @param string $multimediaRecordType
	 */
	public function setMultimediaRecordType($multimediaRecordType) {
		$this->multimediaRecordType = $multimediaRecordType;
	}

	/**
	 * @return the $multimediaRecordId
	 */
	public function getMultimediaRecordId() {
		return $this->multimediaRecordId;
	}

	/**
	 * @param number $multimediaRecordId
	 */
	public function setMultimediaRecordId($multimediaRecordId) {
		$this->multimediaRecordId = $multimediaRecordId;
	}

	/**
	 * @return the $multimediaS3bucket
	 */
	public function getMultimediaS3bucket() {
		return $this->multimediaS3bucket;
	}

	/**
	 * @param string $multimediaS3bucket
	 */
	public function setMultimediaS3bucket($multimediaS3bucket) {
		$this->multimediaS3bucket = $multimediaS3bucket;
	}

	/**
	 * @return the $multimediaExists
	 */
	public function getMultimediaExists() {
		return $this->multimediaExists;
	}

	/**
	 * @param boolean $multimediaExists
	 */
	public function setMultimediaExists($multimediaExists) {
		$this->multimediaExists = $multimediaExists;
	}
	
	public function setByArray($array){
        foreach($array as $key => $value) {
            if(method_exists($this, 'set'.ucfirst($key))) {
                $this->{'set'.ucfirst($key)}($value);    
            }            
        }
        return $this;
    }
}