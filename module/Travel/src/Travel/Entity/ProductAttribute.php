<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAttributes
 *
 * @ORM\Table(name="product_attributes")
 * @ORM\Entity
 */
class ProductAttribute
{
    /**
     * @var integer
     *
     * @ORM\Column(name="attr_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $attrId;

    /**
     * @var string
     *
     * @ORM\Column(name="attr_type", type="string", length=45, nullable=true)
     */
    private $attrType;

    /**
     * @var string
     *
     * @ORM\Column(name="attr_code", type="string", length=45, nullable=true)
     */
    private $attrCode;

    /**
     * @var string
     *
     * @ORM\Column(name="attr_name", type="string", length=255, nullable=true)
     */
    private $attrName;

    /**
     * @var string
     *
     * @ORM\Column(name="attr_record_type", type="string", length=45, nullable=true)
     */
    private $attrRecordType;

    /**
     * @var integer
     *
     * @ORM\Column(name="attr_record_id", type="integer", nullable=true)
     */
    private $attrRecordId;

	/**
	 * @return the $attrId
	 */
	public function getAttrId() {
		return $this->attrId;
	}

	/**
	 * @param number $attrId
	 */
	public function setAttrId($attrId) {
		$this->attrId = $attrId;
	}

	/**
	 * @return the $attrType
	 */
	public function getAttrType() {
		return $this->attrType;
	}

	/**
	 * @param string $attrType
	 */
	public function setAttrType($attrType) {
		$this->attrType = $attrType;
	}

	/**
	 * @return the $attrCode
	 */
	public function getAttrCode() {
		return $this->attrCode;
	}

	/**
	 * @param string $attrCode
	 */
	public function setAttrCode($attrCode) {
		$this->attrCode = $attrCode;
	}

	/**
	 * @return the $attrName
	 */
	public function getAttrName() {
		return $this->attrName;
	}

	/**
	 * @param string $attrName
	 */
	public function setAttrName($attrName) {
		$this->attrName = $attrName;
	}

	/**
	 * @return the $attrRecordType
	 */
	public function getAttrRecordType() {
		return $this->attrRecordType;
	}

	/**
	 * @param string $attrRecordType
	 */
	public function setAttrRecordType($attrRecordType) {
		$this->attrRecordType = $attrRecordType;
	}

	/**
	 * @return the $attrRecordId
	 */
	public function getAttrRecordId() {
		return $this->attrRecordId;
	}

	/**
	 * @param number $attrRecordId
	 */
	public function setAttrRecordId($attrRecordId) {
		$this->attrRecordId = $attrRecordId;
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