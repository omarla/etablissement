<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/vue_etudiant.php";
    require_once __DIR__ . "/modele_etudiant.php";
    
    class ContEtudiant
    {
        private $vue;
        private $modele;

        public function __construct()
        {
            $this->vue = new VueEtudiant();
            $this->modele = new ModeleEtudiant($this);
        }

        public function afficher_etudiants()
        {
            $liste_etudiants = $this->modele->liste_etudiants();
            
            $this->vue->afficher_etudiants($liste_etudiants);
        }

        public function ajouter_etudiant()
        {
            $num = isset($_POST['num_etudiant']) ? htmlspecialchars($_POST['num_etudiant']) : die('Pas de num');
            $id_utilisateur = isset($_POST['id_utilisateur']) ? htmlspecialchars($_POST['id_utilisateur']) : die("Pas d'utilisateur");

            $this->modele->ajouter_etudiant($num, $id_utilisateur);

            header('Location: index.php?module=administration&type=etudiant&action=liste_etudiant');
        }

        public function afficher_etudiant()
        {
            $num = isset($_GET['num_etudiant']) ? htmlspecialchars($_GET['num_etudiant']) : die('pas de num');

            $etudiant = $this->modele->getEtudiant($num);

            $this->vue->afficher_etudiant($etudiant->detailsEtudiant(), $semestre->anneesSemestre(), $semestre->etudiantsSemestre(), $annee);
        }

        public function supprimer_etudiant()
        {
            $num = isset($_GET['num']) ? htmlspecialchars($_GET['num']) : die('pas de num');

            $this->modele->supprimer_etudiant($num);

            header('Location: index.php?module=administration&type=etudiant&action=liste_etudiant');
        }
    }
