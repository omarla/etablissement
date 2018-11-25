<?php
    require_once "php/verify.php";
    require_once __DIR__ . "/vue_utilisateur.php";
    require_once __DIR__ . "/modele_utilisateur.php";

    class ContUtilisateur
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
            $keyList = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance', 'mot_de_passe','droits', 'filliere_bac', 'pays_naissance', 'code_postal');
            
            if (checkArrayForKeys($keyList, $_POST)) {
                $data = $_POST;
            
                $this->modele->insertUser($data);
            } else {
                header('Location: index.php?module=error&title=Paramètres insufisants&message=Le nombre passé de paramètre est beaucoup insuffisant');
            }
        }

        public function afficherModifierUtilisateur()
        {
            $required_key = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance','droits', 'filliere_bac', 'pays_naissance', 'code_postal');

            $id_utilisateur = isset($_GET['id']) ? $_GET['id'] : header('Location: index.php?module=error&title=Paramètres insufisants&message=Le nombre passé de paramètre est beaucoup insuffisant');
            
            $liste_droits = $this->modele->getListeDroits();
            $utilisateur = $this->modele->getUtilisateur($id_utilisateur);

            $this->vue->afficherUtilisateur($utilisateur, $liste_droits);
        }

        public function modifierUtilisateur()
        {
            $required_key = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance','droits', 'filliere_bac', 'pays_naissance', 'code_postal');

            if (checkArrayForKeys($required_key, $_POST) && isset($_GET['id'])) {
                $id = $_GET['id'];

                if (isset($_POST['modifier'])) {
                    $this->modele->modifierUtilisateur($_POST, $id);
                } elseif (isset($_POST['supprimer'])) {
                    $this->modele->supprimerUtilisateur($id);
                } else {
                    //header('Location: index.php?module=error&title=Paramètres insufisants&message=Le nombre passé de paramètre est beaucoup insuffisant');
                }
            } else {
                // header('Location: index.php?module=error&title=Paramètres insufisants&message=Le nombre passé de paramètre est beaucoup insuffisant');
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
            $pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : die("Pseudo incorrecte");
            $estEnseignant = isset($_POST['estEnseignant']) && $_POST['estEnseignant'] === 'on' ? true : false;

            $this->modele->ajouterPersonnel($pseudo, $estEnseignant);
        }

        public function rendreEnseignant()
        {
            $id = isset($_GET['id']) ? $_GET['id'] : die('Id incorrecte');

            $this->modele->rendreEnseignant($id);
        }


        public function afficherModifierPersonnel()
        {
            $id = isset($_GET['id']) ? $_GET['id'] : die('Id incorrecte');

            $personnel = $this->modele->getPersonnel($id);

            $this->vue->modifierPersonnel($personnel);
        }

        public function modifierPersonnel()
        {
            $id_personnel = isset($_GET['id']) ? $_GET['id'] : die('');
            $est_enseignant = isset($_GET['est_enseignant']) ? $_GET['est_enseignant'] == 'on' : false;
            $heures_travail = isset($_GET['heures_travail']) ? $_GET['heures_travail'] : die('');

            $this->modele->modifierPersonnel($id_personnel, $est_enseignant, $heures_travail);
        }
    }
