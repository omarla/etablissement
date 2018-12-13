<?php
    require_once __DIR__ . "/../../verify.php";
    require_once __DIR__ . "/../Database.php";
    require_once __DIR__ . "/classe_generique.php";

    class Groupe extends ClasseGenerique
    {
        private static $allGroupsQuery     = "select groupe.*, 
                                               count(distinct id_groupe_fils) as nombre_sous_groupes,
                                               count(distinct id_utilisateur) as nombre_utilisateurs
                                               from groupe left join sous_groupe on(est_un_sous_groupe(id_groupe_fils, groupe.id_groupe))
                                               left join membres_de_groupe on(utilisateur_appartient_a_groupe(id_utilisateur, groupe.id_groupe)) 
                                               group by groupe.id_groupe order by groupe.id_groupe";
        


        private static $groupUsersQuery     = "select utilisateur.id_utilisateur, pseudo_utilisateur,
                                                personnel.id_personnel, id_enseignant, num_etudiant, date_debut || ' => ' || date_fin as periode
                                                from membres_de_groupe 
                                                inner join utilisateur on (membres_de_groupe.id_utilisateur = utilisateur.id_utilisateur) 
                                                left join personnel on (utilisateur.id_utilisateur = personnel.id_utilisateur)
                                                left join enseignant on (enseignant.id_personnel = personnel.id_personnel)
                                                left join etudiant on (etudiant.id_utilisateur = utilisateur.id_utilisateur)
                                                where id_groupe = :id_groupe
                                                ";

        private static $groupChildQuery    = "select id_groupe_fils as id_groupe, groupe.nom_groupe as nom_groupe, count(distinct id_utilisateur) as nombre_utilisateurs
                                                from sous_groupe inner join groupe on(id_groupe_fils = id_groupe) 
                                                left join membres_de_groupe on (utilisateur_appartient_a_groupe(id_utilisateur, id_groupe_fils))
                                                where id_groupe_parent = :groupe_parent
                                                group by groupe.id_groupe, id_groupe_fils";

        private static $groupDetailsQuery  = "select * from groupe where id_groupe = :id_groupe";


        private static $addUserQuery       = "insert into membres_de_groupe values (:id_groupe, :id_utilisateur, :debut, :fin)";
        private static $addGroupQuery      = "insert into sous_groupe values(:groupe_parent, :groupe_enfant)";
        private static $insertGroupQuery   = "insert into groupe values (default, :nom_groupe, :nom_droits)";

        private static $deleteChildQuery   = "delete from sous_groupe where id_groupe_parent = :groupe_parent and id_groupe_fils = :groupe_enfant";
        private static $deleteUserQuery    = "delete from membres_de_groupe where id_groupe = :id_groupe and id_utilisateur = :id_utilisateur";
        
        private static $deleteSubGroups    = "delete from sous_groupe where id_groupe_parent = :id_groupe";
        private static $deleteAllUsers     = "delete from membres_de_groupe where id_groupe = :id_groupe";
        private static $deleteGroupQuery   = "delete from groupe where id_groupe = :id_groupe";

        private $id_groupe;
        private $details_groupe;
        private $utilisateurs;
        private $sous_groupes;

        public function __construct($id_groupe)
        {
            parent::__construct("select * from groupe where id_groupe = ?", array($id_groupe));
            $this->id_groupe = $id_groupe;
        }

        public function utilisateursGroupe()
        {
            if (!$this->utilisateurs) {
                $stmt = self::$db->prepare(self::$groupUsersQuery);
                $stmt->bindValue(':id_groupe', $this->id_groupe);
                $stmt->execute();
                $this->utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $this->utilisateurs;
        }


        public function sousGroupes()
        {
            if (!$this->sous_groupes) {
                $stmt = self::$db->prepare(self::$groupChildQuery);
                $stmt->bindValue(':groupe_parent', $this->id_groupe);
                $stmt->execute();
                $this->sous_groupes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $this->sous_groupes;
        }


        public function detailsGroupe()
        {
            if (!$this->details_groupe) {
                $stmt = self::$db->prepare(self::$groupDetailsQuery);
                $stmt->bindValue(':id_groupe', $this->id_groupe);
                $stmt->execute();
                $this->details_groupe = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return $this->details_groupe;
        }

        public function ajouterUtilisateur($id_utilisateur)
        {
            $stmt = self::$db->prepare(self::$addUserQuery);
            $periode = explode(" => ", self::getDBYear());

            $stmt->bindValue(':id_groupe', $this->id_groupe);
            $stmt->bindValue(':id_utilisateur', $id_utilisateur);
            $stmt->bindValue(':debut', $periode[0]);
            $stmt->bindValue(':fin', $periode[1]);

            $stmt->execute();
        }


        public function ajouterSousGroupe($sous_groupe)
        {
            $stmt = self::$db->prepare(self::$addGroupQuery);
            
            $stmt->bindValue(':groupe_parent', $this->id_groupe);
            $stmt->bindValue(':groupe_enfant', $sous_groupe);

            $stmt->execute();
        }


        

        public function retirerUtilisateur($id_utilisateur)
        {
            $stmt = self::$db->prepare(self::$deleteUserQuery);
            
            $stmt->bindValue(':id_groupe', $this->id_groupe);
            $stmt->bindValue(':id_utilisateur', $id_utilisateur);

            $stmt->execute();
        }

        public function retirerSousGroupe($sous_groupe)
        {
            $stmt = self::$db->prepare(self::$deleteChildQuery);
            
            $stmt->bindValue(':groupe_parent', $this->id_groupe);
            $stmt->bindValue(':groupe_enfant', $sous_groupe);

            $stmt->execute();
        }

        public function supprimer()
        {
            $stmt_sous_groupes = self::$db->prepare(self::$deleteSubGroups);
            $stmt_utilisateurs = self::$db->prepare(self::$deleteAllUsers);
            $stmt_suppression  = self::$db->prepare(self::$deleteGroupQuery);
            
            $stmt_sous_groupes->bindValue(':id_groupe', $this->id_groupe);
            $stmt_utilisateurs->bindValue(':id_groupe', $this->id_groupe);
            $stmt_suppression->bindValue(':id_groupe', $this->id_groupe);


            self::$db->beginTransaction();

            $stmt_sous_groupes->execute();
            $stmt_utilisateurs->execute();
            $stmt_suppression->execute();

            //Si on arrive içi alors toutes les opérations se sont bien déroulées
            self::$db->commit();
        }

        public static function getListeGroupes()
        {
            $stmt = self::$db->prepare(self::$allGroupsQuery);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function ajouterGroupe($nom_groupe, $nom_droits)
        {
            $stmt = self::$db->prepare(self::$insertGroupQuery);
            
            $stmt->bindValue(":nom_groupe", $nom_groupe);
            $stmt->bindValue(":nom_droits", $nom_droits);

            $stmt->execute();
        }
    }
