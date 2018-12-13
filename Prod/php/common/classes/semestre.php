<?php
  require_once __DIR__ . "/../../verify.php";
  require_once __DIR__ . "/classe_generique.php";
  
  class Semestre extends ClasseGenerique
  {
      private static $semestreQuery         = "select * from semestre where ref_semestre = :ref";


      private static $semestreYearsQuery    = "select date_debut::varchar || ' => ' || date_fin::varchar as annee, 
                                                avg(moyenne) as moyenne,
                                                sum(case when est_valide then 1 else 0 end) as nombre_reussite,
                                                sum(case when not est_valide then 1 else 0 end) as nombre_echecs,
                                                round(sum(case when est_valide then 1 else 0 end) / count(ref_semestre), 2) as taux_reussite,
                                                round(sum(case when not est_valide then 1 else 0 end) / count(ref_semestre), 2) as taux_echecs
                                                from etudie_en 
                                                where ref_semestre = :ref
                                                group by ref_semestre, date_debut::varchar || ' => ' || date_fin::varchar
                                                order by annee desc";

      private static $semestreStudents      = "select date_debut::varchar || ' => ' || date_fin::varchar as annee, etudiant.num_etudiant, nom_utilisateur, prenom_utilisateur, moyenne
                                                from etudie_en inner join etudiant using(num_etudiant)
                                                inner join utilisateur using (id_utilisateur)
                                                where ref_semestre = :ref 
                                                order by annee desc
                                                ";

      private static $allSemestresQuery     = "select semestre.*, 
                                                sum(case when est_valide then 1 else 0 end) as nombre_reussite,
                                                sum(case when not est_valide then 1 else 0 end) as nombre_echoue
                                                from semestre left join etudie_en using(ref_semestre)
                                                group by ref_semestre
                                                ";

      private static $insertSemestreQuery   = "insert into semestre values(:ref, :nom, :pts_ets, :periode)";


      private static $updateSemestreQuery   = "update semestre set nom_semestre = :nom, points_ets_semestre = :pts_ets where ref_semestre = :ref";


      private static $deleteStudentQuery    = "delete from etudie_en where ref_semestre = :ref and num_etudiant = :num_etudiant and date_debut = :debut";

      private static $deleteSemestreQuery   = "delete from semestre where ref_semestre = :ref";




      private $ref_semestre;
      private $informations_semestre;
      private $anneesSemestre;
      private $etudiantsSemestre;
    
      public function __construct($ref_semestre)
      {
          parent::__construct(self::$semestreQuery,array(":ref"=>$ref_semestre));
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


      public function modifierSemestre($nom, $pts_ets)
      {
          $stmt = self::$db->prepare(self::$updateSemestreQuery);

          $stmt->bindValue(":ref", $this->ref_semestre);
          $stmt->bindValue(":nom", $nom);
          $stmt->bindValue(":pts_ets", $pts_ets);
      
          $stmt->execute();
      }

      public function retirerEtudiant($num_etudiant)
      {
          $stmt = self::$db->prepare(self::$deleteStudentQuery);

          $stmt->bindValue(":ref", $this->ref_semestre);
          $stmt->bindValue(":num_etudiant", $num_etudiant);
          $stmt->bindValue(":debut", explode(" => ",self::getDBYear())[0]);
          
          $stmt->execute();
      }



      public function supprimerSemestre()
      {
          $stmt = self::$db->prepare(self::$deleteSemestreQuery);
          
          $stmt->bindValue(':ref', $this->ref_semestre);
          
          $stmt->execute();
      }

      public static function liste_semestres()
      {
          $stmt = self::$db->prepare(self::$allSemestresQuery);
        
          $stmt->execute();

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }


      public static function ajouter_semestre($ref, $nom, $points_ets, $periode)
      {
          $stmt = self::$db->prepare(self::$insertSemestreQuery);

          $stmt->bindValue(':ref', $ref);
          $stmt->bindValue(':nom', $nom);
          $stmt->bindValue(':pts_ets', $points_ets);
          $stmt->bindValue(':periode', $periode);

          $stmt->execute();
      }
  }
