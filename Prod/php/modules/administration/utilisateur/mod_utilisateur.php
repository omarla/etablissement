<?php
    require_once __DIR__ . "/cont_utilisateur.php";
    require_once "php/verify.php";

    class ModUtilisateur
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? $_GET['action'] : null;
            $cont = new ContUtilisateur();

            switch ($action) {
                case 'liste_utilisateurs':
                    $cont->afficherListeUtilisateurs();
                break;

                case 'liste_personnels':
                    $cont->afficherListePersonnels();
                break;
                
                case 'afficherCreationUtilisateur':
                    $cont->afficherCreationUtilisateur();
                break;

                case 'inscription_utilisateur':
                    $cont->inscription();
                break;

                case 'ajouter_personnel':
                    $cont->ajouterPersonnel();
                break;

                case 'modification':
                    $cont->afficherModifierUtilisateur();
                break;
                
                case 'modification_utilisateur':
                    $cont->modifierUtilisateur();
                break;

                case 'afficher_modification_personnel':
                    $cont->afficherModifierPersonnel();
                break;

                case 'modifier_personnel':
                    $cont->modifierPersonnel();
                break;


                default:
                    header("Location: index.php?module=error&title=action invalide&message=".INVALID_ACTION_ERROR_MESSAGE);
            }
        }
    }
