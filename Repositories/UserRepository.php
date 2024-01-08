<?php

namespace Repositories;

use \PDO;
use PdoBD;
use Entities\User;
class UserRepository
{
    public static function getUser($login, $password) {
        $sql = "SELECT * FROM `Users` WHERE login = :login AND password = :password;";
        $stmt = PdoBD::getInstance()->getMonPdo()->prepare($sql);
        $stmt->bindValue(":login", $login);
        $stmt->bindValue(":password", $password);
        $stmt->execute();

        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        $user = new User(
            $userData['idUser'],
            $userData['login'],
            $userData['password'],
            $userData['firstName'],
            $userData['lastName']
        );

        return $user;
    }

    public static function createUser($login, $password, $firstname, $lastname) {
        $sql = "INSERT INTO Users (login, password, firstname, lastname) VALUES (:login, :password, :firstname, :lastname)";
        $stmt = PdoBD::getInstance()->getMonPdo()->prepare($sql);

        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);

        $stmt->execute();
    }



}
