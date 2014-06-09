<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nltemplates
 *
 * @ORM\Table(name="nltemplates")
 * @ORM\Entity
 */
class Nltemplate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="nltemplate_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nltemplateId;

    /**
     * @var string
     *
     * @ORM\Column(name="nltemplate_name", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $nltemplateName;

    /**
     * @var string
     *
     * @ORM\Column(name="nltemplate_content", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $nltemplateContent;

    /**
     * @var string
     *
     * @ORM\Column(name="nltemplate_screenshot", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $nltemplateScreenshot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nltemplate_created", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $nltemplateCreated;


    /**
     * Get nltemplateId
     *
     * @return integer 
     */
    public function getNltemplateId()
    {
        return $this->nltemplateId;
    }

    /**
     * Set nltemplateName
     *
     * @param string $nltemplateName
     * @return Nltemplates
     */
    public function setNltemplateName($nltemplateName)
    {
        $this->nltemplateName = $nltemplateName;
    
        return $this;
    }

    /**
     * Get nltemplateName
     *
     * @return string 
     */
    public function getNltemplateName()
    {
        return $this->nltemplateName;
    }

    /**
     * Set nltemplateContent
     *
     * @param string $nltemplateContent
     * @return Nltemplates
     */
    public function setNltemplateContent($nltemplateContent)
    {
        $this->nltemplateContent = $nltemplateContent;
    
        return $this;
    }

    /**
     * Get nltemplateContent
     *
     * @return string 
     */
    public function getNltemplateContent()
    {
        return $this->nltemplateContent;
    }

    /**
     * Set nltemplateScreenshot
     *
     * @param string $nltemplateScreenshot
     * @return Nltemplates
     */
    public function setNltemplateScreenshot($nltemplateScreenshot)
    {
        $this->nltemplateScreenshot = $nltemplateScreenshot;
    
        return $this;
    }

    /**
     * Get nltemplateScreenshot
     *
     * @return string 
     */
    public function getNltemplateScreenshot()
    {
        return $this->nltemplateScreenshot;
    }

    /**
     * Set nltemplateCreated
     *
     * @param \DateTime $nltemplateCreated
     * @return Nltemplates
     */
    public function setNltemplateCreated($nltemplateCreated)
    {
        $this->nltemplateCreated = $nltemplateCreated;
    
        return $this;
    }

    /**
     * Get nltemplateCreated
     *
     * @return \DateTime 
     */
    public function getNltemplateCreated()
    {
        return $this->nltemplateCreated;
    }
}
