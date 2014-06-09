<?php
namespace Travel\Model;

class TravelEntity
{

    public $id;

    public $name;

    public $state;

    public $traveltype = null;

    /**
     *
     * @return the $id
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     *
     * @return the $name
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     *
     * @return the $state
     */
    public function getState ()
    {
        return $this->state;
    }

    /**
     *
     * @return the $traveltype
     */
    public function getTraveltype ()
    {
        return $this->traveltype;
    }

    /**
     *
     * @param field_type $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param field_type $name
     */
    public function setName ($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @param field_type $state
     */
    public function setState ($state)
    {
        $this->state = $state;
    }

    /**
     *
     * @param Traveltype $traveltype
     */
    public function setTraveltype ($traveltype)
    {
        $this->traveltype = $traveltype;
    }

    public function __construct (TravelType $traveltype = NULL)
    {
        $this->traveltype = $traveltype;
    }

    public function getType ()
    {
        return $this->traveltype;
    }
}