<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Personnel extends Database
    {
        private const insertQuery = "insert into personnel values(default, :id_utilisateur, :formation)";
        
        private $formation;
        private $id_utilisateur;
        private $id_personnel;

        public function __construct($formation)
        {
            $this->formation = $formation;
        }

        public function getFormation()
        {
            return $this->formation;
        }

        public function getIdUtilisateur()
        {
            return $this->id_utilisateur;
        }

        public function getIdPersonnel()
        {
            return $this->id_personnel;
        }

        public function setIdUtilisateur($id_utilisateur)
        {
            $this->id_utilisateur = $id_utilisateur;
        }

        public function setFormation($formation)
        {
            $this->formation = $formation;
        }

        public function insertPersonnel()
        {
            $stmt = self::$db->prepare(self::insertQuery);

            $stmt->bindValue(":id_utilisateur", $this->id_utilisateur);
            $stmt->bindValue(":formation", $this->formation);
            
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                die("Insertion personnel a echouée");
            }
        }
    }
