<?php
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['type'])) {
            define("CONST_INCLUDE", true);

            require_once "../common/Database.php";
            require_once "../common/Response.php";
            require_once "../common/Fonctions.php";

            Database::initConnexion();

            $start = isset($_GET['start']) ? strtolower($_GET['start']) . '%' : Response::send_error(HTTP_BAD_REQUEST, 'Paramètre start est absent');

            $query = null;

            if ($_GET['type'] === 'pseudo') {
                $query = "select pseudo_utilisateur from utilisateur where lower(pseudo_utilisateur) like concat('%',:start) and id_utilisateur not in (select id_utilisateur from personnel)";
            } else {
                Response::send_error(HTTP_BAD_REQUEST, "Ce type de requête est inconnu");
            }


            if ($query) {
                $stmt = Database::getDB()->prepare($query);
        
                $stmt->bindValue(':start', $start);
                
                try {
                    $stmt->execute();
                } catch (PDOException $e) {
                }

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                $stmt->closeCursor();
    
                Response::sendHttpBodyAndExit($result);
            }
        } else {
            Response::send_error(HTTP_BAD_REQUEST, 'Le paramètre type est obligatoire');
        }
    }
