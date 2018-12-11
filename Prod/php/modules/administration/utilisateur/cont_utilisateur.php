<?php
    require_once __DIR__ . "./../../../verify.php";
    require_once __DIR__ . "./../../../common/cont_generique.php";
    require_once __DIR__ . "/vue_utilisateur.php";
    require_once __DIR__ . "/modele_utilisateur.php";

    class ContUtilisateur extends ContGenerique
    {
        private $vue;
        private $modele;

        public function __construct()
        {
            $this->vue = new VueUtilisateur();
            $this->modele = new ModeleUtilisateur($this);
        }

        /****************************************************************************************************/
        /*******************************************UTILISATEURS*********************************************/
        /****************************************************************************************************/


        public function afficherListeUtilisateurs()
        {
            $liste_utilisateurs = $this->modele->getListeUtilisateurs();
            $this->vue->afficherListeUtilisateurs($liste_utilisateurs);
        }



        public function afficherCreationUtilisateur()
        {
            $liste_droits = $this->modele->getListeDroits();
            $this->vue->afficherInsertionUtilisateurs($liste_droits);
        }

        public function inscription()
        {
            $keyList = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance', 'mot_de_passe','droits',  'pays_naissance', 'code_postal');
            
            if (checkArrayForKeys($keyList, $_POST)) {
                $data = array_map(function($el){return htmlspecialchars($el);},$_POST);
                $this->modele->insertUser($data);
            } else {
                $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, $message_erreur);
            }

            header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');

        }

        public function afficherModifierUtilisateur()
        {
            $message_erreur = null;
            $titre_erreur = null;

            if(isset($_GET['id'])){
                $id_utilisateur = htmlspecialchars($_GET['id']);
            }else{
                $message_erreur = "Vous devez fournir l'identifiant de l'utilisateur";
                $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, $message_erreur);
            }
            
            $liste_droits = $this->modele->getListeDroits();
            
            $utilisateur = $this->modele->getUtilisateur($id_utilisateur);

            $this->vue->afficherUtilisateur($utilisateur, $liste_droits);
        }

        public function modifierUtilisateur()
        {
            $required_key = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance','droits', 'pays_naissance', 'code_postal');

            if (checkArrayForKeys($required_key, $_POST) && isset($_GET['id'])) {
                $id = htmlspecialchars($_GET['id']);
                $data = array_map(function($el){
                    return htmlspecialchars($el);
                }, $_POST);

                if (isset($_POST['modifier'])) {
                    $this->modele->modifierUtilisateur($data, $id);
                    header('Location: index.php?module=administration&type=utilisateur&action=modification&id='. $_GET['id']);
                } elseif (isset($_POST['supprimer'])) {
                    $this->modele->supprimerUtilisateur($id);
                    header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');
                } else {
                    $this->afficherErreur('Action invalide', "Vous n'avez fournis aucune action");
                }
            } else {
                $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);
            }

        }


        /****************************************************************************************************/
        /*******************************************PERSONNELS***********************************************/
        /****************************************************************************************************/


        public function afficherListePersonnels()
        {
            $liste_personnel = $this->modele->getListePersonnels();
            $this->vue->afficherListePersonnels($liste_personnel);
        }

        public function ajouterPersonnel()
        {
            $pseudo = isset($_POST['pseudo']) ? htmlspecialchars($_POST['pseudo']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, NOT_ENOUGH_PARAM_MESSAGE);
            $estEnseignant = isset($_POST['estEnseignant']) && $_POST['estEnseignant'] === 'on' ? true : false;

            $this->modele->ajouterPersonnel($pseudo, $estEnseignant);

            header('Location: index.php?module=administration&type=personnel&action=liste_personnels');
        }


        public function afficherModifierPersonnel()
        {
            $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, "L'identifiant du personnel n'est pas fourni");

            $personnel = $this->modele->getPersonnel($id);

            $this->vue->modifierPersonnel($personnel);
        }

        public function modifierPersonnel()
        {
            $id_personnel = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, "L'identifiant du personnel n'est pas fourni");
            $est_enseignant = isset($_POST['estEnseignant']) ? htmlspecialchars($_POST['estEnseignant']) === 'on' : false;
            $heures_travail = isset($_POST['heures_travail']) ? htmlspecialchars($_POST['heures_travail']) : $this->afficherErreur(NOT_ENOUGH_PARAM_TITLE, "Le nombre d'heures travaillés sont obligatoires");

            if (isset($_POST['modification'])) {
                $this->modele->modifierPersonnel($id_personnel, $est_enseignant, $heures_travail);
                header('Location: index.php?module=administration&type=personnel&action=afficher_modification_personnel&id='.$id_personnel);
            } elseif (isset($_POST['suppression'])) {
                $this->modele->supprimerPersonnel($id_personnel);
                header('Location: index.php?module=administration&type=personnel&action=liste_personnels');
            }else{
                $this->afficherErreur('Action invalide', "Veuillez choisir entre la modification ou la suppression du personnel");
            }
        }
    }
