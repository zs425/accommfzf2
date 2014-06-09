<?php

namespace CentralDB\Entity;

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
     * @ORM\Column(name="option_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $optionId;

    /**
     * @var string
     *
     * @ORM\Column(name="option_name", type="string", length=90, precision=0, scale=0, nullable=false, unique=false)
     */
    private $optionName;

    /**
     * @var string
     *
     * @ORM\Column(name="option_value", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $optionValue;

    /**
     * @var string
     *
     * @ORM\Column(name="option_category", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $optionCategory;


    /**
     * Get optionId
     *
     * @return integer 
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * Set optionName
     *
     * @param string $optionName
     * @return Options
     */
    public function setOptionName($optionName)
    {
        $this->optionName = $optionName;
    
        return $this;
    }

    /**
     * Get optionName
     *
     * @return string 
     */
    public function getOptionName()
    {
        return $this->optionName;
    }

    /**
     * Set optionValue
     *
     * @param string $optionValue
     * @return Options
     */
    public function setOptionValue($optionValue)
    {
        $this->optionValue = $optionValue;
    
        return $this;
    }

    /**
     * Get optionValue
     *
     * @return string 
     */
    public function getOptionValue()
    {
        return $this->optionValue;
    }

    /**
     * Set optionCategory
     *
     * @param string $optionCategory
     * @return Options
     */
    public function setOptionCategory($optionCategory)
    {
        $this->optionCategory = $optionCategory;
    
        return $this;
    }

    /**
     * Get optionCategory
     *
     * @return string 
     */
    public function getOptionCategory()
    {
        return $this->optionCategory;
    }
}
