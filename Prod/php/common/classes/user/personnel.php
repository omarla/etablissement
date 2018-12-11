<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../classe_generique.php";
    
    class Personnel extends ClasseGenerique
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

        private $id_personnel;
        private $informations_personnel;

        public function __construct($id_personnel){
            parent::__construct("select * from personnel where id_personnel = ?", array($id_personnel));
            $this->id_personnel = $id_personnel;
        }



        public function informations_personnel()
        {
            if(!$this->informations_personnel){
                $stmt = self::$db->prepare(self::$personalQuery);

                $stmt->bindValue(1, $this->id_personnel);
    
                $stmt->execute();
                
                $this->informations_personnel =  array_merge($stmt->fetch(PDO::FETCH_ASSOC),
                                                             array(
                                                                 "annee_courante"=>self::getDBYear(),
                                                                 "heures_travail"=>$this->heures_travail()
                                                            ));
            }
        
            return $this->informations_personnel;
        }


        public function heures_travail()
        {
            $stmt = self::$db->prepare(self::$personalWorkQuery);

            $stmt->bindValue(":id_personal", $this->id_personnel);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function modifierHeuresTravail($heures_travail)
        {
            $annee =  self::getDBYear();
            
            $stmt = self::$db->prepare(self::$personalWorkUpdateQuery);
            
            $stmt->bindValue(":heures_travail", $heures_travail);
            $stmt->bindValue(":id_personnel", $this->id_personnel);
            $stmt->bindValue(":annee", $annee);

            $stmt->execute();
        }


        public function supprimerPersonnel()
        {
            $stmt = self::$db->prepare(self::$deletePersonalQuery);

            $stmt->bindValue(':id_personnel', $this->id_personnel);

            $stmt->execute();
        }




        public static function ajouterPersonnel($utilisateur)
        {
            $stmtPersonnel = self::$db->prepare(self::$insertPersonalQuery);

            $stmtPersonnel->bindValue(1, $utilisateur['id_utilisateur']);

            $stmtPersonnel->execute();
        }


        
        public static function getListePersonnels()
        {
            $stmt = self::$db->prepare(self::$personalListQuery);
            
            $liste_personnel = array();

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

            return $liste_personnel;
        }



    }
