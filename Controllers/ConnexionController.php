<?php

namespace Controllers;

use Repositories\UserRepository;

class ConnexionController
{
    public function __construct($action)
    {

        switch ($action) {
            case "index":
                $this->afficherConnexionView();
                break;
            case "connect":
                $this->traiterConnexion();
                break;
            case "deconnect":
                $this->deconnecter();
                break;
        }
    }

    private function afficherConnexionView()
    {
        include "Views/ConnexionView.php";
    }

    private function traiterConnexion()
    {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        require_once "Repositories/UserRepository.php";

        $user = UserRepository::getUser($login, $password);

        if ($user) {
            header("Location: index.php?controller=accueil&action=index");
        } else {
            header("Location: index.php?controller=connexion&action=index");
        }
    }


    private function deconnecter()
    {
        UserRepository::deconnectUser();
        header('Location: index.php');
    }
}
?>