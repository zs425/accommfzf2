<?php

namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SlideshowImages
 *
 * @ORM\Table(name="slideshow_images")
 * @ORM\Entity
 */
class SlideshowImages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="image_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $imageId;

    /**
     * @var integer
     *
     * @ORM\Column(name="slideshow_id", type="integer", nullable=false)
     */
    private $slideshowId;

    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=400, nullable=false)
     */
    private $imagePath;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb_path", type="string", length=400, nullable=false)
     */
    private $thumbPath;

    /**
     * @var string
     *
     * @ORM\Column(name="image_desc", type="string", length=200, nullable=false)
     */
    private $imageDesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_index", type="integer", nullable=false)
     */
    private $orderIndex = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $createdDate = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=false)
     */
    private $modifiedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=30, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="discription", type="string", length=500, nullable=true)
     */
    private $discription;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=100, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="linktext", type="string", length=500, nullable=true)
     */
    private $linktext;



    /**
     * Get imageId
     *
     * @return integer 
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Set slideshowId
     *
     * @param integer $slideshowId
     * @return SlideshowImages
     */
    public function setSlideshowId($slideshowId)
    {
        $this->slideshowId = $slideshowId;

        return $this;
    }

    /**
     * Get slideshowId
     *
     * @return integer 
     */
    public function getSlideshowId()
    {
        return $this->slideshowId;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     * @return SlideshowImages
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string 
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set thumbPath
     *
     * @param string $thumbPath
     * @return SlideshowImages
     */
    public function setThumbPath($thumbPath)
    {
        $this->thumbPath = $thumbPath;

        return $this;
    }

    /**
     * Get thumbPath
     *
     * @return string 
     */
    public function getThumbPath()
    {
        return $this->thumbPath;
    }

    /**
     * Set imageDesc
     *
     * @param string $imageDesc
     * @return SlideshowImages
     */
    public function setImageDesc($imageDesc)
    {
        $this->imageDesc = $imageDesc;

        return $this;
    }

    /**
     * Get imageDesc
     *
     * @return string 
     */
    public function getImageDesc()
    {
        return $this->imageDesc;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return SlideshowImages
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return SlideshowImages
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set orderIndex
     *
     * @param integer $orderIndex
     * @return SlideshowImages
     */
    public function setOrderIndex($orderIndex)
    {
        $this->orderIndex = $orderIndex;

        return $this;
    }

    /**
     * Get orderIndex
     *
     * @return integer 
     */
    public function getOrderIndex()
    {
        return $this->orderIndex;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return SlideshowImages
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return SlideshowImages
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return SlideshowImages
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set discription
     *
     * @param string $discription
     * @return SlideshowImages
     */
    public function setDiscription($discription)
    {
        $this->discription = $discription;

        return $this;
    }

    /**
     * Get discription
     *
     * @return string 
     */
    public function getDiscription()
    {
        return $this->discription;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return SlideshowImages
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set linktext
     *
     * @param string $linktext
     * @return SlideshowImages
     */
    public function setLinktext($linktext)
    {
        $this->linktext = $linktext;

        return $this;
    }

    /**
     * Get linktext
     *
     * @return string 
     */
    public function getLinktext()
    {
        return $this->linktext;
    }
}
