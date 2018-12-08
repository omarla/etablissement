<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/vue_semestre.php";
    require_once __DIR__ . "/modele_semestre.php";
    
    class ContSemestre
    {
        private $vue;
        private $modele;

        public function __construct()
        {
            $this->vue = new VueSemestre();
            $this->modele = new ModeleSemestre($this);
        }

        public function afficher_semestres()
        {
            $liste_semestres = $this->modele->liste_semestres();
            
            $this->vue->afficher_semestres($liste_semestres);
        }

        public function ajouter_semestre()
        {
            $ref = isset($_POST['reference']) ? htmlspecialchars($_POST['reference']) : die('Pas de réf');
            $nom = isset($_POST['nom_semestre']) ? htmlspecialchars($_POST['nom_semestre']) : die('Pas de nom');
            $pts_ets = isset($_POST['points_ets']) ? htmlspecialchars($_POST['points_ets']) : die('Pas de points ets');

            $this->modele->ajouter_semestre($ref, $nom, $pts_ets);

            header('Location: index.php?module=administration&type=semestre&action=liste_semestre');
        }

        public function afficher_semestre()
        {
            $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : die('pas d id');

            $semestre = $this->modele->getSemestre($id);

            $annee = $this->modele->annee_courante();

            $this->vue->afficher_semestre($semestre->detailsSemestre(), $semestre->anneesSemestre(), $semestre->etudiantsSemestre(), $annee);
        }
    }
