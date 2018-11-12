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
                print_r($row);
            } catch (PDOException $e) {
                header('Location: index.php?module=error&title='.DATABASE_ERROR_TITLE.'&message='.DATABASE_ERROR_MESSAGE);
            }
        }
    
        public function sign_in($utilisateur, $personnel, $enseignant, $etudiant)
        {
        }
    }
