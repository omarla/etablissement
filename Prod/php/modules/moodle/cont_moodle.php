<?php
    require_once __DIR__ . "/../../verify.php";
    require_once __DIR__ . "/vue_moodle.php";
    require_once __DIR__ . "/modele_moodle.php";
    
    class ContMoodle
    {
        private $vue;
        private $modele;

        public function __construct()
        {
            $this->vue = new VueMoodle();
            $this->modele = new ModeleMoodle($this);
        }

        public function afficher_depot_cours(){
            $this->vue->afficher_depot_cours();
        }

        public function afficher_ouvrir_depot(){
            $this->vue->afficher_ouvrir_depot();
        }

        public function afficher_acces_depot(){
            $this->vue->afficher_acces_depot();
        }

    }
    