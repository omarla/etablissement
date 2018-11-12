<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Utilisateur extends Database
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
        }


        //-------------------------------------FONCTIONS STATIQUES---------------------------------//
        public static function estConnecte()
        {
            return isset($_SESSION['utilisateur']) && $_SESSION['utilisateur'] != null;
        }
    }
