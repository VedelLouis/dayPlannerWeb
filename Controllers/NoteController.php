<?php

namespace Controllers;

use Repositories\NoteRepository;

class NoteController {

    public function __construct($action)
    {
        switch ($action) {
            case "create":
                $this->creerNote();
                break;
            case "update":
                $this->updateNote();
                break;
            case "delete":
                $this->deleteNote();
                break;
        }
    }

    private function creerNote()
    {
        $text = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'dateNote', FILTER_SANITIZE_STRING);

        require_once "Repositories/NoteRepository.php";
        if ($text == "") {
            header("Location: https://projects.lvedel.com/dayplanner/index.php?controller=accueil&action=index&dateCalendar=".$date);
        } else {
            NoteRepository::createNote($text, $date);
            header("Location: https://projects.lvedel.com/dayplanner/api/index.php?controller=accueil&action=index&dateCalendar=".$date);
        }
    }

    private function updateNote()
    {
        $text = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'dateNote', FILTER_SANITIZE_STRING);

        require_once "Repositories/NoteRepository.php";

        NoteRepository::updateNote($text, $date);
        header("Location: https://projects.lvedel.com/dayplanner/api/index.php?controller=accueil&action=index&dateCalendar=".$date);
    }

}