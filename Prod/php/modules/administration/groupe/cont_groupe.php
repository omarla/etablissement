<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/cont_generique.php";
    require_once __DIR__ . "/vue_groupe.php";
    require_once __DIR__ . "/modele_groupe.php";

    class ContGroupe extends ContGenerique 
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
            $nom_groupe = isset($_POST['nom_groupe']) ? htmlspecialchars($_POST['nom_groupe']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);
            $nom_droits = isset($_POST['droits']) ? htmlspecialchars($_POST['droits']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);

            $this->modele->ajouterGroupe($nom_groupe, $nom_droits);
        
            header('Location: index.php?module=administration&type=groupe&action=liste_groupes');
        }

        public function ajouterSousGroupe()
        {
            $id_groupe = isset($_GET['id_groupe']) ? htmlspecialchars($_GET['id_groupe']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);
            $id_groupe_fils = isset($_POST['groupe_fils']) ? htmlspecialchars($_POST['groupe_fils']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);

            $this->modele->ajouterSousGroupe($id_groupe_fils, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }

        public function ajouterUtilisateur()
        {
            $id_groupe = isset($_GET['id_groupe']) ? htmlspecialchars($_GET['id_groupe']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);
            $pseudo_utilisateur = isset($_POST['pseudo_utilisateur']) ?  htmlspecialchars($_POST['pseudo_utilisateur']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);

            $this->modele->ajouterUtilisateur($pseudo_utilisateur, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }


        public function afficherModification()
        {
            $id_groupe = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);
            
            $groupe = $this->modele->detailsGroupe($id_groupe);

            $this->vue->afficherDetailsGroupe($groupe->detailsGroupe(), $groupe->utilisateursGroupe(), $groupe->sousGroupes());
        }

        public function retirerUtilisateur()
        {
            $id_utilisateur = isset($_GET['id_utilisateur']) ? htmlspecialchars($_GET['id_utilisateur']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);
            
            $id_groupe = isset($_GET['id_groupe']) ? htmlspecialchars($_GET['id_groupe']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);

            $this->modele->retirerUtilisateur($id_utilisateur, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }

        public function retirerGroupe()
        {
            $sous_groupe = isset($_GET['sous_groupe']) ? htmlspecialchars($_GET['sous_groupe']) : die("Aucun id sous_groupe");
            
            $id_groupe = isset($_GET['id_groupe']) ? htmlspecialchars($_GET['id_groupe']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);

            $this->modele->retirerSousGroupe($sous_groupe, $id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=afficher_modification&id='.$id_groupe);
        }

        public function supprimerGroupe(){
            $id_groupe = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);

            $this->modele->supprimerGroupe($id_groupe);

            header('Location: index.php?module=administration&type=groupe&action=liste_groupes');
        }
    }
