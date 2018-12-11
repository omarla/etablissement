<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/classes/semestre.php";
    require_once __DIR__ . "/../../../common/Database.php";

    class ModeleSemestre extends Database
    {
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }

        public function liste_semestres()
        {
            try {
                return Semestre::liste_semestres();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }


        public function ajouter_semestre($ref, $nom, $points_ets)
        {
            try {
                Semestre::ajouter_semestre($ref, $nom, $points_ets);
            } catch (PDOException $e) {
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Erreur lors de la récupération de la liste des semestres");
            }
        }


        public function getSemestre($id)
        {
            try {
                $semestre = new Semestre($id);

                $semestre->detailsSemestre();
                $semestre->anneesSemestre();
                $semestre->etudiantsSemestre();
            
                return $semestre;
            } catch (PDOException $e) {
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Erreur lors de la récupération des données du semestre");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur("Semestre inéxistant", "Il n'existe aucun semestre avec la référence ". $id);
            }
        }

        public function annee_courante()
        {
            return self::getDBYear();
        }

        public function modifier_semestre($ref, $nom, $pts_ets)
        {
            try {
                $semestre = new Semestre($ref);
                $semestre->modifierSemestre($nom, $pts_ets);
            } catch (PDOException $e) {
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Erreur lors de la modification du semestre : ". $ref);
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur("Semestre inéxistant", "Il n'existe aucun semestre avec la référence ". $id);
            }
        }

        public function retirer_etudiant($ref, $num_etudiant)
        {
            try {
                $semestre = new Semestre($ref);
                $semestre->retirerEtudiant($num_etudiant);
            } catch (PDOException $e) {
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû retirer l'étudiant " .$num_etudiant . " de la liste des étudiants de cette année");
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur("Semestre inéxistant", "Il n'existe aucun semestre avec la référence ". $id);
            }
        }


        public function supprimer_semestre($ref)
        {
            try {
                $semestre = new Semestre($ref);
                $semestre->supprimerSemestre();
            } catch (PDOException $e) {
                $this->cont->afficherErreur(DEFAULT_ERROR_TITLE, "Nous n'avons pas pû supprimer le semestre : " .$ref);
            }catch(ElementIntrouvable $e){
                $this->cont->afficherErreur("Semestre inéxistant", "Il n'existe aucun semestre avec la référence ". $id);
            }
        }
    }
