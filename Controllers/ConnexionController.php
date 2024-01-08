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
                unset($_SESSION);
                session_destroy();
                header('Location: index.php');
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
            header("Location: index.php?controller=accueil&action=index");
        } else {
            // Utilisateur non connecté, définir le message d'erreur dans la variable de session
            session_start();
            $_SESSION['erreur_connexion'] = "Identifiants incorrects";
            header("Location: index.php?controller=connexion&action=index");
        }
    }

}
?>
