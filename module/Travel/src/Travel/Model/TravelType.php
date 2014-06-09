<?php
namespace Travel\Model;

class TravelType
{

    protected $type;


    public function __construct ()
    {
        $this->type = 'test';
      //  $this->travelentity = $travelentity;
    }

    /**
     *
     * @return the $type
     */
    public function getType ()
    {
        return $this->type;
    }

    /**
     *
     * @param string $type
     */
    public function setType ($type)
    {
        $this->type = $type;
    }
}