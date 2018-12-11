<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "/modele_utilisateur.php";

    class ModUtilisateur
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? strtolower($_GET['action']) : Response::send_error(HTTP_BAD_REQUEST, 'Paramètre action est absent');
            
            $modele = new ModeleUtilisateur();

            switch ($action) {
                case 'pseudo_personnel':
                    $modele->getPseudoPersonnels();
                break;

                case 'ville':
                    $modele->getVille();
                break;

                case 'pays':
                    $modele->getPays();
                break;


                default:
                    Response::send_error(HTTP_BAD_REQUEST, "Ce type de requête est inconnu");

            }
        }
    }
