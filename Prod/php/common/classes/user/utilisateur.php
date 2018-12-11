<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../classe_generique.php";
    
    class Utilisateur extends ClasseGenerique
    {
        private static $userListQuery           = 'select * from utilisateur';
        
        private static $userQuery               = 'select * from utilisateur 
                                                    left join ville on (utilisateur.code_postal_ville = ville.code_postal_ville)
                                                    left join pays on (utilisateur.code_pays = pays.code_pays) where id_utilisateur = :id_utilisateur';

        private static $pseudoToIdQuery         = 'select id_utilisateur from utilisateur where pseudo_utilisateur = :pseudo';
    
    
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
    
        private $id_utilisateur;
        private $informations_utilisateur;


        public function __construct($id_utilisateur = "", $pseudo_utilisateur = ""){

            $requete = "select * from utilisateur where id_utilisateur = ?";

            if(!is_numeric($id_utilisateur)){
                $id_utilisateur = self::pseudoEnIdUtilisateur($pseudo_utilisateur);
            }

            parent::__construct($requete, array($id_utilisateur));
        
            $this->id_utilisateur = $id_utilisateur;
        }   

        public function informations_utilisateur(){
            if(!$this->informations_utilisateur){
                $stmt = self::$db->prepare(self::$userQuery);
            
                $stmt->bindValue('id_utilisateur',$this->id_utilisateur);
                
                $stmt->execute();
                
                $this->informations_utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            return $this->informations_utilisateur;
        }

        public function getIdUtilisateur(){
            return $this->id_utilisateur;
        }

        public function modifierUtilisateur($data)
        {
            $keyList = array('email','nom', 'prenom', 'tel', 'addresse', 'est_homme', 'date_naissance', 'droits', 'pays_naissance', 'code_postal');
            
            $user = associativeToNumArray($keyList, $data);

            //On complète les paramètres avec l'identifiant de l'utilisateur
            array_push($user, $this->id_utilisateur);

            $stmt = self::$db->prepare(self::$modifyUserQuery);
            
            $stmt->execute($user);
        }



        public function modifierMDPUtilisateur($mdp)
        {
            $stmt = self::$db->prepare(self::$modifyUserPasswordQuery);

            $stmt->execute(array(crypt($mdp, SALT_KEY), $this->id_utilisateur));
        }




        public function supprimerUtilisateur()
        {
            $stmt = self::$db->prepare(self::$deleteUserQuery);
            $stmt->bindValue(':id_utilisateur', $this->id_utilisateur);
            $stmt->execute();
        }











        //Renvoie la liste des utilisateurs
        public static function getListeUtilisateurs()
        {
            $stmt = self::$db->prepare(self::$userListQuery);
            
            $liste_utilisateurs = array();

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

            return $liste_utilisateurs;
        }


        //Renvoie l'utilisateur correspondant au pseudo envoyé $pseudo
        private static function pseudoEnIdUtilisateur($pseudo)
        {
            $stmt = self::$db->prepare(self::$pseudoToIdQuery);

            $stmt->bindValue(":pseudo", $pseudo);

            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result != null)
                return $result['id_utilisateur'];
            else
                return null;
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
            
            $stmt->execute($utilisateur);
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
