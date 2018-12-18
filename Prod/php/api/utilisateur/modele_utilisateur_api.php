<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "/../../common/classes/module.php";

    class ModeleUtilisateurAPI extends Database
    {

        public function __construct()
        {
        }

        public function getPseudoPersonnels()
        {
            $requete = "select lower(pseudo_utilisateur) as pseudo from utilisateur where id_utilisateur not in(select id_utilisateur from personnel)";

            $stmt = self::$db->prepare($requete);
                    
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
            $requete = "select nom_ville, code_postal_ville from ville ";

            $stmt = self::$db->prepare($requete);
            
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
            $requete = "select code_pays, nom_pays  from pays ";

            $stmt = self::$db->prepare($requete);
                    
            try {
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt->closeCursor();

                Response::sendHttpBodyAndExit($result);
            } catch (PDOException $e) {
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des pays');
            }
        }


        public function getEnseignantsModule($ref_module){
            try{
                $module = new Module($ref_module);
                
                $result = $module->getEnseignantsAAjouter();

                Response::sendHttpBodyAndExit($result);
            }catch(PDOException $e){
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération de la liste des enseignants');
            }catch(ElementIntrouvable $e){
                Response::send_error(HTTP_BAD_REQUEST, "Ce module n'éxiste pas");
            }
        } 
    }
