<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Personnel extends Database
    {
        private static $personalListQuery       = 'select utilisateur.*, personnel.*, enseignant.id_enseignant, coalesce(sum(heures_travail), 0) as heures_travail 
                                                    from personnel 
                                                    inner join utilisateur on (utilisateur.id_utilisateur = personnel.id_utilisateur) 
                                                    left join enseignant on (personnel.id_personnel = enseignant.id_personnel) 
                                                    left join heures_travail on (personnel.id_personnel = heures_travail.id_personnel)
                                                    group by utilisateur.id_utilisateur, personnel.id_personnel, enseignant.id_enseignant';




        private static $personalQuery           = 'select utilisateur.*, personnel.*, enseignant.id_enseignant, coalesce(sum(heures_travail), 0) as heures_travail 
                                                    from personnel 
                                                    inner join utilisateur on (utilisateur.id_utilisateur = personnel.id_utilisateur) 
                                                    left join enseignant on (personnel.id_personnel = enseignant.id_personnel) 
                                                    left join heures_travail on (personnel.id_personnel = heures_travail.id_personnel)
                                                    where personnel.id_personnel = ?
                                                    group by utilisateur.id_utilisateur, personnel.id_personnel, enseignant.id_enseignant ';
        

        private static $personalWorkQuery       = 'select annee, heures_travail from heures_travail where id_personnel = :id_personal order by annee';
    
        private static $insertPersonalQuery     = 'insert into personnel values(default, ?)';
    
        private static $personalWorkUpdateQuery = 'call setWorkHours(:id_personnel, :heures_travail, :annee) ';


        private static $deletePersonalQuery     = 'delete from heures_travail where id_personnel = :id_personnel ;
                                                   delete from personnel where id_personnel = :id_personnel';

        public static function getListePersonnels()
        {
            $stmt = self::$db->prepare(self::$personalListQuery);
            
            $liste_personnel = array();

            try {
                $stmt->execute();
                
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $personnel) {
                    array_push($liste_personnel, array(
                        "id"=>$personnel['id_personnel'],
                        "nom"=>$personnel['nom_utilisateur'],
                        "prenom"=>$personnel['prenom_utilisateur'],
                        "num_enseignant"=>$personnel['id_enseignant'],
                        "heures_travail"=>$personnel['heures_travail']
                    ));
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                //header('Location: index.php?module=error&title=Erreur recher&message=Impossible de trouver la liste des utilisateurs');
            }

            return $liste_personnel;
        }


        public static function getPersonnel($id)
        {
            $stmt = self::$db->prepare(self::$personalQuery);

            $stmt->bindValue(1, $id);

            try {
                $stmt->execute();
                return array_merge($stmt->fetch(PDO::FETCH_ASSOC), array("annee_courante"=>self::getDBYear(), "heures_travail"=>self::getHeuresTravailPersonnel($id)));
            } catch (PDOException $e) {
                echo $e->getMessage();
                //TODO
            }
        }

        public static function getHeuresTravailPersonnel($id_personnel)
        {
            $stmt = self::$db->prepare(self::$personalWorkQuery);

            $stmt->bindValue(":id_personal", $id_personnel);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function ajouterPersonnel($utilisateur)
        {
            $stmtPersonnel = self::$db->prepare(self::$insertPersonalQuery);

            $stmtPersonnel->bindValue(1, $utilisateur['id_utilisateur']);

            try {
                $stmtPersonnel->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        public static function modifierHeuresTravail($id_personnel, $heures_travail)
        {
            $annee =  self::getDBYear();
            
            $stmt = self::$db->prepare(self::$personalWorkUpdateQuery);
            
            $stmt->bindValue(":heures_travail", $heures_travail);
            $stmt->bindValue(":id_personnel", $id_personnel);
            $stmt->bindValue(":annee", $annee);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public static function supprimerPersonnel($id_personnel)
        {
            $stmt = self::$db->prepare(self::$deletePersonalQuery);

            $stmt->bindValue(':id_personnel', $id_personnel);

            try {
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
