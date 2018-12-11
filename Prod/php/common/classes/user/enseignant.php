<?php
    require_once __DIR__ . "./../../../verify.php";
    require_once __DIR__ . "/../../Database.php";
    
    class Enseignant extends Database
    {
        private static $insertEnseignantQuery = 'insert into enseignant values(default, ?)';

        private static $deleteEnseignantQuery = "delete from enseignant where id_personnel = :id_personnel";


        public static function ajouterEnseignant($id_personnel)
        {
            $stmt = self::$db->prepare(self::$insertEnseignantQuery);
            
            $stmt->bindValue(1, $id_personnel);

            $stmt->execute();
        }


        public static function supprimerEnseignant($id_personnel)
        {
            $stmt = self::$db->prepare(self::$deleteEnseignantQuery);
                    
            $stmt->bindValue(':id_personnel', $id_personnel);

            $stmt->execute();
        }
    }
