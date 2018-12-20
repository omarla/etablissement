<?php
    require_once __DIR__ . "/cont_moodle.php";
    require_once __DIR__ . "/../../verify.php";

    class ModMoodle
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? $_GET['action'] : null;
            $cont = new ContMoodle();

            switch($action){
                
                case 'depot_cours':
                    $cont->afficher_depot_cours();
                break;

                case 'ouvrir_depot':
                    $cont->afficher_ouvrir_depot();
                break;

                case 'acces_depot':
                    $cont->afficher_acces_depot(); 
                break;

                default:
                    header('Location: index.php?module=administration&type=etudiant&action=liste_etudiant');
                break;
            }    
        }
    }
    