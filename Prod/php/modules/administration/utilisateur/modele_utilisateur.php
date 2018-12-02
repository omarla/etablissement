<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    require_once "php/common/classes/user/utilisateur.php";
    require_once "php/common/classes/user/personnel.php";
    require_once "php/common/classes/user/enseignant.php";
    require_once "php/common/classes/droits.php";

    class ModeleUtilisateur extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }


        /****************************************************************************************************/
        /*******************************************Utilisateurs**********************************************/
        /****************************************************************************************************/
        
        public function getListeUtilisateurs()
        {
            return Utilisateur::getListeUtilisateurs();
        }


        public function getUtilisateur($param)
        {
            if (is_numeric($param)) {
                return Utilisateur::getUtilisateurParId($param);
            } else {
                return Utilisateur::getUtilisateurParPseudo($param);
            }
        }


        public function insertUser($data)
        {
            $data['pays_naissance'] =  $this->getCodePays($data['pays_naissance']);
            Utilisateur::insertUser($data);
            header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');
        }

        public function modifierUtilisateur($data, $id)
        {
            $data['pays_naissance'] =  $this->getCodePays($data['pays_naissance']);
            
            Utilisateur::modifierUtilisateur($data, $id);

            if (strlen($data['mot_de_passe']) > 3) {
                Utilisateur::modifierMDPUtilisateur($id, $data['mot_de_passe']);
            }

            header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');
        }

        public function supprimerUtilisateur($id)
        {
            Utilisateur::supprimerUtilisateur($id);
            header('Location: index.php?module=administration&type=utilisateur&action=liste_utilisateurs');
        }




        /****************************************************************************************************/
        /***************************************Fin Utilisateurs**********************************************/
        /****************************************************************************************************/


        /****************************************************************************************************/
        /*******************************************PERSONNEL**********************************************/
        /****************************************************************************************************/

        public function getListePersonnels()
        {
            return Personnel::getListePersonnels();
        }

        public function getPersonnel($id)
        {
            return Personnel::getPersonnel($id);
        }


        public function ajouterPersonnel($pseudo, $estEnseignant)
        {
            self::$db->beginTransaction();

            $utilisateur = Utilisateur::getUtilisateurParPseudo($pseudo);
            
            Personnel::ajouterPersonnel($utilisateur);
            
            if ($estEnseignant) {
                $id_personnel = self::getLastInsertId();
                
                Enseignant::ajouterEnseignant($id_personnel);
            }

            self::$db->commit();

            header('Location: index.php?module=administration&type=utilisateur&action=liste_personnels');
        }

        public function modifierPersonnel($id_personnel, $est_enseignant, $heures_travail)
        {
            self::$db->beginTransaction();

            $personnel = Personnel::getPersonnel($id_personnel);
           
            Personnel::modifierHeuresTravail($id_personnel, $heures_travail);

            if (null === $personnel['id_enseignant'] && $est_enseignant) {
                Enseignant::ajouterEnseignant($id_personnel);
            } elseif (null !== $personnel['id_enseignant'] && !$est_enseignant) {
                Enseignant::supprimerEnseignant($id_personnel);
            }

            self::$db->commit();
            
            header('Location: index.php?module=administration&type=utilisateur&action=liste_personnels');
        }

        public function supprimerPersonnel($id_personnel)
        {
            Enseignant::supprimerEnseignant($id_personnel);
            Personnel::supprimerPersonnel($id_personnel);
        }


        /****************************************************************************************************/
        /****************************************FIN PERSONNEL**********************************************/
        /****************************************************************************************************/


        
        /****************************************************************************************************/
        /****************************************DROITS***********************************************/
        /****************************************************************************************************/

        public function getListeDroits()
        {
            $liste_droits = array();

            foreach (Droits::getListeDroits() as $droits) {
                array_push($liste_droits, $droits['nom_droits']);
            }

            return $liste_droits;
        }
  

        /****************************************************************************************************/
        /****************************************FIN DROITS**********************************************/
        /****************************************************************************************************/
    
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
    }
