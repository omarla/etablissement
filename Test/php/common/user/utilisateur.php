<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Personnel extends Database
    {
        private const insertQuery = "insert into utilisateur values(
            default,
            :pseudo,
            :mail,
            :nom,
            :prenom,
            :tel,
            :addresse,
            :est_homme,
            :date_naissance,
            :mot_de_passe,
            :cle_recup,
            CURRENT_DATE,
            :filliere_bac,
            :code_pays,
            :code_postal
        )";
        
        private $pseudo;
        private $mail;
        private $nom;
        private $prenom;
        private $tel;
        private $addresse;
        private $est_homme;
        private $date_naissance;
        private $mot_de_passe;
        private $cle_recup;
        private $filliere_bac;
        private $code_pays;
        private $code_postal;

        public function __construct($pseudo, $mail, $nom, $prenom)
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
