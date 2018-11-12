<?php
    session_start();
    if (isset($_SESSION['historique'])) {
        array_unshift($_SESSION['historique'], "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    } else {
        $_SESSION['historique'] = array(
            "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
        );
    }
    
    define("CONST_INCLUDE", true);
    require_once "php/common/Constants.php";
    require_once "php/common/user/utilisateur.php";
?>
<!DOCTYPE html>
<html>
<head>
	
	<title>Etablissement</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet"  type="text/css">
	<link href="css/page-externe.css" rel="stylesheet" type="text/css"> 
	<link href="css/menu-externe.css" rel="stylesheet" type="text/css">
	<link href="css/connexion.css" type="text/css" rel="stylesheet">
	<link href="css/menu-interne.css" rel="stylesheet" type="text/css" >
	<link href="css/administration.css" rel="stylesheet" type="text/css" >


</head>
<body>

	<?php
        $module = isset($_GET['module']) ? htmlspecialchars($_GET['module']) : '';

        if ($module === "error") {
            $message = isset($_GET['message']) ? $_GET['message'] : DEFAULT_ERROR_MESSAGE;
            $title = isset($_GET['title']) ? $_GET['title'] : DEFAULT_ERROR_TITLE;
            
            require_once "php/composants/error.php";
            ErrorPanel::showError($title, $message);
        } elseif (Utilisateur::estConnecte()) {
            include_once "php/composants/menu_interne/cont_menu_interne.php" ;

            $cont = new ContMenuInterne();
    
            $cont->afficherMenu();
            
            
            if (in_array($module, AVAILABLEMODULES)) {
                include_once "php/common/Database.php";
                Database::initConnexion();
                
                include_once "php/modules/${module}/mod_${module}.php";
                $classe = "Mod${module}";
        
                $module = new $classe();
            } else {
                header("Location: index.php?module=error&message=module Indefinie&title=Module Inconnu");
            }
        } elseif ($module === 'connexion') {
            include_once "php/common/Database.php";
            Database::initConnexion();

            include_once "php/modules/connexion/mod_connexion.php";
            $mod = new ModConnexion();
        } else {
            //header('Location: Accueil.php');
        }
        
    ?>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>