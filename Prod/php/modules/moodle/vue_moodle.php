<?php
    require_once __DIR__ . "/../../verify.php";
    require_once __DIR__ . "/../../common/vue_generique.php";

    class VueMoodle extends VueGenerique
    {
        public function __construct()
        {
        }


        public function afficher_depot_cours(){
            require_once __DIR__ . "/html/depotCours.html";
        }

        public function afficher_ouvrir_depot(){
            require_once __DIR__ . "/html/ouvrirDepot.html";
        }

        public function afficher_acces_depot(){
            require_once __DIR__ . "/html/accesDepot.html";
        }


	}