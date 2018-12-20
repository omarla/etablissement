<?php
    include_once __DIR__ . '/vue_menu_moodle.php';

    if (!defined('CONST_INCLUDE')) {
        die("Accès interdit");
    }

    class ContMenuMoodle
    {
        private $view;

        public function __construct()
        {
            $this->view = new VueMenuMoodle();
        }

        public function afficherMenu()
        {
            $this->view->afficherMenu();
        }
    }
?>

