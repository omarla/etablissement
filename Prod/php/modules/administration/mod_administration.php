<?php
    require_once __DIR__ . "/utilisateur/mod_utilisateur.php";

    class ModAdministration
    {
        public function __construct()
        {
            $type = isset($_GET['type']) ? $_GET['type'] : null;

            require_once __DIR__ . "/html/administration-1.php";

            switch ($type) {
                case 'utilisateur':
                    $mod = new ModUtilisateur();
                break;
                
                default:
                    header("Location: index.php?module=error&title=action invalide&message=".INVALID_ACTION_ERROR_MESSAGE);
            }

            require_once __DIR__ . "/html/administration-2.html";
        }
    }
