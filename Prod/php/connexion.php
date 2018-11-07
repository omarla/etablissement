<?php
	if(!defined('CONST_INCLUDE'))
		die('Acces direct interdit !');

	class Connexion{
		protected static $db = null;

		public function __construct(){

		}

		public static function initConnexion(){
			if(self::$db == null){
				try{
					$dsn = "mysql:host=database-etudiants.iut.univ-paris8.fr;dbname=dutinfopw201622";
					
					$username = "dutinfopw201622";
					$password = "najymahe";

					self::$db = new PDO($dsn,$username,$password);
					self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				}catch(PDOException $e){
					die("Connexion refusée");
				}
			}

		}


	}

?>