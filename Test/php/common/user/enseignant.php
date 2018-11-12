<?php
    require_once __DIR__ . "/personnel.php";
    
    class Enseignant extends Personnel
    {
        private const insertEnseignantQuery = "insert into enseignant values(default, :num_personnel)";
        

        public function __construct($formation)
        {
        }

        public function insertEnseignant()
        {
            $stmt = self::$db->prepare(self::insertEnseignantQuery);

            $stmt->bindValue(":num_personnel", parent::getIdPersonnel());
            
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                die("Insertion Enseignant a echouée");
            }
        }
    }
