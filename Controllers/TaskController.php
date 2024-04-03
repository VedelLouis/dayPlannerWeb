<?php

namespace Controllers;

use Repositories\TaskRepository;

class TaskController {

    public function __construct($action)
    {
        switch ($action) {
            case "create":
                $this->creerTask();
                break;
            case "update":
                $this->updateTask();
                break;
            case "delete":
                $this->deleteTask();
                break;
        }
    }

    private function creerTask()
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $priority = filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);

        TaskRepository::createTask($title, $priority, $date);
    }

    private function updateTask()
    {
        $idTask = filter_input(INPUT_POST, 'updateTaskId', FILTER_SANITIZE_STRING);
        $priority = filter_input(INPUT_POST, 'updateTaskPriority', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'updateTaskDate', FILTER_SANITIZE_STRING);

        TaskRepository::updateTask($idTask, $priority, $date);
    }

    private function deleteTask()
    {
        $idTask = filter_input(INPUT_POST, 'deleteTaskId', FILTER_SANITIZE_NUMBER_INT);

        TaskRepository::deleteTask($idTask);
    }

}