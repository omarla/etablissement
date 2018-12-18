<?php

    require_once __DIR__ . "/../../verify.php";
    require_once __DIR__ . "/../Database.php";
    require_once __DIR__ . "/classe_generique.php";

    class Module extends ClasseGenerique
    {
        private static $modulesQuery        = 'select * from module';

        private static $moduleQuery         = 'select * from module where ref_module = :ref';
        
        private static $moduleTeachers      = 'select est_responsable, id_enseignant, nom_utilisateur, prenom_utilisateur 
                                               from module_enseigne_par 
                                               inner join enseignant using(id_enseignant) 
                                               inner join personnel using(id_personnel)
                                               inner join utilisateur using(id_utilisateur)
                                               where ref_module = :ref
                                                ';

        private static $availableTeachers   = 'select nom_utilisateur, prenom_utilisateur, pseudo_utilisateur, id_enseignant
                                                from enseignant 
                                                inner join personnel using(id_personnel)
                                                inner join utilisateur using(id_utilisateur)
                                                where id_enseignant not in (
                                                    select id_enseignant from module_enseigne_par where ref_module = :ref
                                                ) 
                                                ';

        private static $insertModuleQuery   = 'insert into module values(
                                                :ref,
                                                :nom,
                                                :coefficient,
                                                :heures_cm,
                                                :heures_tp,
                                                :heures_td,
                                                :couleur_module,
                                                :ref_semestre)';
        
        private static $addTeacher          = 'insert into module_enseigne_par values (:est_responsable, :id_enseignant, :ref) ';


        private static $updateModuleQuery   = "update module set 
                                                nom_module = :nom,
                                                coefficient_module = :coefficient,
                                                heures_cm_module = :heures_cm,
                                                heures_td_module = :heures_td,
                                                heures_tp_module = :heures_tp,
                                                couleur_module   = :couleur_module
                                                where ref_module = :ref";                                        








        private static $deleteTeacher       = 'delete from module_enseigne_par where ref_module = :ref
                                                and id_enseignant = :id_enseignant';
        
        private static $deleteAllTeachers   = "delete from module_enseigne_par where ref_module = :ref";

        private static $deleteModuleQuery   = 'delete from module where ref_module = :ref';




        private $ref_module;
        private $informations_module;
        private $enseignants_module;
        private $enseignants_a_ajouter;

        public function __construct($ref_module)
        {
            parent::__construct("select * from module where ref_module = :ref", array(':ref'=>$ref_module));
            $this->ref_module = $ref_module;
        }

        public function getEnseignantsModule()
        {
            if (!$this->enseignants_module) {
                $stmt = self::$db->prepare(self::$moduleTeachers);

                $stmt->bindValue(':ref', $this->ref_module);
    
                $stmt->execute();
                $this->enseignants_module = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $this->enseignants_module;
        }


        public function getEnseignantsAAjouter(){
            if (!$this->enseignants_a_ajouter) {
                $stmt = self::$db->prepare(self::$availableTeachers);

                $stmt->bindValue(':ref', $this->ref_module);
    
                $stmt->execute();
                
                $this->enseignants_a_ajouter = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $this->enseignants_a_ajouter;

        }

        public function getDetailsModule()
        {
            if (!$this->informations_module) {
                $stmt = self::$db->prepare(self::$moduleQuery);

                $stmt->bindValue(':ref', $this->ref_module);
    
                $stmt->execute();

                $this->informations_module = $stmt->fetch(PDO::FETCH_ASSOC);

            }
               
            return $this->informations_module;
        }


        public function modifierModule($nom, $coef, $heures_cm, $heures_tp, $heures_td, $couleur)
        {
            $stmt = self::$db->prepare(self::$updateModuleQuery);

            $stmt->bindValue(':ref', $this->ref_module);
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':coefficient', $coef);
            $stmt->bindValue(':heures_cm', $heures_cm);
            $stmt->bindValue(':heures_tp', $heures_tp);
            $stmt->bindValue(':heures_td', $heures_td);
            $stmt->bindValue(':couleur_module', $couleur);

            $stmt->execute();
        }


        public function retirerEnseignant($id_enseignant)
        {
            $stmt = self::$db->prepare(self::$deleteTeacher);

            $stmt->bindValue(':ref', $this->ref_module);
            $stmt->bindValue(':id_enseignant', $id_enseignant);
            
            $stmt->execute();
        }


        public function ajouterEnseignant($id_enseignant, $est_responsable){
            $stmt = self::$db->prepare(self::$addTeacher);

            $stmt->bindValue(':ref', $this->ref_module);
            $stmt->bindValue(':id_enseignant', $id_enseignant);
            $stmt->bindValue(':est_responsable', $est_responsable);

            $stmt->execute();
        }


        public function supprimerModule(){
            self::$db->beginTransaction();
            
            $stmt1 = self::$db->prepare(self::$deleteAllTeachers);
            $stmt2 = self::$db->prepare(self::$deleteModuleQuery);

            $stmt1->bindValue(':ref', $this->ref_module);
            $stmt2->bindValue(':ref', $this->ref_module);

            $stmt1->execute();
            $stmt2->execute();

            self::$db->commit();
        }




        public static function ajouterModule($ref, $nom, $coef, $heures_cm, $heures_tp, $heures_td, $couleur, $semestre)
        {
            $stmt = self::$db->prepare(self::$insertModuleQuery);

            $stmt->bindValue(':ref', $ref);
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':coefficient', $coef);
            $stmt->bindValue(':heures_cm', $heures_cm);
            $stmt->bindValue(':heures_tp', $heures_tp);
            $stmt->bindValue(':heures_td', $heures_td);
            $stmt->bindValue(':couleur_module', $couleur);
            $stmt->bindValue(':ref_semestre', $semestre);

            $stmt->execute();
        }


        public static function listeModules()
        {
            $stmt = self::$db->prepare(self::$modulesQuery);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
