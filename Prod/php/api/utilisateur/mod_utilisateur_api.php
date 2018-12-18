<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "/modele_utilisateur_api.php";

    class ModUtilisateurAPI
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? strtolower(htmlspecialchars($_GET['action'])) : Response::send_error(HTTP_BAD_REQUEST, 'Paramètre action est absent');
            
            $modele = new ModeleUtilisateurAPI();

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

                case 'enseignants_module':
                    $ref_module = isset($_GET['module']) ? htmlspecialchars($_GET['module']) : die('pas de module');
                    $modele->getEnseignantsModule($ref_module);
                break;


                default:
                    Response::send_error(HTTP_BAD_REQUEST, "Ce type de requête est inconnu");

            }
        }
    }
