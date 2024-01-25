<?php

namespace Controllers;

use Repositories\UserRepository;

class ConnexionController
{
    public function __construct($action)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

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

        $connectedUser = UserRepository::getUser($login, $password);

        if ($connectedUser) {
            $_SESSION['idUser'] = $connectedUser->getIdUser();
            $_SESSION['login'] = $connectedUser->getLogin();
            $_SESSION['firstname'] = $connectedUser->getFirstName();
            $_SESSION['lastname'] = $connectedUser->getLastName();

            header("Location: index.php?controller=accueil&action=index");
        } else {
            $_SESSION['erreur_connexion'] = "Identifiants incorrects";
            header("Location: index.php?controller=connexion&action=index");
        }
    }


    private function deconnecter()
    {
        session_destroy();
        header('Location: index.php');
    }
}
?>