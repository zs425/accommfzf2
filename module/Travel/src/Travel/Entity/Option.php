<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 *
 * @ORM\Table(name="options")
 * @ORM\Entity
 */
class Option
{
    /**
     * @var integer
     *
     * @ORM\Column(name="option_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $optionId;

    /**
     * @var string
     *
     * @ORM\Column(name="option_name", type="string", length=90, nullable=false)
     */
    private $optionName;

    /**
     * @var string
     *
     * @ORM\Column(name="option_value", type="text", nullable=true)
     */
    private $optionValue;

    /**
     * @var string
     *
     * @ORM\Column(name="option_category", type="string", length=90, nullable=true)
     */
    private $optionCategory;

	/**
	 * @return the $optionId
	 */
	public function getOptionId() {
		return $this->optionId;
	}

	/**
	 * @param number $optionId
	 */
	public function setOptionId($optionId) {
		$this->optionId = $optionId;
	}

	/**
	 * @return the $optionName
	 */
	public function getOptionName() {
		return $this->optionName;
	}

	/**
	 * @param string $optionName
	 */
	public function setOptionName($optionName) {
		$this->optionName = $optionName;
	}

	/**
	 * @return the $optionValue
	 */
	public function getOptionValue() {
		return $this->optionValue;
	}

	/**
	 * @param string $optionValue
	 */
	public function setOptionValue($optionValue) {
		$this->optionValue = $optionValue;
	}

	/**
	 * @return the $optionCategory
	 */
	public function getOptionCategory() {
		return $this->optionCategory;
	}

	/**
	 * @param string $optionCategory
	 */
	public function setOptionCategory($optionCategory) {
		$this->optionCategory = $optionCategory;
	}
	
	public function getByArray() {
        return get_object_vars($this);        
    }
}