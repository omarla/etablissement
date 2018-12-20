<?php
    include_once __DIR__ . '/vue_menu_interne.php';

    if (!defined('CONST_INCLUDE')) {
        die("Accès interdit");
    }

    class ContMenuInterne
    {
        private $modele;
        private $view;

        public function __construct()
        {
            $this->view = new VueMenuInterne();
        }

        public function afficherMenu()
        {
            $this->view->afficherMenu();
        }
    }
?>

