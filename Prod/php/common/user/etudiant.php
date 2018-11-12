<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Etudiant extends Database
    {
        private const insertQuery = "insert into etudiant values(:numero_etudiant, default, :id_utilisateur)";
        
        private $id_utilisateur;
        private $numero_etudiant;

        public function __construct($numero_etudiant)
        {
            $this->numero_etudiant = $numero_etudiant;
        }

        public function getIdUtilisateur()
        {
            return $this->id_utilisateur;
        }

        public function getNumeroEtudiant()
        {
            return $this->numero_etudiant;
        }

        public function setIdUtilisateur($id_utilisateur)
        {
            $this->id_utilisateur = $id_utilisateur;
        }


        public function insertEtudiant()
        {
            $stmt = self::$db->prepare(self::insertQuery);

            $stmt->bindValue(":id_utilisateur", $this->id_utilisateur);
            $stmt->bindValue(":numero_etudiant", $this->numero_etudiant);
            
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                die("Insertion etudiant a echouée");
            }
        }
    }
