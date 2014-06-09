<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductInfo
 *
 * @ORM\Table(name="product_info")
 * @ORM\Entity
 */
class ProductInfo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="info_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $infoId;

    /**
     * @var string
     *
     * @ORM\Column(name="info_code", type="string", length=45, nullable=true)
     */
    private $infoCode;

    /**
     * @var string
     *
     * @ORM\Column(name="info_title", type="string", length=255, nullable=true)
     */
    private $infoTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="info_body", type="text", nullable=true)
     */
    private $infoBody;

    /**
     * @var integer
     *
     * @ORM\Column(name="info_record_id", type="integer", nullable=true)
     */
    private $infoRecordId;

	/**
	 * @return the $infoId
	 */
	public function getInfoId() {
		return $this->infoId;
	}

	/**
	 * @param number $infoId
	 */
	public function setInfoId($infoId) {
		$this->infoId = $infoId;
	}

	/**
	 * @return the $infoCode
	 */
	public function getInfoCode() {
		return $this->infoCode;
	}

	/**
	 * @param string $infoCode
	 */
	public function setInfoCode($infoCode) {
		$this->infoCode = $infoCode;
	}

	/**
	 * @return the $infoTitle
	 */
	public function getInfoTitle() {
		return $this->infoTitle;
	}

	/**
	 * @param string $infoTitle
	 */
	public function setInfoTitle($infoTitle) {
		$this->infoTitle = $infoTitle;
	}

	/**
	 * @return the $infoBody
	 */
	public function getInfoBody() {
		return $this->infoBody;
	}

	/**
	 * @param string $infoBody
	 */
	public function setInfoBody($infoBody) {
		$this->infoBody = $infoBody;
	}

	/**
	 * @return the $infoRecordId
	 */
	public function getInfoRecordId() {
		return $this->infoRecordId;
	}

	/**
	 * @param number $infoRecordId
	 */
	public function setInfoRecordId($infoRecordId) {
		$this->infoRecordId = $infoRecordId;
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