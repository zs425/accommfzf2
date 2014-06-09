<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options2
 *
 * @ORM\Table(name="options2")
 * @ORM\Entity
 */
class Option2
{
    /**
     * @var integer
     *
     * @ORM\Column(name="option2_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $option2Id;

    /**
     * @var string
     *
     * @ORM\Column(name="option2_name", type="string", length=90, precision=0, scale=0, nullable=false, unique=false)
     */
    private $option2Name;

    /**
     * @var string
     *
     * @ORM\Column(name="option2_value", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $option2Value;

    /**
     * @var string
     *
     * @ORM\Column(name="option2_category", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $option2Category;


    /**
     * Get option2Id
     *
     * @return integer 
     */
    public function getOption2Id()
    {
        return $this->option2Id;
    }

    /**
     * Set option2Name
     *
     * @param string $option2Name
     * @return Options2
     */
    public function setOption2Name($option2Name)
    {
        $this->option2Name = $option2Name;
    
        return $this;
    }

    /**
     * Get option2Name
     *
     * @return string 
     */
    public function getOption2Name()
    {
        return $this->option2Name;
    }

    /**
     * Set option2Value
     *
     * @param string $option2Value
     * @return Options2
     */
    public function setOption2Value($option2Value)
    {
        $this->option2Value = $option2Value;
    
        return $this;
    }

    /**
     * Get option2Value
     *
     * @return string 
     */
    public function getOption2Value()
    {
        return $this->option2Value;
    }

    /**
     * Set option2Category
     *
     * @param string $option2Category
     * @return Options2
     */
    public function setOption2Category($option2Category)
    {
        $this->option2Category = $option2Category;
    
        return $this;
    }

    /**
     * Get option2Category
     *
     * @return string 
     */
    public function getOption2Category()
    {
        return $this->option2Category;
    }
}
