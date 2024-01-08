<?php

class PdoBD {

    private static $_serveur = 'mysql:host=mysql-lvedel.alwaysdata.net;dbname=lvedel_bd';
    private static $_user = 'lvedel';
    private static $_mdp = '13112003-Lv@';
    private static $_monPdo;
    private static $_instance = null;

    private function __construct() {
        PdoBD::$_monPdo = new \PDO(PdoBD::$_serveur, PdoBD::$_user, PdoBD::$_mdp, array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ));
    }

    public function _destruct() {
        PdoBD::$_monPdo = null;
    }

    public static function getInstance() {
        if (PdoBD::$_instance == null) {
            PdoBD::$_instance = new PdoBD();
        }
        return PdoBD::$_instance;
    }

    public static function getMonPdo() {
        return self::$_monPdo;
    }

}