<?php

namespace Controllers;

use Repositories\UserRepository;

class AccountController
{
    public function __construct($action)
    {
        switch ($action) {
            case "index":
                $this->afficherCreateView();
                break;
            case "create":
                $this->creerUser();
                break;
            case "account":
                $this->voirMonCompte();
                break;
            case "delete":
                break;
        }
    }

    private function afficherCreateView()
    {
        include "Views/CreerAccountView.php";
    }

    private function creerUser()
    {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);

        require_once "Repositories/UserRepository.php";

        UserRepository::createUser($login, $password, $firstname, $lastname);

        header("Location: index.php?controller=connexion&action=index");

    }

    private function voirMonCompte()
    {
        include "Views/MyAccountView.php";
    }

}