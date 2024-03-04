<?php

namespace Entities;
class User {
    private $idUser;
    private $login;
    private $password;
    private $firstName;
    private $lastName;
    private $session;

    // Constructeur
    public function __construct($idUser, $login, $password, $firstName, $lastName, $session) {
        $this->idUser = $idUser;
        $this->login = $login;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->session = $session;
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

    public function getSession() {
        return $this->session;
    }
}

?>
