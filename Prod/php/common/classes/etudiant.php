<?php
  require_once __DIR__ . "/../../verify.php";
  require_once __DIR__ . "/../Database.php";
  
  class Etudiant extends Database
  {

      private static $etudiantQuery         = "select * from etudiant where num_etudiant= :num;";

      private static $allStudentsQuery      = "select etudiant.num_etudiant,
                                                nom_utilisateur,
                                                prenom_utilisateur,
                                                coalesce(sum(semestre.points_ets_semestre), 0) as points_ets 
                                                from utilisateur inner join etudiant using(id_utilisateur) 
                                                left join etudie_en using(num_etudiant) 
                                                left join semestre using(ref_semestre) 
                                                group by id_utilisateur, num_etudiant;";

      private static $studentYears          = "select moyenne, ref_semestre, date_debut, date_fin  from etudie_en where num_etudiant = :num";

      private static $insertEtudiantQuery   = "insert into etudiant values(:num, :id_utilisateur);";

      private static $deleteEtudiantQuery   = "delete from etudiant where num_etudiant=:num;";

      private static $updateEtudiantQuery   = "update etudie_en set ref_semestre = :ref where num_etudiant= :num;";


      private static $possibleStudentsQuery = "select id_utilisateur, pseudo_utilisateur from utilisateur 
                                                where id_utilisateur not in (select id_utilisateur from etudiant)"; 
      
      private $num_etudiant;

      private $informations_etudiant;
    
      public function __construct($num_etudiant)
      {
          $stmt = self::$db->prepare(self::$etudiantQuery);
          $stmt->bindValue(":num", $num_etudiant);
          $stmt->execute();
          $result=$stmt->fetch();
          if($result!=null){
            $this->num_etudiant = $num_etudiant;
          }
          else{
            throw new Exception("Etudiant inexistant !");
          }
      }

      public function liste_etudiants() {
        $stmt = self::$db->prepare(self::$allStudentsQuery);
        
          $stmt->execute();

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      public static function ajouter_etudiant($num, $id_utilisateur)
      {
          $stmt = self::$db->prepare(self::$insertEtudiantQuery);

          $stmt->bindValue(':num', $num);

          $stmt->bindValue(':id_utilisateur', $id_utilisateur);

          $stmt->execute();
      }

       public function detailsEtudiant()
      {
          if (!$this->informations_etudiant) {
              $stmt = self::$db->prepare(self::$studentYears);

              $stmt->bindValue(":num", $this->num_etudiant);
  
              $stmt->execute();

              $this->informations_etudiant = $stmt->fetchAll(PDO::FETCH_ASSOC);
          }

          return $this->informations_etudiant;
      }


      public function supprimerEtudiant() {
          $stmt = self::$db->prepare(self::$deleteEtudiantQuery);
          
          $stmt->bindValue(':num', $this->num_etudiant);
          
          $stmt->execute();
      }

      public function modifierEtudiantSemestre($semestre)
      {
          $stmt = self::$db->prepare(self::$updateEtudiantQuery);

          $stmt->bindValue(":num", $this->num_etudiant);
          $stmt->bindValue(":ref", $this->semestre);
      
          $stmt->execute();
      }

      public function UtilisateursPossible(){
          $stmt = self::$db->prepare(self::$possibleStudentsQuery);
    
          $stmt->execute();

          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

  }
