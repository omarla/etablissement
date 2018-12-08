<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    require_once "php/common/classes/groupe.php";
    require_once "php/common/classes/droits.php";

    class ModeleGroupe extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }

        public function getListeGroupes()
        {
            return Groupe::getListeGroupes();
        }

        public function getListeDroits()
        {
            $liste_droits = array();

            foreach (Droits::getListeDroits() as $droits) {
                array_push($liste_droits, $droits['nom_droits']);
            }

            return $liste_droits;
        }

        public function ajouterGroupe($nom, $droits)
        {
            Groupe::ajouterGroupe($nom, $droits);
        }

        public function detailsGroupe($id_groupe)
        {
            $groupe = new Groupe($id_groupe);

            return $groupe;
        }


        public function retirerUtilisateur($id_utilisateur, $id_groupe)
        {
            $groupe = new Groupe($id_groupe);

            $groupe->retirerUtilisateur($id_utilisateur);
        }

        public function retirerSousGroupe($sous_groupe, $id_groupe)
        {
            $groupe = new Groupe($id_groupe);

            $groupe->retirerSousGroupe($sous_groupe);
        }

        public function ajouterSousGroupe($sous_groupe, $id_groupe)
        {
            $groupe = new Groupe($id_groupe);

            $groupe->ajouterSousGroupe($sous_groupe);
        }

        public function ajouterUtilisateur($pseudo_utilisateur, $id_groupe)
        {
            $groupe = new Groupe($id_groupe);

            $groupe->ajouterUtilisateur($pseudo_utilisateur);
        }
    }
