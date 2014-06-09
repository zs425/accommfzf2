<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slideshows
 *
 * @ORM\Table(name="slideshows")
 * @ORM\Entity
 */
class Slideshow
{
    /**
     * @var integer
     *
     * @ORM\Column(name="slideshow_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $slideshowId;

    /**
     * @var string
     *
     * @ORM\Column(name="slideshow_name", type="string", length=255, nullable=false)
     */
    private $slideshowName;

    /**
     * @var string
     *
     * @ORM\Column(name="slideshow_script", type="string", length=255, nullable=false)
     */
    private $slideshowScript;

    /**
     * @var string
     *
     * @ORM\Column(name="slideshow_effect", type="string", length=255, nullable=false)
     */
    private $slideshowEffect;

    /**
     * @var integer
     *
     * @ORM\Column(name="slideshow_width", type="integer", nullable=true)
     */
    private $slideshowWidth;

    /**
     * @var integer
     *
     * @ORM\Column(name="slideshow_height", type="integer", nullable=true)
     */
    private $slideshowHeight;

    /**
     * @var integer
     *
     * @ORM\Column(name="slideshow_delay", type="integer", nullable=true)
     */
    private $slideshowDelay;

    /**
     * @var boolean
     *
     * @ORM\Column(name="slideshow_navigation", type="boolean", nullable=true)
     */
    private $slideshowNavigation;

    /**
     * @var string
     *
     * @ORM\Column(name="slideshow_images", type="text", nullable=true)
     */
    private $slideshowImages;
	/**
     * @var string
     *
     * @ORM\Column(name="slideshow_slug", type="string", length=50, nullable=true)
     */
    private $slideshowSlug;
	/**
     * @var string
     *
     * @ORM\Column(name="slideshow_uri", type="string", length=50, nullable=true)
     */
    private $slideshowUri;
    
	/**
	 * @return the $slideshowId
	 */
	public function getSlideshowId() {
		return $this->slideshowId;
	}

	/**
	 * @param number $slideshowId
	 */
	public function setSlideshowId($slideshowId) {
		$this->slideshowId = $slideshowId;
	}

	/**
	 * @return the $slideshowName
	 */
	public function getSlideshowName() {
		return $this->slideshowName;
	}

	/**
	 * @param string $slideshowName
	 */
	public function setSlideshowName($slideshowName) {
		$this->slideshowName = $slideshowName;
	}

	/**
	 * @return the $slideshowScript
	 */
	public function getSlideshowScript() {
		return $this->slideshowScript;
	}

	/**
	 * @param string $slideshowScript
	 */
	public function setSlideshowScript($slideshowScript) {
		$this->slideshowScript = $slideshowScript;
	}

	/**
	 * @return the $slideshowEffect
	 */
	public function getSlideshowEffect() {
		return $this->slideshowEffect;
	}

	/**
	 * @param string $slideshowEffect
	 */
	public function setSlideshowEffect($slideshowEffect) {
		$this->slideshowEffect = $slideshowEffect;
	}

	/**
	 * @return the $slideshowWidth
	 */
	public function getSlideshowWidth() {
		return $this->slideshowWidth;
	}

	/**
	 * @param number $slideshowWidth
	 */
	public function setSlideshowWidth($slideshowWidth) {
		$this->slideshowWidth = $slideshowWidth;
	}

	/**
	 * @return the $slideshowHeight
	 */
	public function getSlideshowHeight() {
		return $this->slideshowHeight;
	}

	/**
	 * @param number $slideshowHeight
	 */
	public function setSlideshowHeight($slideshowHeight) {
		$this->slideshowHeight = $slideshowHeight;
	}

	/**
	 * @return the $slideshowDelay
	 */
	public function getSlideshowDelay() {
		return $this->slideshowDelay;
	}

	/**
	 * @param number $slideshowDelay
	 */
	public function setSlideshowDelay($slideshowDelay) {
		$this->slideshowDelay = $slideshowDelay;
	}

	/**
	 * @return the $slideshowNavigation
	 */
	public function getSlideshowNavigation() {
		return $this->slideshowNavigation;
	}

	/**
	 * @param boolean $slideshowNavigation
	 */
	public function setSlideshowNavigation($slideshowNavigation) {
		$this->slideshowNavigation = $slideshowNavigation;
	}

	/**
	 * @return the $slideshowImages
	 */
	public function getSlideshowImages() {
		return $this->slideshowImages;
	}

	/**
	 * @param string $slideshowImages
	 */
	public function setSlideshowImages($slideshowImages) {
		$this->slideshowImages = $slideshowImages;
	}

	/**
     * Set slideshow_slug
     *
     * @param string $slideshowSlug
     * @return Slideshow
     */
    public function setSlideshowSlug($slideshowSlug)
    {
        $this->slideshowSlug = $slideshowSlug;

        return $this;
    }

    /**
     * Get slideshowSlug
     *
     * @return string 
     */
    public function getSlideshowSlug()
    {
        return $this->slideshowSlug;
    }
	
	/**
     * Set slideshow_uri
     *
     * @param string $slideshowUri
     * @return Slideshow
     */
    public function setSlideshowUri($slideshowUri)
    {
        $this->slideshowUri = $slideshowUri;

        return $this;
    }

    /**
     * Get slideshowUri
     *
     * @return string 
     */
    public function getSlideshowUri()
    {
        return $this->slideshowUri;
    }
}
