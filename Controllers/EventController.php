<?php

namespace Controllers;

use Repositories\EventRepository;

class EventController
{

    public function __construct($action)
    {
        switch ($action) {
            case "create":
                $this->creerEvent();
                break;
            case "update":
                $this->updateEvent();
                break;
            case "delete":
                $this->deleteEvent();
                break;
        }
    }

    private function creerEvent()
    {
        $name = filter_input(INPUT_POST, 'eventName', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'eventDate', FILTER_SANITIZE_STRING);
        $startTime = filter_input(INPUT_POST, 'startTime', FILTER_SANITIZE_STRING);
        $endTime = filter_input(INPUT_POST, 'endTime', FILTER_SANITIZE_STRING);
        $color = filter_input(INPUT_POST, 'eventColor', FILTER_SANITIZE_STRING);

        $dateStart = $date . " " . $startTime;
        $dateEnd = $date . " " . $endTime;

        require_once "Repositories/UserRepository.php";
        EventRepository::createEvent($name, $dateStart, $dateEnd, $color);
        header("Location: https://projects.lvedel.com/dayplanner/index.php?controller=accueil&action=index&dateCalendar=" . $date);
    }

    private function deleteEvent()
    {
        $idEvent = filter_input(INPUT_POST, 'deleteEventId', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'deleteEventDate', FILTER_SANITIZE_STRING);
        require_once "Repositories/UserRepository.php";

        EventRepository::deleteEvent($idEvent);
        header("Location: https://projects.lvedel.com/dayplanner/api/index.php?controller=accueil&action=index&dateCalendar=" . $date);
    }

}