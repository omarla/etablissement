<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    class ModeleUtilisateur extends Database
    {
        private const userListQuery = 'select * from utilisateur';
        
        private const personalListQuery = 'select utilisateur.*, personnel.*, enseignant.num_enseignant, coalesce(sum(heures_travail), 0) as heures_travail from personnel inner join utilisateur 
                                           on (utilisateur.id_utilisateur = personnel.id_utilisateur) 
                                           left join enseignant on (personnel.id_personnel = enseignant.id_personnel) 
                                           left join heures_travail on (enseignant.num_enseignant = heures_travail.num_enseignant)
                                           group by utilisateur.id_utilisateur, personnel.id_personnel, num_enseignant';

        private const userIdQuery       = ' select * from utilisateur 
                                            left join filliere_bac on (utilisateur.id_filliere_bac = filliere_bac.id_filliere_bac)
                                            left join Ville on (utilisateur.code_postal_ville = Ville.code_postal_ville)
                                            left join pays on (utilisateur.code_pays = pays.code_pays) where id_utilisateur = ?;';

        private const userPseudoQuery   = ' select * from utilisateur 
                                            left join filliere_bac on (utilisateur.id_filliere_bac = filliere_bac.id_filliere_bac)
                                            left join Ville on (utilisateur.code_postal_ville = Ville.code_postal_ville)
                                            left join pays on (utilisateur.code_pays = pays.code_pays) where pseudo_utilisateur = ?;';


        private const personalQuery     = 'select utilisateur.*, personnel.*, enseignant.num_enseignant, coalesce(sum(heures_travail), 0) as heures_travail from personnel inner join utilisateur 
                                            on (utilisateur.id_utilisateur = personnel.id_utilisateur) 
                                            left join enseignant on (personnel.id_personnel = enseignant.id_personnel) 
                                            left join heures_travail on (enseignant.num_enseignant = heures_travail.num_enseignant)
                                            where personnel.id_personnel = ?
                                            group by utilisateur.id_utilisateur, personnel.id_personnel, num_enseignant ';
        

        private const personalWorkQuery = 'select * from heures_travail where num_enseignant = ?';
        

        private const rolesListQuery    = 'select nom_droits from droits';
       
        private const insertUserQuery   = 'insert into utilisateur values(default, ?, ?, ?,
                                                                        ?, ?, ?, ?, ?, ?,
                                                                        ?, current_date(), 
                                                                        ?, ?, ?, ?)';

        private const insertPersonalQuery = 'insert into personnel values(default, ?, null)';

        private const insertEnseignantQuery = 'insert into enseignant values(default, ?)';

        private const modifyUserQuery   = "update utilisateur 
                                         set mail_utilisateur = ?, nom_utilisateur = ?,
                                         prenom_utilisateur = ?, tel_utilisateur = ?,
                                         adresse_utilisateur = ?, est_homme = ?,
                                         date_naissance_utilisateur = ?, nom_droit = ?,
                                         id_filliere_bac = ?, code_pays = ?, code_postal_ville = ?
                                         where id_utilisateur = ?";

        private const modifyUserPasswordQuery = "update utilisateur set mot_de_passe_utilisateur = ?";

        private const deleteUserQuery = "delete from utilisateur where id_utilisateur = :id_utilisateur";
        

        private const deleteEnseignantQuery = "delete from enseignant where id_personnel = :id_personnel";

        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }


        /****************************************************************************************************/
        /*******************************************GETTERS**************************************************/
        /****************************************************************************************************/
        
        public function getListeUtilisateurs()
        {
            $stmt = self::$db->prepare(self::userListQuery);
            
            $userList = array();

            try {
                $stmt->execute();
                
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user) {
                    array_push($userList, array(
                        "id"=>$user['id_utilisateur'],
                        "nom"=>$user['nom_utilisateur'],
                        "prenom"=>$user['prenom_utilisateur'],
                        "tel"=>$user['tel_utilisateur'],
                        "mail"=>$user['mail_utilisateur'],
                        "date_naissance"=>$user['date_naissance_utilisateur']
                    ));
                }
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur recher&message=Impossible de trouver la liste des utilisateurs');
            }

            return $userList;
        }


        public function getListePersonnels()
        {
            $stmt = self::$db->prepare(self::personalListQuery);
            
            $userList = array();

            try {
                $stmt->execute();
                
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user) {
                    array_push($userList, array(
                        "id"=>$user['id_personnel'],
                        "nom"=>$user['nom_utilisateur'],
                        "prenom"=>$user['prenom_utilisateur'],
                        "num_enseignant"=>$user['num_enseignant'],
                        "heures_travail"=>$user['heures_travail']
                    ));
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                //header('Location: index.php?module=error&title=Erreur recher&message=Impossible de trouver la liste des utilisateurs');
            }

            return $userList;
        }



        public function getUtilisateur($param)
        {
            if (is_numeric($param)) {
                $stmt = self::$db->prepare(self::userIdQuery);
            } else {
                $stmt = self::$db->prepare(self::userPseudoQuery);
            }

            $stmt->bindValue(1, $param);

            try {
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur modification&message=Impossible d\'accéder aux détails de cet utilisateur. Veuillez réessayer plus tard');
            }
        }

        public function getPersonnel($id)
        {
            $stmt = self::$db->prepare(self::personalQuery);

            $stmt->bindValue(1, $id);

            try {
                $stmt->execute();
                return array_merge($stmt->fetch(PDO::FETCH_ASSOC), array("annee"=>self::getAnnee()));
            } catch (PDOException $e) {
                //TODO
            }
        }

        public function getHeuresTravailPersonnel($id){
            $stmt = self::$db->prepare(self::)
        }

        public function getListeDroits()
        {
            $stmt = self::$db->prepare(self::rolesListQuery);
          
            $liste_droits = array();
            
            try {
                $stmt->execute();
                
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    array_push($liste_droits, $row['nom_droits']);
                }
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur recher&message=Impossible de récupérer la liste des droits');
            }

            return $liste_droits;
        }

        
        public function getPseudo($nom, $prenom)
        {
            $liste_mots = explode($prenom, " ");
            
            $pseudo = "";
            
            if (count($liste_mots) > 1) {
                foreach ($liste_mots as $partie) {
                    $pseudo .= $partie[0];
                }
            
                $pseudo .= ".";
            } else {
                $pseudo .= $prenom[0];
            }

            $pseudo .= $nom;

            $stmt = self::$db->prepare("select * from utilisateur where lower(pseudo_utilisateur) = lower(?)");
            
            $stmt->execute(array($pseudo));

            if (false !== $stmt->fetch(PDO::FETCH_NUM)) {
                return $this->getPseudo($nom . rand(0, 400), $prenom);
            }

            return strtolower($pseudo);
        }

        public function getCodePays($nomPays)
        {
            $stmt = self::$db->prepare("select code_pays from pays where nom_pays = ?");
           
            $result = false;

            try {
                $stmt->execute(array($nomPays));
                
                $result = $stmt->fetch(PDO::FETCH_ASSOC)['code_pays'];
            } catch (PDOException $e) {
                //TODO
            }
            
            return $result;
        }

        /****************************************************************************************************/
        /*******************************************FIN GETTERS**********************************************/
        /****************************************************************************************************/


        /****************************************************************************************************/
        /*******************************************INSERTIONS***********************************************/
        /****************************************************************************************************/



        public function insertUser($data)
        {
            $keyList = array('pseudo', 'email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance', 'mot_de_passe', 'cle_recuperation_mdp','droits', 'filliere_bac', 'pays_naissance', 'code_postal');
            
            //Définir et changer quelques paramètres
            $data["mot_de_passe"] = crypt($data['mot_de_passe'], SALT_KEY);
            $data['cle_recuperation_mdp'] = randomString(LONG_CLE_RECUPERATION);
            $data['pseudo'] = $this->getPseudo($data['nom'], $data['prenom']);
            $data['pays_naissance'] =  $this->getCodePays($data['pays_naissance']);

            $user = associativeToNumArray($keyList, $data);
            
            $stmt = self::$db->prepare(self::insertUserQuery);
            
            try {
                $stmt->execute($user);
                header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur inscription&message=Une erreur est survenue lors de l\'inscription d\'un utilisateur');
            }
        }

        public function ajouterPersonnel($pseudo, $estEnseignant)
        {
            $utilisateur = $this->getUtilisateur($pseudo);

            self::$db->beginTransaction();

            $stmtPersonnel = self::$db->prepare(self::insertPersonalQuery);

            $stmtPersonnel->bindValue(1, $utilisateur['id_utilisateur']);

            try {
                $stmtPersonnel->execute();

                if ($estEnseignant) {
                    $lastId = self::getLastInsertId();
                    
                    $this->rendreEnseignant($lastId);
                }

                self::$db->commit();

                header('Location: index.php?module=administration&type=utilisateur&action=liste_personnels');
            } catch (Exception $e) {
                self::$db->rollback();
                echo $e->getMessage();
            }
        }


        /****************************************************************************************************/
        /****************************************FIN INSERTIONS**********************************************/
        /****************************************************************************************************/


        /****************************************************************************************************/
        /****************************************MODIFICATIONS***********************************************/
        /****************************************************************************************************/


        public function modifierUtilisateur($data, $id)
        {
            $keyList = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance', 'droits', 'filliere_bac', 'pays_naissance', 'code_postal');
            
            $data['pays_naissance'] =  $this->getCodePays($data['pays_naissance']);

            if (strlen($data['mot_de_passe']) > 3) {
                $this->modifierMDPUtilisateur($id, $data['mot_de_passe']);
            }

            $user = associativeToNumArray($keyList, $data);

            //On complète les paramètres avec l'identifiant de l'utilisateur
            array_push($user, $id);

            $stmt = self::$db->prepare(self::modifyUserQuery);
            
            try {
                $stmt->execute($user);
                header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur Modification&message=Une erreur est survenue lors de l\'inscription d\'un utilisateur');
            }
        }

        public function modifierMDPUtilisateur($id, $mdp)
        {
            $stmt = self::$db->prepare(self::modifyUserPasswordQuery);

            try {
                $stmt->execute(array(crypt($mdp, SALT_KEY), $id));
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function modifierPersonnel($id_personnel, $est_enseignant, $heures_travail)
        {
            $stmtEnseignant = self::$db->prepare(self::insertEnseignantQuery);
                    
            $stmtEnseignant->bindValue(1, $id_personnel);

            try {
                $stmtEnseignant->execute();
                header('Location: index.php?module=administration&type=utilisateur&action=liste_personnels');
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        /****************************************************************************************************/
        /****************************************FIN_MODIFICATIONS*******************************************/
        /****************************************************************************************************/

        public function supprimerEnseignant($id_personnel)
        {
            $stmtEnseignant = self::$db->prepare(self::insertEnseignantQuery);
                    
            $stmtEnseignant->bindValue(1, $id_personnel);

            try {
                $stmtEnseignant->execute();
                header('Location: index.php?module=administration&type=utilisateur&action=liste_personnels');
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function supprimerUtilisateur($id)
        {
            $stmt = self::$db->prepare(self::deleteUserQuery);
            $stmt->bindValue(':id_utilisateur', $id);

            try {
                $stmt->execute();
                header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur suppression&message=Peut être que cet utilisateur n\'existe pas ');
            }
        }


        /****************************************************************************************************/
        /****************************************FIN INSERTIONS**********************************************/
        /****************************************************************************************************/
    }
