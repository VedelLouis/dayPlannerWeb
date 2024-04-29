<?php

namespace Repositories;

use Entities\Task;

class TaskRepository
{

    public static function getTasks($date) {

        $session_id = $_COOKIE['PHPSESSID'];
        $url = "https://dayplanner.tech/api/?controller=task&action=index&date=".$date;

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

        $tasks = [];

        foreach ($response as $task) {
            $taskInfo = new Task(
                $task['idTask'],
                $task['title'],
                $task['done'],
                $task['priority'],
                $task['date'],
                $task['idUser']
            );
            $tasks[] = $taskInfo;
        }

        return $tasks;
    }

    public static function createTask($title, $priority, $date)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $postData = array(
            'title' => $title,
            'priority' => $priority,
            'date' => $date
        );

        $url = "https://dayplanner.tech/api/?controller=task&action=create";

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

        if (isset($response['idTask'])) {
            return $response['idTask'];
        } else {
            return 0;
        }
    }

    public static function updateTask($idTask, $priority, $date)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $postData = array(
            'idTask' => $idTask,
            'priority' => $priority,
            'date' => $date
        );

        $url = "https://dayplanner.tech/api/?controller=task&action=update";

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

    public static function deleteTask($idTask)
    {
        $session_id = $_COOKIE['PHPSESSID'];

        $postData = array(
            'idTask' => $idTask
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

        if (isset($response['success']) && $response['success'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

}