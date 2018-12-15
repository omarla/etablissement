<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/classes/module.php";
    require_once __DIR__ . "/../../../common/Database.php";

    class ModeleModule extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }


        public function liste_modules(){
            try{
                return Module::listeModules();
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function ajouter_module($ref, $nom, $coef, $heures_cm, $heures_td, $heures_tp, $couleur, $semestre){
            try{
                Module::ajouterModule($ref, $nom, $coef, $heures_cm , $heures_td, $heures_tp, $couleur, $semestre);
            }catch(PDOException $e){
                echo $e->getMessage();
            }

        }

    }
