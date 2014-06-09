<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Countryinfo
 *
 * @ORM\Table(name="countryinfo")
 * @ORM\Entity
 */
class Countryinfo
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
     * @ORM\Column(name="iso_alpha2", type="string", length=2, nullable=true)
     */
    private $isoAlpha2;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_alpha3", type="string", length=3, nullable=true)
     */
    private $isoAlpha3;

    /**
     * @var integer
     *
     * @ORM\Column(name="iso_numeric", type="integer", nullable=true)
     */
    private $isoNumeric;

    /**
     * @var string
     *
     * @ORM\Column(name="fips_code", type="string", length=3, nullable=true)
     */
    private $fipsCode;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="capital", type="string", length=200, nullable=true)
     */
    private $capital;

    /**
     * @var float
     *
     * @ORM\Column(name="areainsqkm", type="float", precision=10, scale=0, nullable=true)
     */
    private $areainsqkm;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer", nullable=true)
     */
    private $population;

    /**
     * @var string
     *
     * @ORM\Column(name="continent", type="string", length=2, nullable=true)
     */
    private $continent;

    /**
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=3, nullable=true)
     */
    private $tld;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3, nullable=true)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="currencyName", type="string", length=20, nullable=true)
     */
    private $currencyname;

    /**
     * @var string
     *
     * @ORM\Column(name="Phone", type="string", length=10, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCodeFormat", type="string", length=100, nullable=true)
     */
    private $postalcodeformat;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCodeRegex", type="string", length=255, nullable=true)
     */
    private $postalcoderegex;

    /**
     * @var integer
     *
     * @ORM\Column(name="geonameId", type="integer", nullable=true)
     */
    private $geonameid;

    /**
     * @var string
     *
     * @ORM\Column(name="languages", type="string", length=200, nullable=true)
     */
    private $languages;

    /**
     * @var string
     *
     * @ORM\Column(name="neighbours", type="string", length=100, nullable=true)
     */
    private $neighbours;

    /**
     * @var integer
     *
     * @ORM\Column(name="roamfreeId", type="integer", nullable=true)
     */
    private $roamfreeid;

    /**
     * @var string
     *
     * @ORM\Column(name="osmId", type="string", length=20, nullable=true)
     */
    private $osmid;

    /**
     * @var string
     *
     * @ORM\Column(name="geonamesId", type="string", length=20, nullable=true)
     */
    private $geonamesid;

    /**
     * @var string
     *
     * @ORM\Column(name="equivalentFipsCode", type="string", length=10, nullable=true)
     */
    private $equivalentfipscode;

    /**
     * @var string
     *
     * @ORM\Column(name="geoplanetId", type="string", length=20, nullable=true)
     */
    private $geoplanetid;



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
     * Set isoAlpha2
     *
     * @param string $isoAlpha2
     * @return Countryinfo
     */
    public function setIsoAlpha2($isoAlpha2)
    {
        $this->isoAlpha2 = $isoAlpha2;

        return $this;
    }

    /**
     * Get isoAlpha2
     *
     * @return string 
     */
    public function getIsoAlpha2()
    {
        return $this->isoAlpha2;
    }

    /**
     * Set isoAlpha3
     *
     * @param string $isoAlpha3
     * @return Countryinfo
     */
    public function setIsoAlpha3($isoAlpha3)
    {
        $this->isoAlpha3 = $isoAlpha3;

        return $this;
    }

    /**
     * Get isoAlpha3
     *
     * @return string 
     */
    public function getIsoAlpha3()
    {
        return $this->isoAlpha3;
    }

    /**
     * Set isoNumeric
     *
     * @param integer $isoNumeric
     * @return Countryinfo
     */
    public function setIsoNumeric($isoNumeric)
    {
        $this->isoNumeric = $isoNumeric;

        return $this;
    }

    /**
     * Get isoNumeric
     *
     * @return integer 
     */
    public function getIsoNumeric()
    {
        return $this->isoNumeric;
    }

    /**
     * Set fipsCode
     *
     * @param string $fipsCode
     * @return Countryinfo
     */
    public function setFipsCode($fipsCode)
    {
        $this->fipsCode = $fipsCode;

        return $this;
    }

    /**
     * Get fipsCode
     *
     * @return string 
     */
    public function getFipsCode()
    {
        return $this->fipsCode;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Countryinfo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set capital
     *
     * @param string $capital
     * @return Countryinfo
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * Get capital
     *
     * @return string 
     */
    public function getCapital()
    {
        return $this->capital;
    }

    /**
     * Set areainsqkm
     *
     * @param float $areainsqkm
     * @return Countryinfo
     */
    public function setAreainsqkm($areainsqkm)
    {
        $this->areainsqkm = $areainsqkm;

        return $this;
    }

    /**
     * Get areainsqkm
     *
     * @return float 
     */
    public function getAreainsqkm()
    {
        return $this->areainsqkm;
    }

    /**
     * Set population
     *
     * @param integer $population
     * @return Countryinfo
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer 
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set continent
     *
     * @param string $continent
     * @return Countryinfo
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * Get continent
     *
     * @return string 
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * Set tld
     *
     * @param string $tld
     * @return Countryinfo
     */
    public function setTld($tld)
    {
        $this->tld = $tld;

        return $this;
    }

    /**
     * Get tld
     *
     * @return string 
     */
    public function getTld()
    {
        return $this->tld;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Countryinfo
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set currencyname
     *
     * @param string $currencyname
     * @return Countryinfo
     */
    public function setCurrencyname($currencyname)
    {
        $this->currencyname = $currencyname;

        return $this;
    }

    /**
     * Get currencyname
     *
     * @return string 
     */
    public function getCurrencyname()
    {
        return $this->currencyname;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Countryinfo
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set postalcodeformat
     *
     * @param string $postalcodeformat
     * @return Countryinfo
     */
    public function setPostalcodeformat($postalcodeformat)
    {
        $this->postalcodeformat = $postalcodeformat;

        return $this;
    }

    /**
     * Get postalcodeformat
     *
     * @return string 
     */
    public function getPostalcodeformat()
    {
        return $this->postalcodeformat;
    }

    /**
     * Set postalcoderegex
     *
     * @param string $postalcoderegex
     * @return Countryinfo
     */
    public function setPostalcoderegex($postalcoderegex)
    {
        $this->postalcoderegex = $postalcoderegex;

        return $this;
    }

    /**
     * Get postalcoderegex
     *
     * @return string 
     */
    public function getPostalcoderegex()
    {
        return $this->postalcoderegex;
    }

    /**
     * Set geonameid
     *
     * @param integer $geonameid
     * @return Countryinfo
     */
    public function setGeonameid($geonameid)
    {
        $this->geonameid = $geonameid;

        return $this;
    }

    /**
     * Get geonameid
     *
     * @return integer 
     */
    public function getGeonameid()
    {
        return $this->geonameid;
    }

    /**
     * Set languages
     *
     * @param string $languages
     * @return Countryinfo
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * Get languages
     *
     * @return string 
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set neighbours
     *
     * @param string $neighbours
     * @return Countryinfo
     */
    public function setNeighbours($neighbours)
    {
        $this->neighbours = $neighbours;

        return $this;
    }

    /**
     * Get neighbours
     *
     * @return string 
     */
    public function getNeighbours()
    {
        return $this->neighbours;
    }

    /**
     * Set roamfreeid
     *
     * @param integer $roamfreeid
     * @return Countryinfo
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
     * Set osmid
     *
     * @param string $osmid
     * @return Countryinfo
     */
    public function setOsmid($osmid)
    {
        $this->osmid = $osmid;

        return $this;
    }

    /**
     * Get osmid
     *
     * @return string 
     */
    public function getOsmid()
    {
        return $this->osmid;
    }

    /**
     * Set geonamesid
     *
     * @param string $geonamesid
     * @return Countryinfo
     */
    public function setGeonamesid($geonamesid)
    {
        $this->geonamesid = $geonamesid;

        return $this;
    }

    /**
     * Get geonamesid
     *
     * @return string 
     */
    public function getGeonamesid()
    {
        return $this->geonamesid;
    }

    /**
     * Set equivalentfipscode
     *
     * @param string $equivalentfipscode
     * @return Countryinfo
     */
    public function setEquivalentfipscode($equivalentfipscode)
    {
        $this->equivalentfipscode = $equivalentfipscode;

        return $this;
    }

    /**
     * Get equivalentfipscode
     *
     * @return string 
     */
    public function getEquivalentfipscode()
    {
        return $this->equivalentfipscode;
    }

    /**
     * Set geoplanetid
     *
     * @param string $geoplanetid
     * @return Countryinfo
     */
    public function setGeoplanetid($geoplanetid)
    {
        $this->geoplanetid = $geoplanetid;

        return $this;
    }

    /**
     * Get geoplanetid
     *
     * @return string 
     */
    public function getGeoplanetid()
    {
        return $this->geoplanetid;
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
