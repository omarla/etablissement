<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/vue_generique.php";

    class VueModule extends VueGenerique
    {
        public function __construct()
        {
        }

        public function afficher_modules($modules){
            echo '<h2 class="text-center text-dark underline mb-4 pt-2 underline">
                     Gestion des modules
                </h2>';
            
            $this->afficherTableau(
                $modules,
                array('ref_module',  'nom_module', 'ref_semestre','coefficient_module', 'heures_cm_module', 'heures_tp_module', 'heures_td_module'),
                'index.php?module=administration&type=module&action=afficher_module&id=',
                'ref_module',
                array('réf', 'nom', 'semestre', 'coefficient', 'CM', 'TD', 'TP')
            );

            require_once __DIR__ . "/html/ajouter_module.html";

        }
    }
