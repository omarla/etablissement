<?php
    require_once "php/verify.php";
    
    class VueConnexion
    {
        public function __construct()
        {
        }

        public function afficherConnexion()
        {
            include_once __DIR__ . "/html/connexion.html";
        }
    }
