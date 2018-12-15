<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/cont_generique.php";
    require_once __DIR__ . "/vue_module.php";
    require_once __DIR__ . "/modele_module.php";

    class ContModule extends ContGenerique
    {
        private $vue;
        private $modele;

        public function __construct()
        {
            $this->vue = new VueModule();
            $this->modele = new ModeleModule($this);
        }


        public function liste_modules(){
            $modules = $this->modele->liste_modules();
            $this->vue->afficher_modules($modules);
        }

        public function ajouter_module(){
            $ref = isset($_POST['ref_semestre']) ? htmlspecialchars($_POST['ref_semestre']) : die('pas de ref');
            $nom = isset($_POST['nom_semestre']) ? htmlspecialchars($_POST['nom_semestre']) : die('pas de nom');
            $coef = isset($_POST['coef_semestre']) ? htmlspecialchars($_POST['coef_semestre']) : die('pas de coef');
            $heures_cm = isset($_POST['heures_cm']) ? htmlspecialchars($_POST['heures_cm']) : die('pas de cm');
            $heures_td = isset($_POST['heures_td']) ? htmlspecialchars($_POST['heures_td']) : die('pas de td');
            $heures_tp = isset($_POST['heures_tp']) ? htmlspecialchars($_POST['heures_tp']) : die('pas de tp');
            $couleur = isset($_POST['couleur']) ? htmlspecialchars($_POST['couleur']) : die('pas de couleur');
            $semestre = isset($_POST['semestre_module']) ? htmlspecialchars($_POST['semestre_module']) : die('pas de semestre');

            $this->modele->ajouter_module($ref, $nom, $coef, $heures_cm, $heures_td, $heures_tp);

            header('Location: index.php?module=administration&type=module&action=liste_modules');
        }

    }