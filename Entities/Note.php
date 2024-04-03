<?php

namespace Entities;

class Note {

    private int $idNote;
    private string $text;
    private String $date;
    private int $idUser;

    public function __construct(int $idNote, string $text, string $date, int $idUser)
    {
        $this->idNote = $idNote;
        $this->text = $text;
        $this->date = $date;
        $this->idUser = $idUser;
    }

    public function getIdNote(): int
    {
        return $this->idNote;
    }

    public function getText(): string
    {
        return $this->text;
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