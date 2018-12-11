<?php
    require_once __DIR__ . "/utilisateur/mod_utilisateur.php";
    require_once __DIR__ . "/droits/mod_droits.php";
    require_once __DIR__ . "/groupe/mod_groupe.php";
    require_once __DIR__ . "/semestre/mod_semestre.php";
    require_once __DIR__ . "/vue_administration.php";
    class ModAdministration
    {
        public function __construct()
        {
            $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : null;

            $vue = new VueAdministration($type);

            switch ($type) {
                case 'utilisateur': case 'personnel':
                    $mod = new ModUtilisateur();
                break;

                case 'droits':
                    $mod = new ModDroits();
                break;

                case 'groupe':
                    $mod = new ModGroupe();
                break;

                case 'semestre':
                    $mod = new ModSemestre();
                break;
                
                default:
                    header("Location: index.php?module=error&title=Action invalide&message=".INVALID_ACTION_ERROR_MESSAGE);
                    exit(0);
            }

            require_once __DIR__ . "/html/administration-2.html";
        }
    }
