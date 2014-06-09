<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blocks
 *
 * @ORM\Table(name="blocks")
 * @ORM\Entity
 */
class Block
{
    /**
     * @var integer
     *
     * @ORM\Column(name="block_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $blockId;

    /**
     * @var string
     *
     * @ORM\Column(name="block_module", type="string", length=255, nullable=false)
     */
    private $blockModule;

    /**
     * @var integer
     *
     * @ORM\Column(name="block_weight", type="integer", nullable=true)
     */
    private $blockWeight;

    /**
     * @var string
     *
     * @ORM\Column(name="block_area", type="string", length=255, nullable=false)
     */
    private $blockArea;

    /**
     * @var string
     *
     * @ORM\Column(name="block_selector", type="string", length=255, nullable=false)
     */
    private $blockSelector;

    /**
     * @var boolean
     *
     * @ORM\Column(name="block_custom", type="boolean", nullable=true)
     */
    private $blockCustom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="block_status", type="boolean", nullable=true)
     */
    private $blockStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="block_title", type="string", length=255, nullable=true)
     */
    private $blockTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="block_pages", type="text", nullable=true)
     */
    private $blockPages;

    /**
     * @var string
     *
     * @ORM\Column(name="block_access_mode", type="string", length=30, nullable=true)
     */
    private $blockAccessMode;

    /**
     * @var string
     *
     * @ORM\Column(name="block_access_roles", type="string", length=255, nullable=true)
     */
    private $blockAccessRoles;

    /**
     * @var string
     *
     * @ORM\Column(name="block_description", type="string", length=255, nullable=true)
     */
    private $blockDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="block_content", type="text", nullable=true)
     */
    private $blockContent;

    /**
     * @var string
     *
     * @ORM\Column(name="block_settings", type="text", nullable=true)
     */
    private $blockSettings;

	/**
	 * @return the $blockId
	 */
	public function getBlockId() {
		return $this->blockId;
	}

	/**
	 * @param number $blockId
	 */
	public function setBlockId($blockId) {
		$this->blockId = $blockId;
	}

	/**
	 * @return the $blockModule
	 */
	public function getBlockModule() {
		return $this->blockModule;
	}

	/**
	 * @param string $blockModule
	 */
	public function setBlockModule($blockModule) {
		$this->blockModule = $blockModule;
	}

	/**
	 * @return the $blockWeight
	 */
	public function getBlockWeight() {
		return $this->blockWeight;
	}

	/**
	 * @param number $blockWeight
	 */
	public function setBlockWeight($blockWeight) {
		$this->blockWeight = $blockWeight;
	}

	/**
	 * @return the $blockArea
	 */
	public function getBlockArea() {
		return $this->blockArea;
	}

	/**
	 * @param string $blockArea
	 */
	public function setBlockArea($blockArea) {
		$this->blockArea = $blockArea;
	}

	/**
	 * @return the $blockSelector
	 */
	public function getBlockSelector() {
		return $this->blockSelector;
	}

	/**
	 * @param string $blockSelector
	 */
	public function setBlockSelector($blockSelector) {
		$this->blockSelector = $blockSelector;
	}

	/**
	 * @return the $blockCustom
	 */
	public function getBlockCustom() {
		return $this->blockCustom;
	}

	/**
	 * @param boolean $blockCustom
	 */
	public function setBlockCustom($blockCustom) {
		$this->blockCustom = $blockCustom;
	}

	/**
	 * @return the $blockStatus
	 */
	public function getBlockStatus() {
		return $this->blockStatus;
	}

	/**
	 * @param boolean $blockStatus
	 */
	public function setBlockStatus($blockStatus) {
		$this->blockStatus = $blockStatus;
	}

	/**
	 * @return the $blockTitle
	 */
	public function getBlockTitle() {
		return $this->blockTitle;
	}

	/**
	 * @param string $blockTitle
	 */
	public function setBlockTitle($blockTitle) {
		$this->blockTitle = $blockTitle;
	}

	/**
	 * @return the $blockPages
	 */
	public function getBlockPages() {
		return $this->blockPages;
	}

	/**
	 * @param string $blockPages
	 */
	public function setBlockPages($blockPages) {
		$this->blockPages = $blockPages;
	}

	/**
	 * @return the $blockAccessMode
	 */
	public function getBlockAccessMode() {
		return $this->blockAccessMode;
	}

	/**
	 * @param string $blockAccessMode
	 */
	public function setBlockAccessMode($blockAccessMode) {
		$this->blockAccessMode = $blockAccessMode;
	}

	/**
	 * @return the $blockAccessRoles
	 */
	public function getBlockAccessRoles() {
		return $this->blockAccessRoles;
	}

	/**
	 * @param string $blockAccessRoles
	 */
	public function setBlockAccessRoles($blockAccessRoles) {
		$this->blockAccessRoles = $blockAccessRoles;
	}

	/**
	 * @return the $blockDescription
	 */
	public function getBlockDescription() {
		return $this->blockDescription;
	}

	/**
	 * @param string $blockDescription
	 */
	public function setBlockDescription($blockDescription) {
		$this->blockDescription = $blockDescription;
	}

	/**
	 * @return the $blockContent
	 */
	public function getBlockContent() {
		return $this->blockContent;
	}

	/**
	 * @param string $blockContent
	 */
	public function setBlockContent($blockContent) {
		$this->blockContent = $blockContent;
	}

	/**
	 * @return the $blockSettings
	 */
	public function getBlockSettings() {
		return $this->blockSettings;
	}

	/**
	 * @param string $blockSettings
	 */
	public function setBlockSettings($blockSettings) {
		$this->blockSettings = $blockSettings;
	}	
}