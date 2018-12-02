<?php
    require_once __DIR__ . "/../verify.php";

    define('HTTP_BAD_REQUEST', 400);
    define('INTERNAL_SERVER_ERROR_CODE', 500);
    define('PARAM_ERROR_MESSAGE', 'Les paramètres envoyés sont incorrects ou incomplets');
    define('REQUEST_METHOD_ERROR_MESSAGE', "Le type de requête utilisé n'est pas pris en charge par cette page");
    define('REQUEST_TYPE_ERROR_MESSAGE', 'Veuillez indiquer le but de la requête');

    class Response
    {

        /*
        * Envoie une erreur au client et arrête tous les traitements en cours sur le serveur
        */
        public static function send_error($error_Code, $message, PDO $db = null, $file = null) : void
        {
            if ($db && $db->inTransaction()) {
                $db->rollback();
            }

            if ($file) {
                $file->destroy();
            }

            http_response_code($error_Code);
            echo $message;

            exit(1);
        }

        /*
        * Envoie un réponse positive au client
        */
        public static function sendHttpBodyAndExit($body = null)
        {
            http_response_code(200);
            echo json_encode($body);
            exit(0);
        }


        /*
        * Envoie un fichier au client pour le télécharger
        * Envoie une erreur si le fichier n'éxiste pas
        */
        public static function sendCsvFileAndExit($file, $filename)
        {
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename=' . $filename . ".csv");
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                flush();
                readfile($file);
                exit;
            } else {
                self::send_error(INTERNAL_SERVER_ERROR_CODE, "Erreur lors de l'envoie du fichier");
            }
        }
    }
