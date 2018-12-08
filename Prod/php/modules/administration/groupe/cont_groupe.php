<?php
    require_once "php/verify.php";
    require_once __DIR__ . "/vue_groupe.php";
    require_once __DIR__ . "/modele_groupe.php";

    class ContGroupe
    {
        private $vue;
        private $modele;

        public function __construct()
        {
            $this->vue = new VueGroupe();
            $this->modele = new ModeleGroupe($this);
        }

        public function afficherListeGroupes()
        {
            $liste_groupe = $this->modele->getListeGroupes();

            $liste_droits = $this->modele->getListeDroits();
            
            $this->vue->afficherListeGroupe($liste_groupe, $liste_droits);
        }

        public function ajouterGroupe()
        {
            $nom_groupe = isset($_POST['nom_groupe']) ? $_POST['nom_groupe'] : die('Nom groupe');
            $nom_droits = isset($_POST['droits']) ? $_POST['droits'] : die('nom droits');

            $this->modele->ajouterGroupe($nom_groupe, $nom_droits);
        
            header('Location: index.php?module=administration&type=groupe&action=liste_groupes');
        }

        public function ajouterSousGroupe()
        {
            $id_groupe = isset($_GET['id_groupe']) ? $_GET['id_groupe'] : die('Id invalide');
            $id_groupe_fils = isset($_POST['groupe_fils']) ? $_POST['groupe_fils'] : die('Groupe fils invalid');

            $this->modele->ajouterSousGroupe($id_groupe_fils, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }

        public function ajouterUtilisateur()
        {
            $id_groupe = isset($_GET['id_groupe']) ? $_GET['id_groupe'] : die('Id invalide');
            $pseudo_utilisateur = isset($_POST['pseudo_utilisateur']) ? $_POST['pseudo_utilisateur'] : die('Groupe fils invalid');

            $this->modele->ajouterUtilisateur($pseudo_utilisateur, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }


        public function afficherModification()
        {
            $id_groupe = isset($_GET['id']) ? $_GET['id'] : die('ID invalid');
            
            $groupe = $this->modele->detailsGroupe($id_groupe);

            $this->vue->afficherDetailsGroupe($groupe->detailsGroupe(), $groupe->utilisateursGroupe(), $groupe->sousGroupes());
        }

        public function retirerUtilisateur()
        {
            $id_utilisateur = isset($_GET['id_utilisateur']) ? $_GET['id_utilisateur'] : die("Aucun id utilisateur");
            
            $id_groupe = isset($_GET['id_groupe']) ? $_GET['id_groupe'] : die("Aucun groupe");

            $this->modele->retirerUtilisateur($id_utilisateur, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }

        public function retirerGroupe()
        {
            $sous_groupe = isset($_GET['sous_groupe']) ? $_GET['sous_groupe'] : die("Aucun id sous_groupe");
            
            $id_groupe = isset($_GET['id_groupe']) ? $_GET['id_groupe'] : die("Aucun groupe");

            $this->modele->retirerSousGroupe($sous_groupe, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }
    }
