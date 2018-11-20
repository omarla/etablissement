<?php
    require_once __DIR__ . "/../verify.php";
    class Database
    {
        protected static $db;

        public function initConnexion()
        {
            try {
                self::$db = new PDO('mysql:host=localhost;dbname=dutinfopw201622;charset=utf8', "root", "najymahe");
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                header("Location: index.php?module=error&title=Problème Serveur&message=".DATABASE_ERROR_MESSAGE);
            }
        }

        public static function getDB()
        {
            return self::$db;
        }
        

        public static function getLastInsertId()
        {
            $stmt = self::$db->prepare("select LAST_INSERT_ID()");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }

        public static function getAnnee()
        {
            $stmt = self::$db->prepare("select max(annee) from annee");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM)[0];
        }
    }
