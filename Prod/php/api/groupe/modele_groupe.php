<?php
    require_once __DIR__ . "/../verify.php";

    class ModeleGroupe extends Database
    {
        private $debut;
        private $id_groupe;

        public function __construct($id_groupe, $debut)
        {
            $this->debut = $debut . '%';
            $this->id_groupe = $id_groupe;
        }

        public function getUtilisateurs()
        {
            $requete = "select pseudo_utilisateur, id_utilisateur from utilisateur 
                        where id_utilisateur not in (select id_utilisateur from membres_de_groupe where id_groupe = :id_groupe)
                        and lower(pseudo_utilisateur) like :debut";
        
            $stmt = self::$db->prepare($requete);

            $stmt->bindValue(':debut', $this->debut);
            $stmt->bindValue(':id_groupe', $this->id_groupe);

            try {
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt->closeCursor();
    
                Response::sendHttpBodyAndExit($result);
            } catch (PDOException $e) {
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des utilisateur appartenant à ce groupe');
            }
        }


        //Renvoie la liste des groupes commencant par debut
        //et qui ne sont pas parent du groupe défini par son id
        public function getSousGroupes()
        {
            $requete = "select id_groupe, nom_groupe from groupe 
                        where est_un_sous_groupe(:id_groupe, id_groupe) = 0 and id_groupe != :id_groupe
                        and lower(nom_groupe) like :debut";
        
            $stmt = self::$db->prepare($requete);

            $stmt->bindValue(':debut', $this->debut);
            $stmt->bindValue(':id_groupe', $this->id_groupe);

            try {
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt->closeCursor();
    
                Response::sendHttpBodyAndExit($result);
            } catch (PDOException $e) {
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des sous_groupes appartenant à ce groupe');
            }
        }
    }
