<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmadeusCities
 *
 * @ORM\Table(name="amadeus_cities")
 * @ORM\Entity
 */
class AmadeusCities
{
    /**
     * @var integer
     *
     * @ORM\Column(name="city_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cityId;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=45, nullable=true)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city_code", type="string", length=45, nullable=true)
     */
    private $cityCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city_provider", type="string", length=255, nullable=true)
     */
    private $cityProvider;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="destination_id", type="integer", nullable=false)
     */
    private $destinationId;

    /**
     * @var string
     *
     * @ORM\Column(name="city_name", type="string", length=1024, nullable=true)
     */
    private $cityName;



    /**
     * Get cityId
     *
     * @return integer 
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return AmadeusCities
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

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
     * Set cityCode
     *
     * @param string $cityCode
     * @return AmadeusCities
     */
    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    /**
     * Get cityCode
     *
     * @return string 
     */
    public function getCityCode()
    {
        return $this->cityCode;
    }

    /**
     * Set cityProvider
     *
     * @param string $cityProvider
     * @return AmadeusCities
     */
    public function setCityProvider($cityProvider)
    {
        $this->cityProvider = $cityProvider;

        return $this;
    }

    /**
     * Get cityProvider
     *
     * @return string 
     */
    public function getCityProvider()
    {
        return $this->cityProvider;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return AmadeusCities
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set destinationId
     *
     * @param integer $destinationId
     * @return AmadeusCities
     */
    public function setDestinationId($destinationId)
    {
        $this->destinationId = $destinationId;

        return $this;
    }

    /**
     * Get destinationId
     *
     * @return integer 
     */
    public function getDestinationId()
    {
        return $this->destinationId;
    }

    /**
     * Set cityName
     *
     * @param string $cityName
     * @return AmadeusCities
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName
     *
     * @return string 
     */
    public function getCityName()
    {
        return $this->cityName;
    }
}
