<?php

namespace Entities;
class User {
    private $idUser;
    private $login;
    private $password;
    private $firstName;
    private $lastName;

    // Constructeur
    public function __construct($idUser, $login, $password, $firstName, $lastName) {
        $this->idUser = $idUser;
        $this->login = $login;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    // Getters
    public function getIdUser() {
        return $this->idUser;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }
}

?>
