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
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
        $mdpActuel = filter_input(INPUT_POST, 'mdpActuel', FILTER_SANITIZE_STRING);
        $nouveauMdp = filter_input(INPUT_POST, 'nouveauMdp', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);

        require_once "Repositories/UserRepository.php";

        $result = UserRepository::updateUser($login, $mdpActuel, $nouveauMdp, $firstname, $lastname);

        if ($result == 0) {
            $erreur_modification = "Mot de passe incorrect";
            include "Views/MyAccountView.php";
            exit;
        } else {
            $modification = "Compte modifié avec succès";
            include "Views/MyAccountView.php";
            header("Location: index.php?controller=account&action=account");
        }
    }

    private function supprimerMonCompte()
    {
        $confirmDeletePassword = filter_input(INPUT_POST, 'confirmDeletePassword', FILTER_SANITIZE_STRING);

        require_once "Repositories/UserRepository.php";

        $result = UserRepository::deleteUser($confirmDeletePassword);

        if ($result == 0) {
            $erreur_suppression = "Mot de passe incorrect";
            include "Views/MyAccountView.php";
            exit;
        } else {
            header("Location: index.php?controller=connexion&action=index");
            exit;
        }
    }

}