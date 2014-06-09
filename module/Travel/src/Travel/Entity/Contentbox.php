<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contentboxes
 *
 * @ORM\Table(name="contentboxes")
 * @ORM\Entity
 */
class Contentbox
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ctbox_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ctboxId;

    /**
     * @var string
     *
     * @ORM\Column(name="ctbox_title", type="string", length=255, nullable=true)
     */
    private $ctboxTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ctbox_desc", type="text", nullable=true)
     */
    private $ctboxDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="ctbox_link", type="string", length=255, nullable=true)
     */
    private $ctboxLink;

    /**
     * @var string
     *
     * @ORM\Column(name="ctbox_anchor", type="string", length=255, nullable=true)
     */
    private $ctboxAnchor;

    /**
     * @var string
     *
     * @ORM\Column(name="ctbox_image", type="string", length=255, nullable=true)
     */
    private $ctboxImage;

    /**
     * @var integer
     *
     * @ORM\Column(name="ctbox_order", type="integer", nullable=true)
     */
    private $ctboxOrder;

	/**
	 * @return the $ctboxId
	 */
	public function getCtboxId() {
		return $this->ctboxId;
	}

	/**
	 * @param number $ctboxId
	 */
	public function setCtboxId($ctboxId) {
		$this->ctboxId = $ctboxId;
	}

	/**
	 * @return the $ctboxTitle
	 */
	public function getCtboxTitle() {
		return $this->ctboxTitle;
	}

	/**
	 * @param string $ctboxTitle
	 */
	public function setCtboxTitle($ctboxTitle) {
		$this->ctboxTitle = $ctboxTitle;
	}

	/**
	 * @return the $ctboxDesc
	 */
	public function getCtboxDesc() {
		return $this->ctboxDesc;
	}

	/**
	 * @param string $ctboxDesc
	 */
	public function setCtboxDesc($ctboxDesc) {
		$this->ctboxDesc = $ctboxDesc;
	}

	/**
	 * @return the $ctboxLink
	 */
	public function getCtboxLink() {
		return $this->ctboxLink;
	}

	/**
	 * @param string $ctboxLink
	 */
	public function setCtboxLink($ctboxLink) {
		$this->ctboxLink = $ctboxLink;
	}

	/**
	 * @return the $ctboxAnchor
	 */
	public function getCtboxAnchor() {
		return $this->ctboxAnchor;
	}

	/**
	 * @param string $ctboxAnchor
	 */
	public function setCtboxAnchor($ctboxAnchor) {
		$this->ctboxAnchor = $ctboxAnchor;
	}

	/**
	 * @return the $ctboxImage
	 */
	public function getCtboxImage() {
		return $this->ctboxImage;
	}

	/**
	 * @param string $ctboxImage
	 */
	public function setCtboxImage($ctboxImage) {
		$this->ctboxImage = $ctboxImage;
	}

	/**
	 * @return the $ctboxOrder
	 */
	public function getCtboxOrder() {
		return $this->ctboxOrder;
	}

	/**
	 * @param number $ctboxOrder
	 */
	public function setCtboxOrder($ctboxOrder) {
		$this->ctboxOrder = $ctboxOrder;
	}	
}