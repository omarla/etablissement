<?php
    require_once "php/verify.php";
    require_once __DIR__ . "/vue_connexion.php";
    require_once __DIR__ . "/modele_connexion.php";

    class ContConnexion
    {
        private $vue;
        private $modele;
        
        public function __construct()
        {
            $this->vue = new VueConnexion();
            $this->modele = new ModeleConnexion($this);
        }

        public function afficherConnexion()
        {
            if (!Utilisateur::estConnecte()) {
                $this->vue->afficherConnexion();
            } else {
                echo "<script>alert('Vous êtes déjà connecte')</script>";
            }
        }

        public function seConnecter()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = isset($_POST['username']) ? $_POST['username'] : $this->setError(UNDEFINED_USERNAME_ERROR);
                $password = isset($_POST['password']) ? $_POST['username'] : $this->setError(UNDEFINED_PASSWORD_ERROR);

                $this->modele->connect($username, $password);
            }
        }

        public function setError($message)
        {
            $_SESSION['connexion']['error'] = $message;
        }
    }
