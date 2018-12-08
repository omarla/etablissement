<?php
    require_once "php/verify.php";
    require_once __DIR__ . "/cont_groupe.php";

    class ModGroupe
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? $_GET['action'] : null;
            $cont = new ContGroupe();

            switch ($action) {
                case 'liste_groupes':
                    $cont->afficherListeGroupes();
                break;

                case 'ajouter_groupe':
                    $cont->ajouterGroupe();
                break;

                case 'ajouter_sous_groupe':
                    $cont->ajouterSousGroupe();
                break;

                case 'ajouter_utilisateur':
                    $cont->ajouterUtilisateur();
                break;

                
                case 'ajouter_utilisateur':
                    $cont->ajouterUtilisateur();
                break;

                case 'afficher_modification':
                    $cont->afficherModification();
                break;
                
                case 'retirer_utilisateur':
                    $cont->retirerUtilisateur();
                break;

                case 'retirer_groupe':
                    $cont->retirerGroupe();
                break;

                default:
                    echo "Module Groupe inconnu";
            }
        }
    }
