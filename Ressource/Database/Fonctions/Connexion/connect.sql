DROP FUNCTION IF EXISTS connect_user;

DELIMIER $$
CREATE FUNCTION connect_user(pseudo varchar(45), mot_de_passe varchar(60)) returns int
    BEGIN
        DECLARE id int default -1;
        SELECT * from utilisateur where pseudo_utilisateur = pseudo;
        IF(FOUND_ROWS() = 0) THEN
            SIGNAL SQLSTATE '3002' SET MESSAGE_TEXT = 'Cet utilisateur n''existe pas ';
        ELSE
            SELECT id_utilisateur into id from utilisateur 
                where pseudo_utilisateur = pseudo and
                mot_de_passe_utilisateur = mot_de_passe;
            IF(FOUND_ROWS() = 0) THEN
                SIGNAL SQLSTATE '3003' SET MESSAGE_TEXT = 'Mot de passe erronée';
            END IF;
        END IF;
        RETURN id;
    END$$
DELIMITER ;