<?php
    define("EXCEPTIONS_CODE", array(
        '3001'=>"Le droit de visualisation des heures de travail est obligatoire pour pouvoir les modifier",
        '3002'=>"Le nom d'utilisateur n'éxiste pas, merci de vérifier les informations saisies",
        '3003'=>"Le mot de passe saisie est incorrect",
        '3004'=>"Création de sous groupe refusée. Un groupe ne peut pas être un sous groupe de lui même",
        '3005'=>"Création de sous groupe refusée. Un groupe ne peut pas être sous groupe d'un de ses groupes fils"
    ));

    define("AVAILABLEMODULES", array(
        "connexion"
    ));


//----------------------------------ERROR MESSAGES----------------------------------//
    define("DEFAULT_ERROR_MESSAGE", "Une erreur inconnue est survenue");

    define("DEFAULT_ERROR_TITLE", "Erreur");

    define("INVALID_ACTION_ERROR_MESSAGE", "Cette action est invalid pour ce module");

    define("DATABASE_ERROR_MESSAGE", "La base de données est en maintenance, Merci de réessayer plus tard");

    define("DATABASE_ERROR_TITLE", "Erreur BD");

    define("UNDEFINED_USERNAME_ERROR", "Merci de bien indiquer le nom d'utilisateur");

    define("UNDEFINED_PASSWORD_ERROR", "Merci de bien indiquer le mot de passe");
