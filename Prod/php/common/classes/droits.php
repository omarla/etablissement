<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Droits extends Database
    {
        private static $rolesListQuery  = 'select * from droits order by nom_droits';

        private static $roleQuery       = 'select * from droits where nom_droits = :nom_droits';

        private static $groupQuery      = 'select nom_groupe from groupe where nom_droits = :nom_droits';

        private static $userQuery       = 'select nom_utilisateur from utilisateur where nom_droits = :nom_droits';

        private static $insertRoleQuery = "insert into droits values(
            :nom_droits,
            :creation_utilisateurs,
            :creation_modules,
            :creation_cours,
            :creation_groupes,
            :modification_absences,
            :modification_droits,
            :modification_heures_travail,
            :statistiques
        )";

        private static $updateRoleQuery = "update droits set
            droit_creation_utilisateurs         = :creation_utilisateurs,
            droits_creation_modules             = :creation_modules,
            droit_creation_cours                = :creation_cours,
            droit_creation_groupes              = :creation_groupes,
            droit_modification_absences         = :modification_absences     ,
            droit_modification_droits           = :modification_droits,
            droit_modification_heures_travail   = :modification_heures_travail,
            droit_visualisation_statistique     = :statistiques
        where nom_droits = :nom_droits";

        private static $deleteRoleQuery = "delete from droits where nom_droits = :nom_droits";




        private $informations_droits;

        private $nom_droits;

        private $liste_groupes;
        
        private $liste_utilisateurs;

        public function __construct($nom_droits)
        {
            $this->nom_droits = $nom_droits;
        }

        public function getData()
        {
            if (!$this->informations_droits) {
                $stmt = self::$db->prepare(self::$roleQuery);

                $stmt->bindValue(":nom_droits", $this->nom_droits);
                
                $stmt->execute();
    
                $this->informations_droits = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return $this->informations_droits;
        }


        public function getListeGroupes()
        {
            if (!$this->liste_groupes) {
                $stmt = self::$db->prepare(self::$groupQuery);
                
                $stmt->bindValue(":nom_droits", $this->nom_droits);
                
                $stmt->execute();
    
                $this->liste_groupes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $this->liste_groupes;
        }


        public function getListeUtilisateurs()
        {
            if (!$this->liste_utilisateurs) {
                $stmt = self::$db->prepare(self::$userQuery);
                
                $stmt->bindValue(":nom_droits", $this->nom_droits);
                
                $stmt->execute();
    
                $this->liste_utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $this->liste_utilisateurs;
        }











        public static function getListeDroits()
        {
            $stmt = self::$db->prepare(self::$rolesListQuery);
          
            
            try {
                $stmt->execute();
                   
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur recher&message=Impossible de récupérer la liste des droits');
            }
        }



        public static function ajouterDroits(
            $nom_droits,
            $creation_utilisateurs,
            $creation_modules,
            $creation_cours,
            $creation_groupes,
            $modification_absences,
            $modification_droits,
            $modification_heures_travail,
            $statistiques
        ) {
            $stmt = self::$db->prepare(self::$insertRoleQuery);

            try {
                $stmt->bindValue(":nom_droits", $nom_droits);
                $stmt->bindValue(":creation_utilisateurs", $creation_utilisateurs);
                $stmt->bindValue(":creation_modules", $creation_modules);
                $stmt->bindValue(":creation_cours", $creation_cours);
                $stmt->bindValue(":creation_groupes", $creation_groupes);
                $stmt->bindValue(":modification_absences", $modification_absences);
                $stmt->bindValue(":modification_droits", $modification_droits);
                $stmt->bindValue(":modification_heures_travail", $modification_heures_travail);
                $stmt->bindValue(":statistiques", $statistiques);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public static function modifierDroits(
            $nom_droits,
            $creation_utilisateurs,
            $creation_modules,
            $creation_cours,
            $creation_groupes,
            $modification_absences,
            $modification_droits,
            $modification_heures_travail,
            $statistiques
        ) {
            $stmt = self::$db->prepare(self::$updateRoleQuery);

            try {
                $stmt->bindValue(":nom_droits", $nom_droits);
                $stmt->bindValue(":creation_utilisateurs", $creation_utilisateurs);
                $stmt->bindValue(":creation_modules", $creation_modules);
                $stmt->bindValue(":creation_cours", $creation_cours);
                $stmt->bindValue(":creation_groupes", $creation_groupes);
                $stmt->bindValue(":modification_absences", $modification_absences);
                $stmt->bindValue(":modification_droits", $modification_droits);
                $stmt->bindValue(":modification_heures_travail", $modification_heures_travail);
                $stmt->bindValue(":statistiques", $statistiques);

                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public static function supprimerDroits($nom_droits)
        {
            $stmt = self::$db->prepare(self::$deleteRoleQuery);

            $stmt->bindValue(':nom_droits', $nom_droits);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
