<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/Database.php";
    require_once __DIR__ . "/../../../common/classes/groupe.php";
    require_once __DIR__ . "/../../../common/classes/droits.php";

    class ModeleGroupe extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }

        public function getListeGroupes()
        {
            try{
                return Groupe::getListeGroupes();
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû récupérer la liste des groupes. Veuillez réessayer plus tard");
            }
        }

        public function getListeDroits()
        {
            try{
                $liste_droits = array();

                foreach (Droits::getListeDroits() as $droits) {
                    array_push($liste_droits, $droits['nom_droits']);
                }
    
                return $liste_droits;    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû récupérer la liste des droits. Veuillez réessayer plus tard");
            }
        }

        public function ajouterGroupe($nom, $droits)
        {
            try{
                Groupe::ajouterGroupe($nom, $droits);
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû créer ce groupe.");   
            }
        }

        public function detailsGroupe($id_groupe)
        {
            try{
                $groupe = new Groupe($id_groupe);

                return $groupe;    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Aucune information sur ce groupe n'a été retrouvée : " . $id_groupe );
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Ce groupe n'existe pas");
            }
        }


        public function retirerUtilisateur($id_utilisateur, $id_groupe)
        {
            try{
                $groupe = new Groupe($id_groupe);
                $groupe->retirerUtilisateur($id_utilisateur);    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Attention, cet utilisateur n'a pas été retiré du groupe : " . $id_utilisateur );
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Ce groupe n'existe pas");
            }
        }

        public function retirerSousGroupe($sous_groupe, $id_groupe)
        {
            try{
                $groupe = new Groupe($id_groupe);
                $groupe->retirerSousGroupe($sous_groupe);    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Attention, ce sous-groupe n'a pas été supprimé : " . $id_groupe );
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Ce groupe n'existe pas");
            }
        }

        public function ajouterSousGroupe($sous_groupe, $id_groupe)
        {
            try{
                $groupe = new Groupe($id_groupe);
                $groupe->ajouterSousGroupe($sous_groupe);    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Attention, Nous n'avons pas pû ajouter ce sous_groupe ${sous_groupe} au groupe ${id_groupe}");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Ce groupe n'existe pas");
            }
        }

        public function ajouterUtilisateur($id_utilisateur, $id_groupe)
        {
            try{
                $groupe = new Groupe($id_groupe);
                $groupe->ajouterUtilisateur($id_utilisateur);    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Attention, Nous n'avons pas pû ajouter cet utilisateur ${id_utilisateur} au groupe ${id_groupe}");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Ce groupe n'existe pas");
            }
        }



        public function supprimerGroupe($id_groupe){
            try{
                $groupe = new Groupe($id_groupe);
                $groupe->supprimer();    
            }catch(PDOException $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Attention, Nous n'avons pas supprimer ce groupe ${id_groupe}");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Ce groupe n'existe pas");
            }
        }
    }
