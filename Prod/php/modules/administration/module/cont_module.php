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
            $ref = isset($_POST['reference_module']) ? htmlspecialchars($_POST['reference_module']) : die('pas de ref');
            $nom = isset($_POST['nom_module']) ? htmlspecialchars($_POST['nom_module']) : die('pas de nom');
            $coef = isset($_POST['coefficient_module']) ? htmlspecialchars($_POST['coefficient_module']) : die('pas de coef');
            $heures_cm = isset($_POST['heures_cm']) ? htmlspecialchars($_POST['heures_cm']) : die('pas de cm');
            $heures_td = isset($_POST['heures_td']) ? htmlspecialchars($_POST['heures_td']) : die('pas de td');
            $heures_tp = isset($_POST['heures_tp']) ? htmlspecialchars($_POST['heures_tp']) : die('pas de tp');
            $couleur = isset($_POST['couleur']) ? htmlspecialchars($_POST['couleur']) : die('pas de couleur');
            $semestre = isset($_POST['semestre']) ? htmlspecialchars($_POST['semestre']) : die('pas de semestre');

            $this->modele->ajouter_module($ref, $nom, $coef, $heures_cm, $heures_td, $heures_tp, $couleur, $semestre);

            header('Location: index.php?module=administration&type=module&action=liste_modules');
        }


        public function afficher_module(){
            $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : die("Pas d'id");
            $module = $this->modele->getModule($id);
            $this->vue->afficher_module($module->getDetailsModule(), $module->getEnseignantsModule());
        }

        public function modifier_module(){
            $ref = isset($_GET['ref_module']) ? htmlspecialchars($_GET['ref_module']) : die('pas de ref');
            $nom = isset($_POST['nom_module']) ? htmlspecialchars($_POST['nom_module']) : die('pas de nom');
            $coef = isset($_POST['coefficient_module']) ? htmlspecialchars($_POST['coefficient_module']) : die('pas de coef');
            $heures_cm = isset($_POST['heures_cm']) ? htmlspecialchars($_POST['heures_cm']) : die('pas de cm');
            $heures_td = isset($_POST['heures_td']) ? htmlspecialchars($_POST['heures_td']) : die('pas de td');
            $heures_tp = isset($_POST['heures_tp']) ? htmlspecialchars($_POST['heures_tp']) : die('pas de tp');
            $couleur = isset($_POST['couleur']) ? htmlspecialchars($_POST['couleur']) : die('pas de couleur');

            $this->modele->modifier_module($ref, $nom, $coef, $heures_cm, $heures_td, $heures_tp, $couleur);

            header('Location: index.php?module=administration&type=module&action=liste_modules');
        }

        public function retirer_enseignant(){
            $ref_module = isset($_GET['ref_module']) ? htmlspecialchars($_GET['ref_module']) : die('pas de ref');
            $id_enseignant = isset($_GET['id_enseignant']) ? htmlspecialchars($_GET['id_enseignant']) : die('pas de enseignant');

            $this->modele->retirer_enseignant($ref_module, $id_enseignant);

            header('Location: index.php?module=administration&type=module&action=afficher_module&id='.$ref_module);
        }


        public function ajouter_enseignant(){
            $ref_module = isset($_GET['ref_module']) ? htmlspecialchars($_GET['ref_module']) : die("Pas d'id");
            $id_enseignant = isset($_POST['id_enseignant']) ? htmlspecialchars($_POST['id_enseignant']) : die('pas de enseignant');
            $est_responsable = isset($_POST['estResponsable']) && $_POST['estResponsable'] === 'on' ? 1 : 0;

            $this->modele->ajouter_enseignant($ref_module, $id_enseignant, $est_responsable);

            header('Location: index.php?module=administration&type=module&action=afficher_module&id='.$ref_module);
        }

        public function supprimer_module(){
            $ref_module = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : die("Pas d'id");
            
            $this->modele->supprimer_module($ref_module);
            
            header('Location: index.php?module=administration&type=module&action=liste_modules');
        }
    }