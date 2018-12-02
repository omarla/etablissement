<?php
    require_once __DIR__ . "/../verify.php";

    class ModeleUtilisateur extends Database
    {
        private $debut;

        public function __construct($debut)
        {
            $this->debut = $debut . '%';
        }

        public function getPseudo()
        {
            $requete = "select pseudo_utilisateur from utilisateur where lower(pseudo_utilisateur) like concat('%',:debut) and id_utilisateur not in (select id_utilisateur from personnel)";

            $stmt = self::$db->prepare($requete);
        
            $stmt->bindValue(':debut', $this->debut);
            
            try {
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt->closeCursor();
    
                Response::sendHttpBodyAndExit($result);
            } catch (PDOException $e) {
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des pseudos');
            }
        }

        public function getVille()
        {
            $requete = "select * from ville where lower(nom_ville) like concat('%',:debut)";

            $stmt = self::$db->prepare($requete);
        
            $stmt->bindValue(':debut', $this->debut);
            
            try {
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt->closeCursor();
    
                Response::sendHttpBodyAndExit($result);
            } catch (PDOException $e) {
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des villes');
            }
        }


        public function getPays()
        {
            $requete = "select code_pays, nom_pays from pays where lower(nom_pays) like concat('%', :debut)";

            $stmt = self::$db->prepare($requete);
        
            $stmt->bindValue(':debut', $this->debut);
            
            try {
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt->closeCursor();
    
                Response::sendHttpBodyAndExit($result);
            } catch (PDOException $e) {
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des pays');
            }
        }

        public function getCodePostal()
        {
            $requete = "select * from ville where lower(code_postal_ville) like :debut";

            $stmt = self::$db->prepare($requete);
        
            $stmt->bindValue(':debut', $this->debut);
            
            try {
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt->closeCursor();
    
                Response::sendHttpBodyAndExit($result);
            } catch (PDOException $e) {
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des pays');
            }
        }
    }
