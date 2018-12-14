<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/classes/module.php";
    require_once __DIR__ . "/../../../common/Database.php";

    class ModeleModule extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }


        public function liste_modules(){
            return Module::listeModules();
        }
    }
