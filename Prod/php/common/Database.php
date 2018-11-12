<?php
    require_once "php/verify.php";
    class Database
    {
        protected static $db;

        public function initConnexion()
        {
            try {
                self::$db = new PDO('mysql:host=localhost;dbname=dutinfopw201622', "root", "najymahe");
            } catch (PDOException $e) {
                header("Location: index.php?module=error&title=Problème Serveur&message=".DATABASE_ERROR_MESSAGE);
            }
        }
    }
