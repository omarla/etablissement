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
                exit(0);
            }
        }

        public function getModule($id_module){
            try{
                $module = new Module($id_module);
                $module->getDetailsModule();
                $module->getEnseignantsModule();
                return $module;
            }catch(PDOException $e){
                echo $e->getMessage();
            }catch(ElementIntrouvable $e){
                echo $e->getMessage();
            }
        }

        public function modifier_module($ref, $nom, $coef, $heures_cm, $heures_td, $heures_tp, $couleur){
            try{
                $module = new Module($ref);
                $module->modifierModule($nom, $coef, $heures_cm , $heures_td, $heures_tp, $couleur);
            }catch(PDOException $e){
                echo $e->getMessage();
                exit(0);
            }
        }

        public function retirer_enseignant($ref_module, $id_enseignant){
            try{
                $module = new Module($ref_module);
                $module->retirerEnseignant($id_enseignant);
            }catch(PDOException $e){
                echo $e->getMessage();
                exit(0);
            } catch(ElementIntrouvable $e){
                echo $e->getMessage();
            }
        }

        public function ajouter_enseignant($ref_module, $id_enseignant, $est_responsable = false){
            try{
                $module = new Module($ref_module);
                $module->ajouterEnseignant($id_enseignant, $est_responsable);
            }catch(PDOException $e){
                echo $e->getMessage();
                exit(0);
            } catch(ElementIntrouvable $e){
                echo $e->getMessage();
            }
        }

        public function supprimer_module($ref_module){
            try{
                $module = new Module($ref_module);
                $module->supprimerModule();
            }catch(PDOException $e){
                echo $e->getMessage();
                exit(0);
            } catch(ElementIntrouvable $e){
                echo $e->getMessage();
            }
        }

    }
