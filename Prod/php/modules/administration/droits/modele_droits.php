<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    require_once "php/common/classes/droits.php";

    class ModeleDroits extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }

        public function getListeDroits()
        {
            return Droits::getListeDroits();
        }

        public function ajouterDroits(
            $nom_droits,
            $creation_utilisateurs,
            $creation_modules,
            $creation_cours,
            $creation_groupes,
            $modification_absences,
            $modification_droits,
            $modification_heures_travail,
            $statistiques
            ) {
            Droits::ajouterDroits(
                    $nom_droits,
                    $creation_utilisateurs,
                    $creation_modules,
                    $creation_cours,
                    $creation_groupes,
                    $modification_absences,
                    $modification_droits,
                    $modification_heures_travail,
                    $statistiques
                );
        }

        public function modifierDroits(
            $nom_droits,
            $creation_utilisateurs,
            $creation_modules,
            $creation_cours,
            $creation_groupes,
            $modification_absences,
            $modification_droits,
            $modification_heures_travail,
            $statistiques
            ) {
            Droits::modifierDroits(
                    $nom_droits,
                    $creation_utilisateurs,
                    $creation_modules,
                    $creation_cours,
                    $creation_groupes,
                    $modification_absences,
                    $modification_droits,
                    $modification_heures_travail,
                    $statistiques
                );
        }

        public function supprimerDroits($nom_droits)
        {
            Droits::supprimerDroits($nom_droits);
        }




        public function getDroit($nom_droits)
        {
            try {
                $droit =  new Droits($nom_droits);
                return $droit;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
