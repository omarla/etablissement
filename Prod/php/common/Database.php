<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . '/Date.php';
    class Database
    {
        protected static $db;

        public static function initConnexion()
        {
            try {
                self::$db = new PDO('pgsql:host=localhost;dbname=dutinfopw201622', "projet_web", "najymahe");
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                header("Location: index.php?module=error&title=Problème Serveur&message=".DATABASE_ERROR_MESSAGE);
            }
        }

        public static function getDB()
        {
            return self::$db;
        }
        

        public static function getDBYear()
        {
            $stmt = self::$db->prepare("select date_debut, date_fin from periode_semestre where date_fin = (select max(date_fin) from periode_semestre)");
            
            $stmt->execute();
 
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
            $current_interval = Date::getPeriodeCourante();
            
            if (false === $result || $current_interval['debut'] !== $result['date_debut']) {
                $stmtInsert = self::$db->prepare("insert into periode_semestre values (:debut, :fin)");
                
                $stmtInsert->execute($current_interval);
            }

            return $current_interval['debut'] . " => " . $current_interval['fin'];
        }
    }
