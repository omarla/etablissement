<?php
    define("EXCEPTIONS_CODE", array(
        '3001'=>"Le droit de visualisation des heures de travail est obligatoire pour pouvoir les modifier",
        '3002'=>"Le nom d'utilisateur n'éxiste pas, merci de vérifier les informations saisies",
        '3003'=>"Le mot de passe saisie est incorrect",
        '3004'=>"Création de sous groupe refusée. Un groupe ne peut pas être un sous groupe de lui même",
        '3005'=>"Création de sous groupe refusée. Un groupe ne peut pas être sous groupe d'un de ses groupes fils"
    ));

    define("AVAILABLEMODULES", array(
        "connexion",
        "administration"
    ));

    define("SALT_KEY", '$6$rounds=5000$jljA7uJicFbvUpjjI0tifoMON4E1fDVnvQMxq5y7O7F3V7gmJFTXbybSTEOLz3XHKnN6ddx1m9i9XEo5W51LYif1FBrbt6UhIKON9dGZpRdQqm947QXICOVVhqvkfAPIiNKWpV1DNgyrcddbZZptPYrclSCKVF6LTBoLzr9JJIBIiutk73WFFYtCsJZOfPNFpS1Cvla8sR4r2YZQLhGZ2lriZJEFosg3mF0kVayKjBS031xyiy1VDgaw3UqlpWVFwYGvMv5sQ0CKNZTlRvn0Y5zyTplogB4M7RkaaJjE8tZ0jTT69TZ422Ur7NM1PMXMqr4GOGp8uf7SSX2kPYPmjzLq3woHldZ68lGuRmA6C7ZR2YY4pzpVHBYqSwRhbIre8BmFutgv3ZzjC41O4XQoEN6FYdB6acn9ou2XODnMwHIlHw5RSLGksMe7w92ef2BU4fKSgBrYKZmx72NwiEUIGaboDa94Y8IvgGByzVtmCom8uTPaPp4nDYiPTpF61dfmSZtIi5L250EUgLa7nzJ4imRxUgNDVSVkEvPMYyr6yLRJ3VMjcznqYixJnhHbtEuXZyFTEGjtXr48hgXPz4RbFwrLVF3wiwJ259gBEgKM9Iuc105puuKpqPA7FlfDJAPMOZFowZkbvPb2TmEnVlAw4E2GJgZcYlYP9bIwjlIriVGnhE4mHGgKMizwgz4fHoMVKh3D359JBaHMm26HfOyca3tQQuCT7d0rHPeEodagLTV8aVJDjFO3oDatR6cvUytNQQfOsWbOJWOF70HAfcYNROvzKBQl77yE$');

    define("LONG_CLE_RECUPERATION", 100);

//----------------------------------ERROR MESSAGES----------------------------------//
    define("DEFAULT_ERROR_MESSAGE", "Une erreur inconnue est survenue");

    define("DEFAULT_ERROR_TITLE", "Erreur");

    define("INVALID_ACTION_ERROR_MESSAGE", "Cette action est invalide pour ce module");

    define("DATABASE_ERROR_MESSAGE", "La base de données est en maintenance, Merci de réessayer plus tard");

    define("DATABASE_ERROR_TITLE", "Erreur BD");

    define("UNDEFINED_USERNAME_ERROR", "Merci de bien indiquer le nom d'utilisateur");

    define("UNDEFINED_PASSWORD_ERROR", "Merci de bien indiquer le mot de passe");

    define("ERROR_MESSAGE_USING_SQL_CODE", array(
        '3002'=>"Vous n'êtes pas autorisés"
    ));
