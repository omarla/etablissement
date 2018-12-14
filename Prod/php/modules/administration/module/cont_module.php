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
    }