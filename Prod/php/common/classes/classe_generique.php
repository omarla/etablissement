<?php
    require_once __DIR__ . "/../../verify.php";
    require_once __DIR__ . "/../Database.php";
    require_once __DIR__ . "/../exceptions/ElementIntrouvable.php";

    class ClasseGenerique extends Database{
    
        public function __construct($requete, $params, $message = "Élément introuvable"){
            $stmt = self::$db->prepare($requete);
            $exists = false;
            
            if(is_array($params)){
                $stmt->execute($params);
                $exists = $stmt->fetch(PDO::FETCH_NUM) != null;
            }

            if(!$exists){
                throw new ElementIntrouvable($message);
            }
        }
    }

?>