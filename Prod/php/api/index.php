<?php
define('CONST_INCLUDE', true);

require_once __DIR__ . "/../common/Response.php";
require_once __DIR__ . "/../common/Fonctions.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once __DIR__ . "/../common/Database.php";
    require_once __DIR__ . "/utilisateur/mod_utilisateur_api.php";
    require_once __DIR__ . "/groupe/mod_groupe_api.php";
    require_once __DIR__ . "/semestre/mod_semestre_api.php";

    Database::initConnexion();

    $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : die('Erreur type');

    $mod = null;

    switch ($type) {
        case 'utilisateur':
            $mod = new ModUtilisateurAPI();
        break;

        case 'groupe':
            $mod = new ModGroupeAPI();
        break;

        case 'semestre':
            $mod = new ModSemestreAPI();
        break;
    }
} else {
    Response::send_error(HTTP_BAD_REQUEST, 'Le paramètre type est obligatoire');
}
