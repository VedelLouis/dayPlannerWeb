<?php

namespace Controllers;

use Repositories\UserRepository;

class AccountController
{
    public function __construct($action)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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
            case "edit":
                $this->modifierMonCompte();
                break;
            case "delete":
                $this->supprimerMonCompte();
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

    private function modifierMonCompte()
    {
        $idUser = $_SESSION['idUser'];
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $mdpActuel = filter_input(INPUT_POST, 'mdpActuel', FILTER_SANITIZE_STRING);
        $nouveauMdp = filter_input(INPUT_POST, 'nouveauMdp', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);

        require_once "Repositories/UserRepository.php";

        // Vérifier si le mot de passe actuel correspond à celui de la session
        if ($mdpActuel !== $_SESSION['password']) {
            $_SESSION['error_message'] = "Mot de passe actuel incorrect.";
            header("Location: index.php?controller=account&action=account");
            exit();
        }

        UserRepository::updateUser($idUser, $login, $nouveauMdp, $firstname, $lastname);

        header("Location: index.php?controller=account&action=account");
    }

    private function supprimerMonCompte()
    {
        $idUser = $_SESSION['idUser'];
        UserRepository::deleteUser($idUser);
        header("Location: index.php?controller=connexion&action=index");
    }

}