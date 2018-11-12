<?php

    if (!defined('CONST_INCLUDE')) {
        die("Accès interdit");
    }

    class VueMenuInterne
    {
        public function afficherMenu()
        {
            include_once __DIR__ . "/html/menu-interne.html";
        }
    }
