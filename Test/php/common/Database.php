<?php
    require_once "php/verify.php";
    class Database
    {
        protected static $db;

        public function initConnexion()
        {
            try {
                self::$db = new PDO('mysql:host=localhost;dbname=test', "root", "najymahe");
            } catch (PDOException $e) {
                die("Erreur interne");
            }
        }
    }
