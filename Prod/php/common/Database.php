<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . '/Date.php';
    class Database
    {
        protected static $db;

        public function initConnexion()
        {
            try {
                self::$db = new PDO('mysql:host=localhost;dbname=dutinfopw201822', "root", "najymahe");
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

        public static function getDBYear()
        {
            $stmt = self::$db->prepare("select max(annee) from annee");
            
            $stmt->execute();
 
            $result = $stmt->fetch();
 
            $current_year = Date::getYearBeforeMonth(8);

            if (false === $result || $current_year != $result[0]) {
                $stmtInsert = self::$db->prepare("insert into annee values (:annee)");
                
                $stmtInsert->bindValue(":annee", $current_year);
                
                $stmtInsert->execute();

                $result = array($current_year);
            }

            return $result[0];
        }
    }
