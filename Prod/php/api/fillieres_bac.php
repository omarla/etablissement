<?php
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        define("CONST_INCLUDE", true);

        require_once "../common/Database.php";
        require_once "../common/Response.php";
        require_once "../common/Fonctions.php";

        Database::initConnexion();

        $query = "select * from filliere_bac order by nom_filliere_bac";

        $stmt = Database::getDB()->prepare($query);

        
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            Response::send_error(INTERNAL_SERVER_ERROR_CODE, "Erreur survenu au niveau de la base de données");
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        Response::sendHttpBodyAndExit($result);
    }
