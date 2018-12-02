<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Enseignant extends Database
    {
        private static $insertEnseignantQuery = 'insert into enseignant values(default, ?)';

        private static $deleteEnseignantQuery = "delete from enseignant where id_personnel = :id_personnel";


        public static function ajouterEnseignant($id_personnel)
        {
            $stmt = self::$db->prepare(self::$insertEnseignantQuery);
            
            $stmt->bindValue(1, $id_personnel);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public static function supprimerEnseignant($id_personnel)
        {
            $stmt = self::$db->prepare(self::$deleteEnseignantQuery);
                    
            $stmt->bindValue(':id_personnel', $id_personnel);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit(0);
            }
        }
    }
