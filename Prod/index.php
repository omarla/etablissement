<?php
    session_start();

    if (isset($_SESSION['historique']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        array_unshift($_SESSION['historique'], "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    } else if($_SERVER['REQUEST_METHOD'] === 'GET'){
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

    <link href="css/Common/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./frameworks/font-awesome/css/all.css" rel="stylesheet" type="text/css">
    <link href="css/Common/toastr.css" rel="stylesheet" type="text/css">
    <link href="./frameworks/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <link href="css/Common/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css">

    <link href="css/main.css" rel="stylesheet"  type="text/css">
	<link href="css/page-externe.css" rel="stylesheet" type="text/css"> 
	<link href="css/menu-externe.css" rel="stylesheet" type="text/css">
	<link href="css/connexion.css" type="text/css" rel="stylesheet">
	<link href="css/menu-interne.css" rel="stylesheet" type="text/css" >
    <link href="css/administration.css" rel="stylesheet" type="text/css" >
    <link href="css/edt/edt.css" rel="stylesheet" type="text/css">
    <link href="css/moodle/simple-sidebar.css" rel="stylesheet" type="text/css" />
    <link href="css/moodle/styleMoodle.css" rel="stylesheet" type="text/css" /> 

</head>
<body>
    <?php
    
        ob_start();

        $module = isset($_GET['module']) ? htmlspecialchars($_GET['module']) : '';

        if ($module === "error") {
            
            $message = isset($_GET['message']) ? $_GET['message'] : DEFAULT_ERROR_MESSAGE;
            
            $title = isset($_GET['title']) ? $_GET['title'] : DEFAULT_ERROR_TITLE;
            
            require_once "php/composants/error.php";
            
            ErrorPanel::showError($title, $message);

        } elseif (Utilisateur::estConnecte() || true) {
            
            include_once "php/composants/menu_interne/cont_menu_interne.php" ;
            include_once "php/composants/menu_moodle/cont_menu_moodle.php" ;

            if($module === "moodle"){
                $cont = new ContMenuMoodle();
            }else{
                $cont = new ContMenuInterne();  
            }
            //$cont = new ContMenuInterne();
    
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

        echo ob_get_clean();
      
    ?>

	<script src="scripts/Common/jquery-3.3.1.min.js" ></script>
	<script src="scripts/Common/popper.min.js" ></script>
	<script src="scripts/Common/bootstrap.min.js" ></script>
    <script src="scripts/Common/toastr.js"></script>
    <script src="./frameworks/DataTables/datatables.min.js"></script>
    <script src="./frameworks/DataTables/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
 
    <script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>




    <script src="scripts/Common/jquery.flexdatalist.js"></script>

    <script src="scripts/init.js"></script>    
    <script src="scripts/autocomplete.js"></script>
    <script src="scripts/groupe.js"></script>
    <script src="scripts/responsive.js"></script>
    <script src="scripts/edt/edt.js" type="text/babel"></script>


    <script >
    </script>

</body>
</html>