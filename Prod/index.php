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
    require_once "php/common/Fonctions.php";
    require_once "php/common/classes/user/utilisateur.php";
?>
<!DOCTYPE html>
<html>
<head>
	
	<title>Etablissement</title>
	<meta charset="utf-8">

	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" rel="stylesheet" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" type="text/css">
    <link href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

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
        } elseif (Utilisateur::estConnecte() || true) {
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

	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="scripts/init.js"></script>    
    <script src="scripts/utilisateurs.js"></script>
    <script src="scripts/groupe.js"></script>

</body>
</html>