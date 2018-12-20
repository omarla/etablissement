<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/classes/etudiant.php";
    require_once __DIR__ . "/../../../common/Database.php";

    class ModeleEtudiant extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }

        public function liste_etudiants()
        {
            try {
                return Etudiant::liste_etudiants();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function ajouter_etudiant($num, $id_utilisateur)
        {
            try {
                Etudiant::ajouter_etudiant($num, $id_utilisateur);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function supprimer_etudiant($num)
        {
            try {
                $etudiant = new Etudiant($num);
                $etudiant->supprimerEtudiant();
            } catch (PDOException $e) {
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû supprimer l'étudiant : " .$num);
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur("Etudiant inexistant", "Il n'existe aucun étudiant avec le numéro ". $num);
            }
        }


        public function getEtudiant($num)
        {
            try {
                $etudiant = new Etudiant($num);

                //Initialisation
                $etudiant->detailsEtudiant();
            
                return $etudiant;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
