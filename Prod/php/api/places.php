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
            if ($_GET['type'] === 'ville') {
                $query = "select * from Ville where lower(nom_ville) like concat('%',:start)";
            } elseif ($_GET['type'] === 'pays') {
                $query = "select code_pays, nom_pays from pays where lower(nom_pays) like concat('%', :start)";
            } elseif ($_GET['type'] === 'code_postal') {
                $query = "select * from Ville where lower(code_postal_ville) like :start";
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
