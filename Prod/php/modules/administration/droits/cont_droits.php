<?php
    require_once "php/verify.php";
    require_once __DIR__ . "/vue_droits.php";
    require_once __DIR__ . "/modele_droits.php";

    class ContDroits
    {
        private $vue;
        private $modele;

        public function __construct()
        {
            $this->vue = new VueDroits();
            $this->modele = new ModeleDroits($this);
        }

        public function afficherListeDroits()
        {
            $liste_droits = $this->modele->getListeDroits();
            $this->vue->afficherDetailsListeDroits($liste_droits);
        }

        public function afficher_ajouter_droits()
        {
            $this->vue->ajouterDroits();
        }


        public function ajouterDroits()
        {
            $nom_droits = isset($_POST['nom_droits']) ? $_POST['nom_droits'] : die('false');
            $creation_utilisateurs = isset($_POST['creation_utilisateurs']) ? 1 : 0;
            $creation_modules = isset($_POST['creation_modules']) ? 1 : 0;
            $creation_cours = isset($_POST['creation_cours']) ? 1 : 0;
            $creation_groupes = isset($_POST['creation_groupes']) ? 1 : 0;
            $modification_abscences = isset($_POST['modification_abscences']) ? 1 : 0;
            $modification_heures_travail = isset($_POST['modification_heures_travail']) ? 1 : 0;
            $modifications_droits = isset($_POST['modifications_droits']) ? 1 : 0;
            $statistiques = isset($_POST['statistiques']) ? 1 : 0;

            $this->modele->ajouterDroits(
                            $nom_droits,
                            $creation_utilisateurs,
                            $creation_modules,
                            $creation_cours,
                            $creation_groupes,
                            $modification_abscences,
                            $modifications_droits,
                            $modification_heures_travail,
                            $statistiques
                         );
            
            header('Location: http://etablissement.com/Prod/index.php?module=administration&type=droits&action=liste_droits');
        }



        public function afficherModification()
        {
            $nom_droit = isset($_GET['nom_droits']) ? $_GET['nom_droits'] : die('Indéfini nom_droit');
            $droit = $this->modele->getDroit($nom_droit);
            $liste_groupe = $droit->getListeGroupes();
            $liste_utilisateurs = $droit->getListeUtilisateurs();
            $this->vue->modifierDroits($droit->getData(), $liste_utilisateurs, $liste_groupe);
        }


        public function modifierDroit()
        {
            $nom_droits = isset($_GET['nom_droits']) ? $_GET['nom_droits'] : die('Indéfini nom_droit');
            
            $suppression = isset($_POST['supprimer']) ? true : false;

            $modification = isset($_POST['modifier']) ? true : false;

            if ($modification) {
                $creation_utilisateurs = isset($_POST['creation_utilisateurs']) ? 1 : 0;
                $creation_modules = isset($_POST['creation_modules']) ? 1 : 0;
                $creation_cours = isset($_POST['creation_cours']) ? 1 : 0;
                $creation_groupes = isset($_POST['creation_groupes']) ? 1 : 0;
                $modification_abscences = isset($_POST['modification_abscences']) ? 1 : 0;
                $modification_heures_travail = isset($_POST['modification_heures_travail']) ? 1 : 0;
                $modifications_droits = isset($_POST['modifications_droits']) ? 1 : 0;
                $statistiques = isset($_POST['statistiques']) ? 1 : 0;
                
                $this->modele->modifierDroits(
                    $nom_droits,
                    $creation_utilisateurs,
                    $creation_modules,
                    $creation_cours,
                    $creation_groupes,
                    $modification_abscences,
                    $modifications_droits,
                    $modification_heures_travail,
                    $statistiques
                 );
                header('Location: http://etablissement.com/Prod/index.php?module=administration&type=droits&action=liste_droits');
            } elseif ($suppression) {
                $this->modele->supprimerDroits($nom_droits);
            } else {
                echo "UNKNOWN";
                //TODO HANDLE ERROR
            }

            header('Location: http://etablissement.com/Prod/index.php?module=administration&type=droits&action=liste_droits');
        }
    }
