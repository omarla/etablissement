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
                echo $e->getMessage();
            }
        }


        public function getSemestre($id)
        {
            try {
                $semestre = new Semestre($id);

                //Initialisation
                $semestre->detailsSemestre();
                $semestre->anneesSemestre();
                $semestre->etudiantsSemestre();
            
                return $semestre;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function annee_courante()
        {
            return self::getDBYear();
        }
    }
