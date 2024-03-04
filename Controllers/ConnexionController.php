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

        $result = UserRepository::getUser($login, $password);

        if ($result == 0) {
            $erreur_connexion = "Identifiants de connexion incorrects";
            include "Views/ConnexionView.php";
        } else {
            header("Location: index.php?controller=accueil&action=index");
        }
    }


    private function deconnecter()
    {
        UserRepository::deconnectUser();
        setcookie("PHPSESSID", "", time()-3600, "/");
        header('Location: index.php');
    }
}
?>