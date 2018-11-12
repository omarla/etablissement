<?php
    require_once "php/verify.php";
    require_once __DIR__ . "/vue_connexion.php";
    require_once __DIR__ . "/modele_connexion.php";

    class ModeleConnexion
    {
        private $vue;
        private $modele;
        
        public function __construct()
        {
            $this->vue = new VueConnexion();
            $this->modele = new ModeleConnexion();
        }

        public function connect($username, $password)
        {
            $stmt = self::$db->prepare($connect_query);

            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $password);

            try {
                $stmt->execute();
            } catch (PDOException $e) {
            }
        }
    }
