<?php

namespace Repositories;

use Entities\Event;

class EventRepository
{

    public static function getEvents($date) {

        $session_id = $_COOKIE['PHPSESSID'];
        $url = "https://dayplanner.tech/api/?controller=event&action=index&date=".$date;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        if (isset($response["success"]) && $response["success"] === 0) {
            return null;
        }

        $events = [];

        foreach ($response as $event) {
            $eventInfo = new Event(
                $event['idEvent'],
                $event['name'],
                $event['dateStart'],
                $event['dateEnd'],
                $event['color'],
                $event['idUser']
            );
            $events[] = $eventInfo;
        }

        return $events;
    }

    public static function createEvent($name, $dateStart, $dateEnd, $color)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $postData = array(
            'name' => $name,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'color' => $color
        );

        $url = "https://dayplanner.tech/api/?controller=event&action=create";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        if (isset($response['success']) && $response['success'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateEvent($idEvent,$name, $dateStart, $dateEnd, $color)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $postData = array(
            'idEvent' => $idEvent,
            'name' => $name,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'color' => $color
        );

        $url = "https://dayplanner.tech/api/?controller=event&action=update";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        if (isset($response['success']) && $response['success'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function deleteEvent($idEvent)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $postData = array(
            'idEvent' => $idEvent
        );

        $url = "https://dayplanner.tech/api/?controller=event&action=delete";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        return $response;
    }

}