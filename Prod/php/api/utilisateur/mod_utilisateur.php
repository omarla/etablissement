<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "/modele_utilisateur.php";

    class ModUtilisateur
    {
        public function __construct()
        {
            $debut = isset($_GET['start']) ? strtolower($_GET['start']) : Response::send_error(HTTP_BAD_REQUEST, 'Paramètre start est absent');
            $action = isset($_GET['action']) ? strtolower($_GET['action']) : Response::send_error(HTTP_BAD_REQUEST, 'Paramètre action est absent');
            
            $modele = new ModeleUtilisateur($debut);

            switch ($action) {
                case 'pseudo':
                    $modele->getPseudo();
                break;

                case 'ville':
                    $modele->getVille();
                break;

                case 'pays':
                    $modele->getPays();
                break;

                case 'code_postal':
                    $modele->getCodePostal();
                break;


                default:
                    Response::send_error(HTTP_BAD_REQUEST, "Ce type de requête est inconnu");

            }
        }
    }
