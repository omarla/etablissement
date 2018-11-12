<?php
    require_once "php/verify.php";
    require_once "php/common/Database.php";
    class ModeleConnexion extends Database
    {
        private const connect_query = 'select connect_user(:username, :password)';

        public function __construct()
        {
        }

        public function connect($username, $password)
        {
            $stmt = self::$db->prepare(connect_query);

            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
            }
        }
    
        public function sign_in($utilisateur, $personnel, $enseignant, $etudiant)
        {
        }
    }
