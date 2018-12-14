<?php
    require_once __DIR__ . "/cont_module.php";
    require_once __DIR__ . "/../../../verify.php";

    class ModModule
    {
        public function __construct()
        {
            $action = isset($_GET['action']) ? $_GET['action'] : null;
            $cont = new ContModule();

            switch ($action) {
                case 'liste_modules':
                    $cont->liste_modules();
                break;
                default:
                    header('Location: index.php?module=administration&type=module&action=liste_modules');
                break;

            }
        }
    }
