<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    class ModeleConnexion extends Database
    {
        private const connect_query = 'select connect_user(:username, :password)';
        private $cont;

        public function __construct($cont)
        {
            $this->cont = $cont;
        }

        public function connect($username, $password)
        {
            $stmt = self::$db->prepare(self::connect_query);

            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);

            try {
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->handleError($e->errorInfo[1]);
                header('Location: index.php?module=connexion&action=afficherConnexion');
            }
        }
    
        public function handleError($error_code)
        {
            $_SESSION['erreur']['connexion'] = ERROR_MESSAGE_USING_SQL_CODE[$error_code];
        }

        public function sign_in($utilisateur, $personnel, $enseignant, $etudiant)
        {
        }
    }
