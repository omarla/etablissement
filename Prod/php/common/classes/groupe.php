<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Groupe extends Database
    {
        private static $allGroupsQuery     = "select groupe.*, 
                                               count(distinct id_groupe_enfant) as nombre_sous_groupes,
                                               count(distinct id_utilisateur) as nombre_utilisateurs
                                               from groupe left join sous_groupe on(est_un_sous_groupe(id_groupe_enfant, groupe.id_groupe) = 1)
                                               left join membres_de_groupe on(est_dans_groupe(id_utilisateur, groupe.id_groupe) = 1) 
                                               group by id_groupe order by groupe.id_groupe";
        


        private static $groupUsersQuery     = "select utilisateur.id_utilisateur, pseudo_utilisateur,
                                                personnel.id_personnel, id_enseignant, num_etudiant
                                                from membres_de_groupe 
                                                inner join utilisateur on (membres_de_groupe.id_utilisateur = utilisateur.id_utilisateur) 
                                                left join personnel on (utilisateur.id_utilisateur = personnel.id_utilisateur)
                                                left join enseignant on (enseignant.id_personnel = personnel.id_personnel)
                                                left join etudiant on (etudiant.id_utilisateur = utilisateur.id_utilisateur)
                                                where id_groupe = :id_groupe
                                                ";

        private static $groupChildQuery    = "select id_groupe_enfant as id_groupe, groupe.nom_groupe as nom_groupe, count(distinct id_utilisateur) as nombre_utilisateurs
                                                from sous_groupe inner join groupe on(id_groupe_enfant = id_groupe) 
                                                left join membres_de_groupe on (est_dans_groupe(id_utilisateur, groupe.id_groupe) = 1)
                                                where id_groupe_parent = :groupe_parent
                                                group by groupe.id_groupe";

        private static $groupDetailsQuery  = "select * from groupe where id_groupe = :id_groupe";


        private static $addUserQuery       = "insert into membres_de_groupe select :id_groupe, id_utilisateur from utilisateur where pseudo_utilisateur  = :pseudo_utilisateur limit 1";
        private static $addGroupQuery      = "insert into sous_groupe values(:groupe_parent, :groupe_enfant)";
        private static $insertGroupQuery    = "insert into groupe values (default, :nom_groupe, :nom_droits)";

        private static $deleteChildQuery   = "delete from sous_groupe where id_groupe_parent = :groupe_parent and id_groupe_enfant = :groupe_enfant";
        private static $deleteUserQuery    = "delete from membres_de_groupe where id_groupe = :id_groupe and id_utilisateur = :id_utilisateur";
        private static $deleteGroupQuery   = "delete from groupe where id_groupe = :id_groupe";
        

        private $id_groupe;
        private $details_groupe;
        private $utilisateurs;
        private $sous_groupes;

        public function __construct($id_groupe)
        {
            $this->id_groupe = $id_groupe;
        }

        public function utilisateursGroupe()
        {
            if (!$this->utilisateurs) {
                $stmt = self::$db->prepare(self::$groupUsersQuery);
                $stmt->bindValue(':id_groupe', $this->id_groupe);
                try {
                    $stmt->execute();
                    $this->utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die("ERREUR RÉCUPÉRATION");
                }
            }

            return $this->utilisateurs;
        }


        public function sousGroupes()
        {
            if (!$this->sous_groupes) {
                $stmt = self::$db->prepare(self::$groupChildQuery);
                $stmt->bindValue(':groupe_parent', $this->id_groupe);
                try {
                    $stmt->execute();
                    $this->sous_groupes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die("ERREUR RÉCUPÉRATION");
                }
            }

            return $this->sous_groupes;
        }


        public function detailsGroupe()
        {
            if (!$this->details_groupe) {
                $stmt = self::$db->prepare(self::$groupDetailsQuery);
                $stmt->bindValue(':id_groupe', $this->id_groupe);
                try {
                    $stmt->execute();
                    $this->details_groupe = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die("ERREUR RÉCUPÉRATION");
                }
            }

            return $this->details_groupe;
        }

        public function ajouterUtilisateur($pseudo_utilisateur)
        {
            $stmt = self::$db->prepare(self::$addUserQuery);
            
            $stmt->bindValue(':id_groupe', $this->id_groupe);
            $stmt->bindValue(':pseudo_utilisateur', $pseudo_utilisateur);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function ajouterSousGroupe($sous_groupe)
        {
            $stmt = self::$db->prepare(self::$addGroupQuery);
            
            $stmt->bindValue(':groupe_parent', $this->id_groupe);
            $stmt->bindValue(':groupe_enfant', $sous_groupe);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        

        public function retirerUtilisateur($id_utilisateur)
        {
            $stmt = self::$db->prepare(self::$deleteUserQuery);
            
            $stmt->bindValue(':id_groupe', $this->id_groupe);
            $stmt->bindValue(':id_utilisateur', $id_utilisateur);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function retirerSousGroupe($sous_groupe)
        {
            $stmt = self::$db->prepare(self::$deleteChildQuery);
            
            $stmt->bindValue(':groupe_parent', $this->id_groupe);
            $stmt->bindValue(':groupe_enfant', $sous_groupe);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function supprimer($sous_groupe)
        {
            $stmt = self::$db->prepare(self::$deleteGroupQuery);
            
            $stmt->bindValue(':id_groupe', $this->id_groupe);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }






        public static function getListeGroupes()
        {
            $stmt = self::$db->prepare(self::$allGroupsQuery);

            try {
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo $e->getMessage();
                //TODO
            }
        }

        public static function ajouterGroupe($nom_groupe, $nom_droits)
        {
            $stmt = self::$db->prepare(self::$insertGroupQuery);
            
            $stmt->bindValue(":nom_groupe", $nom_groupe);
            $stmt->bindValue(":nom_droits", $nom_droits);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
