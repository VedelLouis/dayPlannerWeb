<?php

namespace Repositories;

use \PDO;
use PdoBD;
use Entities\User;

class UserRepository
{
    public static function getUser($login, $password)
    {

        $postData = array(
            'login' => $login,
            'password' => $password
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://projects.lvedel.com/dayplanner/api/?controller=connexion&action=connect");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $userData = json_decode($response, true);

        if (isset($userData['success']) && $userData['success'] == 1) {
            setcookie("PHPSESSID", $userData['session'], time() + (365 * 24 * 3600), "/");
            $user = new User(
                $userData['idUser'],
                $userData['login'],
                $userData['password'],
                $userData['firstName'],
                $userData['lastName'],
                $userData['session']
            );
            return $user;
        } else {
            return false;
        }
    }

    public static function getConnectedUser()
    {
        if (isset($_COOKIE['PHPSESSID'])) {
            $session_id = $_COOKIE['PHPSESSID'];
            $url = "https://projects.lvedel.com/dayplanner/api/?controller=account&action=index";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
            $response = curl_exec($ch);

            if ($response === false) {
                die(curl_error($ch));
            }

            curl_close($ch);

            $userData = json_decode($response, true);

            if (isset($userData['success']) && $userData['success'] == 1) {
                return new User(
                    $userData['idUser'],
                    $userData['login'],
                    $userData['password'],
                    $userData['firstName'],
                    $userData['lastName'],
                    $session_id
                );
            }
        }
        return false;
    }

    public static function getUserById($idUser)
    {
        $url = "https://projects.lvedel.com/dayplanner/api/?controller=account&action=user&iduser=" . $idUser;

        $data = file_get_contents($url);
        $userData = json_decode($data, true);

        if ($userData['success'] == 1) {
            $user = new User(
                $userData['idUser'],
                $userData['login'],
                $userData['password'],
                $userData['firstName'],
                $userData['lastName'],
                $userData['session']
            );
            return $user;
        } else {
            return 0;
        }
    }

    public static function createUser($login, $password, $firstname, $lastname)
    {

        $postData = array(
            'login' => $login,
            'password' => $password,
            'firstname' => $firstname,
            'lastname' => $lastname
        );

        $url = "https://projects.lvedel.com/dayplanner/api/?controller=account&action=create";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        if (isset($response['success']) && $response['success'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateUser($login, $mdpActuel, $nouveauMdp, $firstname, $lastname)
    {

        $session_id = $_COOKIE['PHPSESSID'];

        $postData = array(
            'login' => $login,
            'mdpActuel' => $mdpActuel,
            'nouveauMdp' => $nouveauMdp,
            'firstname' => $firstname,
            'lastname' => $lastname
        );

        $url = "https://projects.lvedel.com/dayplanner/api/?controller=account&action=edit";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        if (isset($response['success']) && $response['success'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function deleteUser($confirmDeletePassword) {
        $session_id = $_COOKIE['PHPSESSID'];
        $url = "https://projects.lvedel.com/dayplanner/api/?controller=account&action=delete";

        $postData = array(
            'confirmDeletePassword' => $confirmDeletePassword
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=$session_id");
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        if ($response['success'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function deconnectUser() {
        $session_id = $_COOKIE['PHPSESSID'];
        $url = "https://projects.lvedel.com/dayplanner/api/?controller=connexion&action=deconnect";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
        curl_exec($ch);
        curl_close($ch);
    }

    public static function session()
    {
        $session_id = $_COOKIE['PHPSESSID'];
        $url = "https://projects.lvedel.com/dayplanner/api/?controller=connexion&action=session";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: PHPSESSID=$session_id"));
        $data = curl_exec($ch);

        if ($data === false) {
            die(curl_error($ch));
        }

        curl_close($ch);

        $response = json_decode($data, true);

        if ($response['success'] == 1) {
            return 1;
        } else {
            return 0;
        }
    }

}
