<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nlsubscribers
 *
 * @ORM\Table(name="nlsubscribers")
 * @ORM\Entity
 */
class Nlsubscriber
{
    /**
     * @var integer
     *
     * @ORM\Column(name="nlsubscriber_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nlsubscriberId;

    /**
     * @var string
     *
     * @ORM\Column(name="nlsubscriber_name", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nlsubscriberName;

    /**
     * @var string
     *
     * @ORM\Column(name="nlsubscriber_email", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nlsubscriberEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="nlsubscriber_status", type="string", length=90, precision=0, scale=0, nullable=true, unique=false)
     */
    private $nlsubscriberStatus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nlsubscriber_datejoin", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $nlsubscriberDatejoin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="nlsubscriber_dateconfirm", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $nlsubscriberDateconfirm;

    /**
     * @var string
     *
     * @ORM\Column(name="nlsubscriber_confirmlink", type="string", length=36, precision=0, scale=0, nullable=true, unique=false)
     */
    private $nlsubscriberConfirmlink;


    /**
     * Get nlsubscriberId
     *
     * @return integer 
     */
    public function getNlsubscriberId()
    {
        return $this->nlsubscriberId;
    }

    /**
     * Set nlsubscriberName
     *
     * @param string $nlsubscriberName
     * @return Nlsubscribers
     */
    public function setNlsubscriberName($nlsubscriberName)
    {
        $this->nlsubscriberName = $nlsubscriberName;
    
        return $this;
    }

    /**
     * Get nlsubscriberName
     *
     * @return string 
     */
    public function getNlsubscriberName()
    {
        return $this->nlsubscriberName;
    }

    /**
     * Set nlsubscriberEmail
     *
     * @param string $nlsubscriberEmail
     * @return Nlsubscribers
     */
    public function setNlsubscriberEmail($nlsubscriberEmail)
    {
        $this->nlsubscriberEmail = $nlsubscriberEmail;
    
        return $this;
    }

    /**
     * Get nlsubscriberEmail
     *
     * @return string 
     */
    public function getNlsubscriberEmail()
    {
        return $this->nlsubscriberEmail;
    }

    /**
     * Set nlsubscriberStatus
     *
     * @param string $nlsubscriberStatus
     * @return Nlsubscribers
     */
    public function setNlsubscriberStatus($nlsubscriberStatus)
    {
        $this->nlsubscriberStatus = $nlsubscriberStatus;
    
        return $this;
    }

    /**
     * Get nlsubscriberStatus
     *
     * @return string 
     */
    public function getNlsubscriberStatus()
    {
        return $this->nlsubscriberStatus;
    }

    /**
     * Set nlsubscriberDatejoin
     *
     * @param \DateTime $nlsubscriberDatejoin
     * @return Nlsubscribers
     */
    public function setNlsubscriberDatejoin($nlsubscriberDatejoin)
    {
        $this->nlsubscriberDatejoin = $nlsubscriberDatejoin;
    
        return $this;
    }

    /**
     * Get nlsubscriberDatejoin
     *
     * @return \DateTime 
     */
    public function getNlsubscriberDatejoin()
    {
        return $this->nlsubscriberDatejoin;
    }

    /**
     * Set nlsubscriberDateconfirm
     *
     * @param \DateTime $nlsubscriberDateconfirm
     * @return Nlsubscribers
     */
    public function setNlsubscriberDateconfirm($nlsubscriberDateconfirm)
    {
        $this->nlsubscriberDateconfirm = $nlsubscriberDateconfirm;
    
        return $this;
    }

    /**
     * Get nlsubscriberDateconfirm
     *
     * @return \DateTime 
     */
    public function getNlsubscriberDateconfirm()
    {
        return $this->nlsubscriberDateconfirm;
    }

    /**
     * Set nlsubscriberConfirmlink
     *
     * @param string $nlsubscriberConfirmlink
     * @return Nlsubscribers
     */
    public function setNlsubscriberConfirmlink($nlsubscriberConfirmlink)
    {
        $this->nlsubscriberConfirmlink = $nlsubscriberConfirmlink;
    
        return $this;
    }

    /**
     * Get nlsubscriberConfirmlink
     *
     * @return string 
     */
    public function getNlsubscriberConfirmlink()
    {
        return $this->nlsubscriberConfirmlink;
    }
}
