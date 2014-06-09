<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="content")
 * @ORM\Entity
 */
class Content
{
    /**
     * @var integer
     *
     * @ORM\Column(name="content_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $contentId;

    /**
     * @var string
     *
     * @ORM\Column(name="content_title", type="text", nullable=false)
     */
    private $contentTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="content_shortdesc", type="text", nullable=true)
     */
    private $contentShortdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="content_body", type="text", nullable=true)
     */
    private $contentBody;

    /**
     * @var integer
     *
     * @ORM\Column(name="content_created", type="integer", nullable=true)
     */
    private $contentCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="content_status", type="string", length=90, nullable=true)
     */
    private $contentStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="content_metatitle", type="text", nullable=true)
     */
    private $contentMetatitle;

    /**
     * @var string
     *
     * @ORM\Column(name="content_metakeywords", type="text", nullable=true)
     */
    private $contentMetakeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="content_metadescription", type="text", nullable=true)
     */
    private $contentMetadescription;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Travel\Entity\User", inversedBy="createdContent")
     * @ORM\JoinColumn(name="content_user_id", referencedColumnName="user_id")
     */
    private $contentUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="content_type", type="string", length=90, nullable=false)
     */
    private $contentType = 'page';

	/**
	 * @return the $contentId
	 */
	public function getContentId() {
		return $this->contentId;
	}

	/**
	 * @param number $contentId
	 */
	public function setContentId($contentId) {
		$this->contentId = $contentId;
	}

	/**
	 * @return the $contentTitle
	 */
	public function getContentTitle() {
		return $this->contentTitle;
	}

	/**
	 * @param string $contentTitle
	 */
	public function setContentTitle($contentTitle) {
		$this->contentTitle = $contentTitle;
	}

	/**
	 * @return the $contentShortdesc
	 */
	public function getContentShortdesc() {
		return $this->contentShortdesc;
	}

	/**
	 * @param string $contentShortdesc
	 */
	public function setContentShortdesc($contentShortdesc) {
		$this->contentShortdesc = $contentShortdesc;
	}

	/**
	 * @return the $contentBody
	 */
	public function getContentBody() {
		return $this->contentBody;
	}

	/**
	 * @param string $contentBody
	 */
	public function setContentBody($contentBody) {
		$this->contentBody = $contentBody;
	}

	/**
	 * @return the $contentCreated
	 */
	public function getContentCreated() {
		return $this->contentCreated;
	}

	/**
	 * @param number $contentCreated
	 */
	public function setContentCreated($contentCreated) {
		$this->contentCreated = $contentCreated;
	}

	/**
	 * @return the $contentStatus
	 */
	public function getContentStatus() {
		return $this->contentStatus;
	}

	/**
	 * @param string $contentStatus
	 */
	public function setContentStatus($contentStatus) {
		$this->contentStatus = $contentStatus;
	}

	/**
	 * @return the $contentMetatitle
	 */
	public function getContentMetatitle() {
		return $this->contentMetatitle;
	}

	/**
	 * @param string $contentMetatitle
	 */
	public function setContentMetatitle($contentMetatitle) {
		$this->contentMetatitle = $contentMetatitle;
	}

	/**
	 * @return the $contentMetakeywords
	 */
	public function getContentMetakeywords() {
		return $this->contentMetakeywords;
	}

	/**
	 * @param string $contentMetakeywords
	 */
	public function setContentMetakeywords($contentMetakeywords) {
		$this->contentMetakeywords = $contentMetakeywords;
	}

	/**
	 * @return the $contentMetadescription
	 */
	public function getContentMetadescription() {
		return $this->contentMetadescription;
	}

	/**
	 * @param string $contentMetadescription
	 */
	public function setContentMetadescription($contentMetadescription) {
		$this->contentMetadescription = $contentMetadescription;
	}

	/**
	 * @return the $contentUserId
	 */
	public function getContentUserId() {
		return $this->contentUserId;
	}

	/**
	 * @param number $contentUserId
	 */
	public function setContentUserId($contentUserId) {
		$this->contentUserId = $contentUserId;
	}

	/**
	 * @return the $contentType
	 */
	public function getContentType() {
		return $this->contentType;
	}

	/**
	 * @param string $contentType
	 */
	public function setContentType($contentType) {
		$this->contentType = $contentType;
	}	
}