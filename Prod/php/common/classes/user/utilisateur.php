<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    
    class Utilisateur extends Database
    {
        private static $userListQuery           = 'select * from utilisateur';
        
        private static $userIdQuery             = 'select * from utilisateur 
                                                    left join ville on (utilisateur.code_postal_ville = ville.code_postal_ville)
                                                    left join pays on (utilisateur.code_pays = pays.code_pays) where id_utilisateur = ?;';

        private static $userPseudoQuery         = 'select * from utilisateur 
                                                    left join ville on (utilisateur.code_postal_ville = ville.code_postal_ville)
                                                    left join pays on (utilisateur.code_pays = pays.code_pays) where pseudo_utilisateur = ?;';
    
    
        private static $insertUserQuery         = 'insert into utilisateur values(
                                                    default, ?, ?, ?,
                                                    ?, ?, ?, ?, ?, ?,
                                                    ?,current_date(), 
                                                    ?, ?, ?)';

        private static $modifyUserQuery         = "update utilisateur 
                                                    set mail_utilisateur = ?, nom_utilisateur = ?,
                                                    prenom_utilisateur = ?, tel_utilisateur = ?,
                                                    adresse_utilisateur = ?, est_homme_utilisateur = ?,
                                                    date_naissance_utilisateur = ?, nom_droits = ?,
                                                    code_pays = ?, code_postal_ville = ?
                                                    where id_utilisateur = ?";
       
        private static $modifyUserPasswordQuery = "update utilisateur set mot_de_passe_utilisateur = ?";
    
    
        private static $deleteUserQuery       = "delete from utilisateur where id_utilisateur = :id_utilisateur";
    
        //Renvoie la liste des utilisateurs
        public static function getListeUtilisateurs()
        {
            $stmt = self::$db->prepare(self::$userListQuery);
            
            $liste_utilisateurs = array();

            try {
                $stmt->execute();
                
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $utilisateur) {
                    array_push($liste_utilisateurs, array(
                        "id"=>$utilisateur['id_utilisateur'],
                        "nom"=>$utilisateur['nom_utilisateur'],
                        "prenom"=>$utilisateur['prenom_utilisateur'],
                        "tel"=>$utilisateur['tel_utilisateur'],
                        "mail"=>$utilisateur['mail_utilisateur'],
                        "date_naissance"=>$utilisateur['date_naissance_utilisateur']
                    ));
                }
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur recher&message=Impossible de trouver la liste des utilisateurs');
            }

            return $liste_utilisateurs;
        }

        //Renvoie l'utilisateur correspondant à l'identifiant envoyé $id
        public static function getUtilisateurParId($id_utilisateur)
        {
            $stmt = self::$db->prepare(self::$userIdQuery);

            $stmt->bindValue(1, $id_utilisateur);

            try {
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur modification&message=Impossible d\'accéder aux détails de cet utilisateur. Veuillez réessayer plus tard');
            }
        }

        //Renvoie l'utilisateur correspondant au pseudo envoyé $pseudo
        public static function getUtilisateurParPseudo($pseudo)
        {
            $stmt = self::$db->prepare(self::$userPseudoQuery);

            $stmt->bindValue(1, $pseudo);

            try {
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur modification&message=Impossible d\'accéder aux détails de cet utilisateur. Veuillez réessayer plus tard');
            }
        }
        


        public static function insertUser($data)
        {
            $cle_requis = array('pseudo', 'email','nom', 'prenom', 'addresse', 'est_homme', 'tel', 'date_naissance', 'mot_de_passe', 'cle_recuperation_mdp','pays_naissance', 'droits', 'code_postal');
            
            //Définir et changer quelques paramètres
            $data["mot_de_passe"] = crypt($data['mot_de_passe'], SALT_KEY);
            $data['cle_recuperation_mdp'] = randomString(LONG_CLE_RECUPERATION);
            $data['pseudo'] = self::getPseudo($data['nom'], $data['prenom']);

            $utilisateur = associativeToNumArray($cle_requis, $data);
            
            $stmt = self::$db->prepare(self::$insertUserQuery);
            
            try {
                $stmt->execute($utilisateur);
            } catch (PDOException $e) {
                //header('Location: index.php?module=error&title=Erreur inscription&message=Une erreur est survenue lors de l\'inscription d\'un utilisateur');
            }
        }


        public static function modifierUtilisateur($data, $id)
        {
            $keyList = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance', 'droits', 'pays_naissance', 'code_postal');
            
            $user = associativeToNumArray($keyList, $data);

            //On complète les paramètres avec l'identifiant de l'utilisateur
            array_push($user, $id);

            $stmt = self::$db->prepare(self::$modifyUserQuery);
            
            try {
                $stmt->execute($user);
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur Modification&message=Une erreur est survenue lors de l\'inscription d\'un utilisateur');
            }
        }


        public static function modifierMDPUtilisateur($id, $mdp)
        {
            $stmt = self::$db->prepare(self::$modifyUserPasswordQuery);

            try {
                $stmt->execute(array(crypt($mdp, SALT_KEY), $id));
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public static function supprimerUtilisateur($id)
        {
            $stmt = self::$db->prepare(self::$deleteUserQuery);
            $stmt->bindValue(':id_utilisateur', $id);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title=Erreur suppression&message=Peut être que cet utilisateur n\'existe pas ');
            }
        }




        //Forme le pseudo de l'utilisateur
        //Le pseudo de l'utilisateur est soit constitué des premières lettre du prenom suivi du nom
        //Soit on y ajouter un nombre aléatoire entre 0 et 400.
        public static function getPseudo($nom, $prenom)
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
                return self::getPseudo($nom . rand(0, 400), $prenom);
            }

            return strtolower($pseudo);
        }


        public static function estConnecte()
        {
            return true;
        }
    }
