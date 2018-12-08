<?php
  require_once "php/verify.php";
  require_once "php/common/Database.php";
  
  class Semestre extends Database
  {
      private static $semestreQuery         = "select * from semestre where ref_semestre = :ref";


      private static $semestreYearsQuery    = "select ref_semestre, 
                                                avg(moyenne),
                                                sum(case when est_valide = 1 then 1 else 0 end) as nombre_reussite,
                                                sum(case when est_valide = 0 then 1 else 0 end) as nombre_echoue,
                                                sum(case when est_valide = 1 then 1 else 0 end) / count(ref_semestre) as taux_reussite,
                                                sum(case when est_valide = 0 then 1 else 0 end) / count(ref_semestre) as taux_echoue
                                                from etudie_en 
                                                where ref_semestre = :ref
                                                group by ref_semestre, annee
                                                order by annee desc";

      private static $semestreStudents      = "select annee, etudiant.num_etudiant, nom_utilisateur, prenom_utilisateur, moyenne
                                                from etudie_en inner join etudiant on (etudie_en.num_etudiant = etudiant.num_etudiant)
                                                inner join utilisateur on (utilisateur.id_utilisateur = etudiant.id_utilisateur)
                                                where ref_semestre = :ref 
                                                order by annee desc
                                                ";

      private static $allSemestresQuery     = "select semestre.*, 
                                                sum(case when est_valide = 1 then 1 else 0 end) as nombre_reussite,
                                                sum(case when est_valide = 0 then 1 else 0 end) as nombre_echoue
                                                from semestre left join etudie_en on(semestre.ref_semestre = etudie_en.ref_semestre)
                                                group by ref_semestre
                                                ";

      private static $insertSemestreQuery = "insert into semestre values(:ref, :nom, :pts_ets)";


      private static $deleteSemestreQuery = "delete from semestre where ref_semestre = :ref";


      private $ref_semestre;
      private $informations_semestre;
      private $anneesSemestre;
      private $etudiantsSemestre;
    
      public function __construct($ref_semestre)
      {
          $this->ref_semestre = $ref_semestre;
      }

      public function detailsSemestre()
      {
          if (!$this->informations_semestre) {
              $stmt = self::$db->prepare(self::$semestreQuery);

              $stmt->bindValue(":ref", $this->ref_semestre);
  
              $stmt->execute();

              $this->informations_semestre = $stmt->fetch(PDO::FETCH_ASSOC);
          }

          return $this->informations_semestre;
      }


      public function anneesSemestre()
      {
          if (!$this->anneesSemestre) {
              $stmt = self::$db->prepare(self::$semestreYearsQuery);

              $stmt->bindValue(":ref", $this->ref_semestre);
            
              $stmt->execute();

              $this->anneesSemestre = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }

          return $this->anneesSemestre;
      }

      public function etudiantsSemestre()
      {
          if (!$this->etudiantsSemestre) {
              $stmt = self::$db->prepare(self::$semestreStudents);

              $stmt->bindValue(":ref", $this->ref_semestre);
            
              $stmt->execute();

              $this->etudiantsSemestre = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }

          return $this->etudiantsSemestre;
      }



      public function supprimerSemestre()
      {
          $stmt = self::$db->prepare(self::$deleteSemestreQuery);
          
          $stmt->bindValue(':ref', $this->ref);
          
          $stmt->execute();
      }

      public static function liste_semestres()
      {
          $stmt = self::$db->prepare(self::$allSemestresQuery);
        
          $stmt->execute();

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }


      public static function ajouter_semestre($ref, $nom, $points_ets)
      {
          $stmt = self::$db->prepare(self::$insertSemestreQuery);

          $stmt->bindValue(':ref', $ref);
          $stmt->bindValue(':nom', $nom);
          $stmt->bindValue(':pts_ets', $points_ets);

          $stmt->execute();
      }
  }
