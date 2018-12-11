<?php
    require_once __DIR__ ."/../../../verify.php";
    require_once __DIR__ ."/../../../common/Database.php";
    require_once __DIR__ ."/../../../common/classes/user/utilisateur.php";
    require_once __DIR__ ."/../../../common/classes/user/personnel.php";
    require_once __DIR__ ."/../../../common/classes/user/enseignant.php";
    require_once __DIR__ ."/../../../common/classes/droits.php";

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
            try{
                return Utilisateur::getListeUtilisateurs();
            }catch(PDOException $e) {
               $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû récupérer la liste des utilisateur. Veuillez réessayer plus tard");
            }
        }


        public function getUtilisateur($param)
        {
            try{
                $utilisateur = new Utilisateur($param, $param);
                return $utilisateur->informations_utilisateur();
            }catch(PDOException $e){                
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû récupérer cet utilisateur. Veuillez réessayer plus tard");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Cet utilisateur est introuvable");
            }
        }


        public function insertUser($data)
        {
            try{
                $data['pays_naissance'] =  $this->getCodePays($data['pays_naissance']);
                Utilisateur::insertUser($data);    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû insérer cet utilisateur.");
            }
        }

        public function modifierUtilisateur($data, $id)
        {
            
            $data['pays_naissance'] =  $this->getCodePays($data['pays_naissance']);
            try{
                $utilisateur = new Utilisateur($id, $id);

                $utilisateur->modifierUtilisateur($data);
                if (strlen($data['mot_de_passe']) > 3) {
                    $utilisateur->modifierMDPUtilisateur($data['mot_de_passe']);
                }    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "La modification de l'utilisateur " . $id . " a échouée");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Cet utilisateur est introuvable");
            }
        }

        public function supprimerUtilisateur($id)
        {
            try{
                $utilisateur = new Utilisateur($id, $id);
                $utilisateur->supprimerUtilisateur();
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Attention, cet utilisateur n'a pas été supprimé.");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Cet utilisateur est introuvable");
            }
        }




        /****************************************************************************************************/
        /***************************************Fin Utilisateurs**********************************************/
        /****************************************************************************************************/


        /****************************************************************************************************/
        /*******************************************PERSONNEL**********************************************/
        /****************************************************************************************************/

        public function getListePersonnels()
        {
            try{
                return Personnel::getListePersonnels();
            }catch(Exception $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Erreur lors de la récupération de la liste du personnel");
            }
        }

        public function getPersonnel($id)
        {
            try{
                $personnel = new Personnel($id);
                return $personnel->informations_personnel();
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Erreur lors du chargement des données du personnel n° " . $id);
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Aucun personnel n'a cet identifiant");
            }
        }


        public function ajouterPersonnel($pseudo, $estEnseignant)
        {

            self::$db->beginTransaction();

            try{
                $utilisateur = new Utilisateur('', $pseudo);
            
                Personnel::ajouterPersonnel($utilisateur->getIdUtilisateur());
                
                if ($estEnseignant) {
                    $id_personnel = self::getLastInsertId();
                    Enseignant::ajouterEnseignant($id_personnel);
                }
    
                self::$db->commit();    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Attention ce personnel n'a pas été ajouté : Pseudo = " . $pseudo);
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Cet utilisateur est introuvable");
            }

        }

        public function modifierPersonnel($id_personnel, $est_enseignant, $heures_travail)
        {
            self::$db->beginTransaction();

            try{
                $personnel = new Personnel($id_personnel);

                $informations_personnel = $personnel->informations_personnel();

                $personnel->modifierHeuresTravail($heures_travail);
    
                if (null === $informations_personnel['id_enseignant'] && $est_enseignant) {
                    Enseignant::ajouterEnseignant($id_personnel);
                } elseif (null !== $informations_personnel['id_enseignant'] && !$est_enseignant) {
                    Enseignant::supprimerEnseignant($id_personnel);
                }
                self::$db->commit();    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "La modification de ce personnel a échouée. Veuillez réessayer plus tard" );
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Aucun personnel ne porte cet identifiant");
            }
            
        }

        public function supprimerPersonnel($id_personnel)
        {
            try{
                $personnel = new Personnel($id_personnel);
                Enseignant::supprimerEnseignant($id_personnel);
                $personnel->supprimerPersonnel();    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "La suppression de ce personnel a échouée. Veuillez réessayer plus tard");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Aucun personnel ne porte cet identifiant");
            }
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

            try{
                foreach (Droits::getListeDroits() as $droits) {
                    array_push($liste_droits, $droits['nom_droits']);
                }    
            }catch(Exception $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Impossible de récupérer la liste des droits possibles");   
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
            } catch (Exception $e) {
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Le code pays est érronée");   
            }

            if($result == null)
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Le code pays est érronée");   
            
            return $result;
        }
    }
