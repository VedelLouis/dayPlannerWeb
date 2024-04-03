<?php

namespace Entities;

class Task {

    private int $idTask;
    private string $title;
    private int $done;
    private int $priority;
    private String $date;
    private int $idUser;

    public function __construct(int $idTask, string $title, int $done, int $priority, string $date, int $idUser)
    {
        $this->idTask = $idTask;
        $this->title = $title;
        $this->done = $done;
        $this->priority = $priority;
        $this->date = $date;
        $this->idUser = $idUser;
    }

    public function getIdTask(): int
    {
        return $this->idTask;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDone(): int
    {
        return $this->done;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getDate(): string
    {
        return $this->date;
    }
    public function getIdUser(): int
    {
        return $this->idUser;
    }

}