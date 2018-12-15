<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "/modele_groupe_api.php";

    class ModGroupeAPI
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? strtolower(htmlspecialchars($_GET['action'])) : Response::send_error(HTTP_BAD_REQUEST, 'Paramètre action est absent');
            $id_groupe = isset($_GET['id']) && is_numeric(htmlspecialchars($_GET['id'])) ? htmlspecialchars($_GET['id']) : Response::send_error(HTTP_BAD_REQUEST, 'Id groupe invalid');

            $modele = new ModeleGroupeAPI($id_groupe);

            switch ($action) {
                case 'utilisateurs':
                    $modele->getUtilisateurs();
                break;

                case 'sous_groupes':
                    $modele->getSousGroupes();
                break;


                default:
                    Response::send_error(HTTP_BAD_REQUEST, "Ce type de requête est inconnu");

            }
        }
    }
