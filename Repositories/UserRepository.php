<?php

namespace Repositories;

use \PDO;
use PdoBD;
use Entities\User;
class UserRepository
{
    public static function getUser($login, $password) {
        // Validation et sanitisation des entrées
        $login = filter_var($login, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $postData = array(
            'login' => $login,
            'password' => $password
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://dayplanner.tech/api/?controller=connexion&action=connect");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if($response === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $userData = json_decode($response, true);

        if (isset($userData['success']) && $userData['success'] == 1) {
            $user = new User(
                $userData['idUser'],
                $userData['login'],
                password_hash($userData['password'], PASSWORD_DEFAULT),
                $userData['firstName'],
                $userData['lastName']
            );
            return $user;
        } else {
            return false;
        }
    }

    public static function getConnectedUser() {
        $url = "https://dayplanner.tech/api/?controller=account&action=index";
        $data = file_get_contents($url);
        $userData = json_decode($data, true);

        if ($userData['success'] == 1) {
            return new User(
                $userData['idUser'],
                $userData['login'],
                $userData['password'],
                $userData['firstName'],
                $userData['lastName']
            );
        } else {
            return 0;
        }
    }


    public static function getUserById($idUser) {
        $url = "https://dayplanner.tech/api/?controller=account&action=user&iduser".$idUser;

        $data = file_get_contents($url);

        $userData = json_decode($data, true);

        if ($userData['success'] == 1) {
            $user = new User(
                $userData['idUser'],
                $userData['login'],
                $userData['password'],
                $userData['firstName'],
                $userData['lastName']
            );
            return $user;
        } else {
            return 0;
        }
    }

    public static function createUser($login, $password, $firstname, $lastname) {
        $url = "https://dayplanner.tech/api/";
        $data = array(
            'controller' => 'account',
            'action' => 'create',
            'login' => $login,
            'password' => $password,
            'firstname' => $firstname,
            'lastname' => $lastname
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result !== false) {
            $userData = json_decode($result, true);
            if (isset($userData['success']) && $userData['success'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function updateUser($idUser, $login, $password, $firstname, $lastname) {
        // Si un nouveau mot de passe a été fourni
        if (!empty($password)) {
            // Hachage avec bcrypt
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        } else {
            // Si aucun nouveau mot de passe n'est fourni, utilise le mot de passe existant
            $userData = self::getUserById($idUser);
            $hashedPassword = $userData->getPassword();
        }

        $sql = "UPDATE Users SET login = :login, password = :password, firstname = :firstname, lastname = :lastname WHERE idUser = :idUser";
        $stmt = PdoBD::getInstance()->getMonPdo()->prepare($sql);

        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function deleteUser($idUser) {
        $sql = "DELETE FROM Users WHERE idUser = :idUser;";
        $stmt = PdoBD::getInstance()->getMonPdo()->prepare($sql);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function deconnectUser() {
        $url = "https://dayplanner.tech/api/?controller=connexion&action=deconnect";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);
        curl_close($ch);
    }


}
