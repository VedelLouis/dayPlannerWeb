<?php

namespace Entities;

class Event {

    private $idEvent;
    private $name;
    private $dateStart;
    private $dateEnd;
    private $color;
    private $idUser;

    public function __construct($idEvent, $name, $dateStart, $dateEnd, $color, $idUser)
    {
        $this->idEvent = $idEvent;
        $this->name = $name;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->color = $color;
        $this->idUser = $idUser;
    }

    public function getIdEvent()
    {
        return $this->idEvent;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDateStart()
    {
        return $this->dateStart;
    }

    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getColor()
    {
        return $this->color;
    }

}