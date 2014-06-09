<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Countries
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity
 */
class Country
{
    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=2, precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country_name", type="string", length=150, precision=0, scale=0, nullable=false, unique=false)
     */
    private $countryName;

    /**
     * @var float
     *
     * @ORM\Column(name="country_lat", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $countryLat;

    /**
     * @var float
     *
     * @ORM\Column(name="country_lon", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $countryLon;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code_iso", type="string", length=3, precision=0, scale=0, nullable=false, unique=false)
     */
    private $countryCodeIso;


    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set countryName
     *
     * @param string $countryName
     * @return Countries
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    
        return $this;
    }

    /**
     * Get countryName
     *
     * @return string 
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set countryLat
     *
     * @param float $countryLat
     * @return Countries
     */
    public function setCountryLat($countryLat)
    {
        $this->countryLat = $countryLat;
    
        return $this;
    }

    /**
     * Get countryLat
     *
     * @return float 
     */
    public function getCountryLat()
    {
        return $this->countryLat;
    }

    /**
     * Set countryLon
     *
     * @param float $countryLon
     * @return Countries
     */
    public function setCountryLon($countryLon)
    {
        $this->countryLon = $countryLon;
    
        return $this;
    }

    /**
     * Get countryLon
     *
     * @return float 
     */
    public function getCountryLon()
    {
        return $this->countryLon;
    }

    /**
     * Set countryCodeIso
     *
     * @param string $countryCodeIso
     * @return Countries
     */
    public function setCountryCodeIso($countryCodeIso)
    {
        $this->countryCodeIso = $countryCodeIso;
    
        return $this;
    }

    /**
     * Get countryCodeIso
     *
     * @return string 
     */
    public function getCountryCodeIso()
    {
        return $this->countryCodeIso;
    }
}
