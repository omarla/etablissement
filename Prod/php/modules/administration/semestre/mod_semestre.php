<?php
    require_once __DIR__ . "/cont_semestre.php";
    require_once __DIR__ . "/../../../verify.php";

    class ModSemestre
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? $_GET['action'] : null;
            $cont = new ContSemestre();

            switch ($action) {
                case 'liste_semestre':
                    $cont->afficher_semestres();
                break;
                
                case 'ajouter_semestre':
                    $cont->ajouter_semestre();
                break;

                case 'modifier_semestre':
                    $cont->afficher_semestre();
                break;
            }
        }
    }
