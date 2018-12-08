<?php

    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "/../Database.php";
    
    class Module extends Database
    {
        private static $modulesQuery        = 'select * from module';

        private static $moduleQuery         = 'select * from module where ref_module = :ref';
        
        private static $moduleTeachers      = 'select pseudo_utilisateur, id_enseignant, nom_utilisateur, prenom_utilisateur 
                                               from utilisateur 
                                               inner join personnel on(utilisateur.id_utilisateur = personnel.id_utilisateur)
                                               inner join enseignant on(personnel.id_personnel = enseignant.id_personnel)
                                               where id_enseignant in (select * from module_enseigne_par where ref_module = :ref)
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
        

        private static $addTeacher          = 'insert into module_enseigne_par 
                                                (select id_enseignant, :ref_module from utilisateur
                                                inner join personnel on (personnel.id_utilisateur = utilisateur.id_utilisateur)
                                                inner join enseignant on (enseignant.id_personnel = personnel.id_personnel) 
                                                limit 1)';


        private static $deleteTeacher       = 'delete from module_enseigne_par where ref_module = :ref
                                                and id_enseignant in (select id_enseignant, :ref from utilisateur
                                                inner join personnel on (personnel.id_utilisateur = utilisateur.id_utilisateur)
                                                inner join enseignant on (enseignant.id_personnel = personnel.id_personnel) 
                                                where pseudo_utilisateur = :pseudo
                                                limit 1)';
        
        private static $deleteModule        = 'delete from module where ref_module = :ref';

        private static $deleteModuleQuery   = 'delete from module where ref_module = :ref';



        private $ref_module;
        private $informations_module;
        private $enseignants_module;

        public function __construct($ref_module)
        {
            $this->ref_module = $ref_module;
        }

        public function getEnseignantsModule()
        {
            if (!$this->enseignants_module) {
                $stmt = self::$db->prepare(self::$moduleTeachers);

                $stmt->bindValue(':ref', $this->ref_module);
    
                try {
                    $stmt->execute();
                    $this->enseignants_module = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                }
            }
            return $this->enseignants_module;
        }

        public function getDetailsModule()
        {
            if (!$this->informations_module) {
                $stmt = self::$db->prepare(self::$moduleQuery);

                $stmt->bindValue(':ref', $this->ref_module);
    
                try {
                    $stmt->execute();
                    $this->informations_module = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                }
            }
               
            return $this->informations_module;
        }

        public function supprimerEnseignant($pseudo_enseignant)
        {
            $stmt = self::$db->prepare(self::$deleteTeacher);

            $stmt->bindValue(':ref', $this->ref_module);
            $stmt->bindValue(':pseudo', $pseudo_enseignant);
            
            try {
                $stmt->execute();
            } catch (PDOException $e) {
            }
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
            $stmt->bindValue(':ref_semestre', $ref_semestre);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
            }
        }


        public static function getModules()
        {
            $stmt = self::$db->prepare(self::$modulesQuery);


            try {
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
            }
        }
    }
