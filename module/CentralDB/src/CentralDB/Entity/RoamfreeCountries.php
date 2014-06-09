<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoamfreeCountries
 *
 * @ORM\Table(name="roamfree_countries")
 * @ORM\Entity
 */
class RoamfreeCountries
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="roamfreeName", type="string", length=255, nullable=true)
     */
    private $roamfreename;

    /**
     * @var integer
     *
     * @ORM\Column(name="liveHotels", type="integer", nullable=true)
     */
    private $livehotels;

    /**
     * @var integer
     *
     * @ORM\Column(name="roamfreeId", type="integer", nullable=true)
     */
    private $roamfreeid;

    /**
     * @var string
     *
     * @ORM\Column(name="isoCode", type="string", length=10, nullable=true)
     */
    private $isocode;

    /**
     * @var string
     *
     * @ORM\Column(name="added", type="string", length=20, nullable=true)
     */
    private $added;

    /**
     * @var string
     *
     * @ORM\Column(name="modified", type="string", length=20, nullable=true)
     */
    private $modified;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roamfreename
     *
     * @param string $roamfreename
     * @return RoamfreeCountries
     */
    public function setRoamfreename($roamfreename)
    {
        $this->roamfreename = $roamfreename;

        return $this;
    }

    /**
     * Get roamfreename
     *
     * @return string 
     */
    public function getRoamfreename()
    {
        return $this->roamfreename;
    }

    /**
     * Set livehotels
     *
     * @param integer $livehotels
     * @return RoamfreeCountries
     */
    public function setLivehotels($livehotels)
    {
        $this->livehotels = $livehotels;

        return $this;
    }

    /**
     * Get livehotels
     *
     * @return integer 
     */
    public function getLivehotels()
    {
        return $this->livehotels;
    }

    /**
     * Set roamfreeid
     *
     * @param integer $roamfreeid
     * @return RoamfreeCountries
     */
    public function setRoamfreeid($roamfreeid)
    {
        $this->roamfreeid = $roamfreeid;

        return $this;
    }

    /**
     * Get roamfreeid
     *
     * @return integer 
     */
    public function getRoamfreeid()
    {
        return $this->roamfreeid;
    }

    /**
     * Set isocode
     *
     * @param string $isocode
     * @return RoamfreeCountries
     */
    public function setIsocode($isocode)
    {
        $this->isocode = $isocode;

        return $this;
    }

    /**
     * Get isocode
     *
     * @return string 
     */
    public function getIsocode()
    {
        return $this->isocode;
    }

    /**
     * Set added
     *
     * @param string $added
     * @return RoamfreeCountries
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * Get added
     *
     * @return string 
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set modified
     *
     * @param string $modified
     * @return RoamfreeCountries
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return string 
     */
    public function getModified()
    {
        return $this->modified;
    }
	
	public function setByArray($array){
        foreach($array as $key => $value) {
            if(method_exists($this, 'set'.ucfirst($key))) {
                $this->{'set'.ucfirst($key)}($value);    
            }            
        }
        return $this;
    }
    
    public function getByArray() {
        return get_object_vars($this);        
    }
}
