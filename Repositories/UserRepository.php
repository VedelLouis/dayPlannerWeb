<?php

namespace Repositories;

use \PDO;
use PdoBD;
use Entities\User;
class UserRepository
{
    public static function getUser($login, $password) {
        $sql = "SELECT * FROM `Users` WHERE login = :login";
        $stmt = PdoBD::getInstance()->getMonPdo()->prepare($sql);
        $stmt->bindValue(":login", $login);
        $stmt->execute();

        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        if (password_verify($password, $userData['password'])) {
            $user = new User(
                $userData['idUser'],
                $userData['login'],
                $userData['password'],
                $userData['firstName'],
                $userData['lastName']
            );

            return $user;
        } else {
            return null;
        }
    }

    public static function getUserById($idUser) {
        $sql = "SELECT * FROM `Users` WHERE idUser = :idUser";
        $stmt = PdoBD::getInstance()->getMonPdo()->prepare($sql);
        $stmt->bindValue(":idUser", $idUser);
        $stmt->execute();

        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        return new User(
            $userData['idUser'],
            $userData['login'],
            $userData['password'],
            $userData['firstName'],
            $userData['lastName']
        );
    }

    public static function createUser($login, $password, $firstname, $lastname) {
        // Hachage avec bcrypt
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO Users (login, password, firstname, lastname) VALUES (:login, :password, :firstname, :lastname)";
        $stmt = PdoBD::getInstance()->getMonPdo()->prepare($sql);

        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);

        $stmt->execute();
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


}
