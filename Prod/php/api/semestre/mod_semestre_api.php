<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "/modele_semestre_api.php";

    class ModSemestreAPI
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? strtolower(htmlspecialchars($_GET['action'])) : Response::send_error(HTTP_BAD_REQUEST, 'Paramètre action est absent');

            $modele = new ModeleSemestreAPI();

            switch($action) {
                case 'liste_semestres':
                    $modele->getListeSemestre();
                break; 
            }
        }
    }