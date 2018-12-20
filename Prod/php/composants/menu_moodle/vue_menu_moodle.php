<?php

    if (!defined('CONST_INCLUDE')) {
        die("Accès interdit");
    }

    class VueMenuMoodle
    {
        public function afficherMenu()
        {
            include_once __DIR__ . "/html/menu_moodle.html";
        }
    }
