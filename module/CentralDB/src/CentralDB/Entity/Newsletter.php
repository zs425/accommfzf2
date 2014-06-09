<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Newsletters
 *
 * @ORM\Table(name="newsletters")
 * @ORM\Entity
 */
class Newsletter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $newsletterId;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_template", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $newsletterTemplate;

    /**
     * @var string
     *
     * @ORM\Column(name="newsletter_subject", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="newsletter_content", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterContent;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_created", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_modified", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterModified;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_recipientsok", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterRecipientsok;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_recipientsfail", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterRecipientsfail;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_start", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterStart;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_finish", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $newsletterFinish;


    /**
     * Get newsletterId
     *
     * @return integer 
     */
    public function getNewsletterId()
    {
        return $this->newsletterId;
    }

    /**
     * Set newsletterTemplate
     *
     * @param integer $newsletterTemplate
     * @return Newsletters
     */
    public function setNewsletterTemplate($newsletterTemplate)
    {
        $this->newsletterTemplate = $newsletterTemplate;
    
        return $this;
    }

    /**
     * Get newsletterTemplate
     *
     * @return integer 
     */
    public function getNewsletterTemplate()
    {
        return $this->newsletterTemplate;
    }

    /**
     * Set newsletterSubject
     *
     * @param string $newsletterSubject
     * @return Newsletters
     */
    public function setNewsletterSubject($newsletterSubject)
    {
        $this->newsletterSubject = $newsletterSubject;
    
        return $this;
    }

    /**
     * Get newsletterSubject
     *
     * @return string 
     */
    public function getNewsletterSubject()
    {
        return $this->newsletterSubject;
    }

    /**
     * Set newsletterContent
     *
     * @param string $newsletterContent
     * @return Newsletters
     */
    public function setNewsletterContent($newsletterContent)
    {
        $this->newsletterContent = $newsletterContent;
    
        return $this;
    }

    /**
     * Get newsletterContent
     *
     * @return string 
     */
    public function getNewsletterContent()
    {
        return $this->newsletterContent;
    }

    /**
     * Set newsletterCreated
     *
     * @param integer $newsletterCreated
     * @return Newsletters
     */
    public function setNewsletterCreated($newsletterCreated)
    {
        $this->newsletterCreated = $newsletterCreated;
    
        return $this;
    }

    /**
     * Get newsletterCreated
     *
     * @return integer 
     */
    public function getNewsletterCreated()
    {
        return $this->newsletterCreated;
    }

    /**
     * Set newsletterModified
     *
     * @param integer $newsletterModified
     * @return Newsletters
     */
    public function setNewsletterModified($newsletterModified)
    {
        $this->newsletterModified = $newsletterModified;
    
        return $this;
    }

    /**
     * Get newsletterModified
     *
     * @return integer 
     */
    public function getNewsletterModified()
    {
        return $this->newsletterModified;
    }

    /**
     * Set newsletterRecipientsok
     *
     * @param integer $newsletterRecipientsok
     * @return Newsletters
     */
    public function setNewsletterRecipientsok($newsletterRecipientsok)
    {
        $this->newsletterRecipientsok = $newsletterRecipientsok;
    
        return $this;
    }

    /**
     * Get newsletterRecipientsok
     *
     * @return integer 
     */
    public function getNewsletterRecipientsok()
    {
        return $this->newsletterRecipientsok;
    }

    /**
     * Set newsletterRecipientsfail
     *
     * @param integer $newsletterRecipientsfail
     * @return Newsletters
     */
    public function setNewsletterRecipientsfail($newsletterRecipientsfail)
    {
        $this->newsletterRecipientsfail = $newsletterRecipientsfail;
    
        return $this;
    }

    /**
     * Get newsletterRecipientsfail
     *
     * @return integer 
     */
    public function getNewsletterRecipientsfail()
    {
        return $this->newsletterRecipientsfail;
    }

    /**
     * Set newsletterStart
     *
     * @param integer $newsletterStart
     * @return Newsletters
     */
    public function setNewsletterStart($newsletterStart)
    {
        $this->newsletterStart = $newsletterStart;
    
        return $this;
    }

    /**
     * Get newsletterStart
     *
     * @return integer 
     */
    public function getNewsletterStart()
    {
        return $this->newsletterStart;
    }

    /**
     * Set newsletterFinish
     *
     * @param integer $newsletterFinish
     * @return Newsletters
     */
    public function setNewsletterFinish($newsletterFinish)
    {
        $this->newsletterFinish = $newsletterFinish;
    
        return $this;
    }

    /**
     * Get newsletterFinish
     *
     * @return integer 
     */
    public function getNewsletterFinish()
    {
        return $this->newsletterFinish;
    }
}
