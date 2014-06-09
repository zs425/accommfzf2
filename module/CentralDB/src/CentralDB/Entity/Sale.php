<?php

namespace CentralDB\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sales
 *
 * @ORM\Table(name="sales")
 * @ORM\Entity
 */
class Sale
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sales_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $salesId;

    /**
     * @var string
     *
     * @ORM\Column(name="customername", type="string", length=85, precision=0, scale=0, nullable=true, unique=false)
     */
    private $customername;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=155, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="subscribe_status", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $subscribeStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="property", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $property;

    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     */
    private $provider;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transactiondate", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $transactiondate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date_start", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $reservationDateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date_end", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $reservationDateEnd;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=80, precision=0, scale=0, nullable=true, unique=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=80, precision=0, scale=0, nullable=true, unique=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=50, precision=0, scale=0, nullable=true, unique=false)
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="property_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $propertyId;

    /**
     * @var float
     *
     * @ORM\Column(name="commission", type="decimal", precision=0, scale=0, nullable=true, unique=false)
     */
    private $commission;


    /**
     * Get salesId
     *
     * @return integer 
     */
    public function getSalesId()
    {
        return $this->salesId;
    }

    /**
     * Set customername
     *
     * @param string $customername
     * @return Sales
     */
    public function setCustomername($customername)
    {
        $this->customername = $customername;
    
        return $this;
    }

    /**
     * Get customername
     *
     * @return string 
     */
    public function getCustomername()
    {
        return $this->customername;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Sales
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Sales
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Sales
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set subscribeStatus
     *
     * @param string $subscribeStatus
     * @return Sales
     */
    public function setSubscribeStatus($subscribeStatus)
    {
        $this->subscribeStatus = $subscribeStatus;
    
        return $this;
    }

    /**
     * Get subscribeStatus
     *
     * @return string 
     */
    public function getSubscribeStatus()
    {
        return $this->subscribeStatus;
    }

    /**
     * Set property
     *
     * @param string $property
     * @return Sales
     */
    public function setProperty($property)
    {
        $this->property = $property;
    
        return $this;
    }

    /**
     * Get property
     *
     * @return string 
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set provider
     *
     * @param string $provider
     * @return Sales
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    
        return $this;
    }

    /**
     * Get provider
     *
     * @return string 
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set transactiondate
     *
     * @param \DateTime $transactiondate
     * @return Sales
     */
    public function setTransactiondate($transactiondate)
    {
        $this->transactiondate = $transactiondate;
    
        return $this;
    }

    /**
     * Get transactiondate
     *
     * @return \DateTime 
     */
    public function getTransactiondate()
    {
        return $this->transactiondate;
    }

    /**
     * Set reservationDateStart
     *
     * @param \DateTime $reservationDateStart
     * @return Sales
     */
    public function setReservationDateStart($reservationDateStart)
    {
        $this->reservationDateStart = $reservationDateStart;
    
        return $this;
    }

    /**
     * Get reservationDateStart
     *
     * @return \DateTime 
     */
    public function getReservationDateStart()
    {
        return $this->reservationDateStart;
    }

    /**
     * Set reservationDateEnd
     *
     * @param \DateTime $reservationDateEnd
     * @return Sales
     */
    public function setReservationDateEnd($reservationDateEnd)
    {
        $this->reservationDateEnd = $reservationDateEnd;
    
        return $this;
    }

    /**
     * Get reservationDateEnd
     *
     * @return \DateTime 
     */
    public function getReservationDateEnd()
    {
        return $this->reservationDateEnd;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Sales
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Sales
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Sales
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Sales
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set propertyId
     *
     * @param integer $propertyId
     * @return Sales
     */
    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;
    
        return $this;
    }

    /**
     * Get propertyId
     *
     * @return integer 
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Set commission
     *
     * @param float $commission
     * @return Sales
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    
        return $this;
    }

    /**
     * Get commission
     *
     * @return float 
     */
    public function getCommission()
    {
        return $this->commission;
    }
}
