<?php
    require_once __DIR__ . "./../../verify.php";
    require_once __DIR__ . "/../../common/Database.php";

    class ModeleMoodle extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }
    }