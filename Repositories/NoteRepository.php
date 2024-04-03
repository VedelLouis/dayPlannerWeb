<?php

namespace Repositories;

use Entities\Note;

class NoteRepository {
    public static function getNotes($date) {

        $session_id = $_COOKIE['PHPSESSID'];
        $url = "https://dayplanner.tech/api/?controller=note&action=index&date=".$date;

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

        $notes = [];

        foreach ($response as $note) {
            $noteInfo = new Note(
                $note['idNote'],
                $note['text'],
                $note['date'],
                $note['idUser']
            );
            $notes[] = $noteInfo;
        }

        return $notes;
    }

    public static function createNote($text, $date)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $text = filter_var($text, FILTER_SANITIZE_STRING);
        $date = filter_var($date, FILTER_SANITIZE_STRING);

        $postData = array(
            'text' => $text,
            'date' => $date
        );

        $url = "https://dayplanner.tech/api/?controller=note&action=create";

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

    public static function updateNote($text, $date)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $text = filter_var($text, FILTER_SANITIZE_STRING);
        $date = filter_var($date, FILTER_SANITIZE_STRING);

        $postData = array(
            'text' => $text,
            'date' => $date
        );

        $url = "https://dayplanner.tech/api/?controller=note&action=update";

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

}