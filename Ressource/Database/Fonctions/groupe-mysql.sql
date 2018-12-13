DROP FUNCTION IF EXISTS est_membre_groupe;
DELIMITER $$

CREATE FUNCTION est_membre_groupe(current_id_utilisateur integer, current_id_groupe integer) returns integer
BEGIN
    select id_utilisateur INTO @trash_membres from membres_de_groupe where id_utilisateur = current_id_utilisateur and id_groupe = current_id_groupe;
    RETURN FOUND_ROWS();
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS test_est_dans_groupe ;

DELIMITER $$
CREATE PROCEDURE test_est_dans_groupe(IN id_utilisateur integer, IN groupe_parent integer, INOUT appartient integer) 
BEGIN
    DECLARE est_fini integer default 0;
    DECLARE id_sous_groupe integer;

    DECLARE curs_groupe cursor for select id_groupe_enfant from sous_groupe where groupe_parent = id_groupe_parent;
    DECLARE continue handler for not found set est_fini = 1;

    IF (est_membre_groupe(id_utilisateur, groupe_parent) = 1) THEN
        
        set appartient = 1;
                
    ELSE 

        SET @@max_sp_recursion_depth = 255;

        open curs_groupe;

        set appartient = 0;

        appartient_au_sous_groupes:LOOP
            
            IF (appartient = 1) THEN
                LEAVE appartient_au_sous_groupes;
            END IF;

            fetch curs_groupe into id_sous_groupe;

            IF (est_fini = 1) THEN
                LEAVE appartient_au_sous_groupes;
            END IF;

            select est_membre_groupe(id_utilisateur, id_sous_groupe) into appartient;

            IF (appartient = 1) THEN
                LEAVE appartient_au_sous_groupes;
            END IF;

            call test_est_dans_groupe(id_utilisateur, id_sous_groupe, appartient);

        END LOOP;

        close curs_groupe;

    END IF;
        

END$$
DELIMITER ;



DROP FUNCTION IF EXISTS est_dans_groupe ;

DELIMITER $$

CREATE FUNCTION est_dans_groupe( id_utilisateur integer,  groupe_parent integer) RETURNS INTEGER 

BEGIN

    DECLARE appartient integer default 0;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION RETURN 0;

    call test_est_dans_groupe(id_utilisateur, groupe_parent, appartient);

    return appartient;

END$$

DELIMITER ;



/**************************************************************************/
/*************************SOUS GROUPES*************************************/
/**************************************************************************/

DROP FUNCTION IF EXISTS est_sous_groupe;
DELIMITER $$

CREATE FUNCTION est_sous_groupe(groupe_enfant integer, groupe_parent integer) returns integer
BEGIN
    select id_groupe_enfant INTO @trash_membres from sous_groupe where id_groupe_enfant = groupe_enfant and id_groupe_parent = groupe_parent;
    RETURN FOUND_ROWS();
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS test_est_un_sous_groupe ;

DELIMITER $$
CREATE PROCEDURE test_est_un_sous_groupe(IN groupe_enfant integer, IN groupe_parent integer, INOUT appartient integer) 
BEGIN
    DECLARE est_fini integer default 0;
    DECLARE id_sous_groupe integer;

    DECLARE curs_groupe cursor for select id_groupe_enfant from sous_groupe where id_groupe_parent = groupe_parent;
    DECLARE continue handler for not found set est_fini = 1;

    IF (est_sous_groupe(groupe_enfant, groupe_parent) = 1) THEN
        
        set appartient = 1;
                
    ELSE 

        SET @@max_sp_recursion_depth = 255;

        open curs_groupe;

        set appartient = 0;

        sous_groupe:LOOP
            
            IF (appartient = 1) THEN
                LEAVE sous_groupe;
            END IF;

            fetch curs_groupe into id_sous_groupe;

            IF (est_fini = 1) THEN
                LEAVE sous_groupe;
            END IF;

            select est_sous_groupe(groupe_enfant, id_sous_groupe) into appartient;

            IF (appartient = 1) THEN
                LEAVE sous_groupe;
            END IF;

            call test_est_un_sous_groupe(groupe_enfant, id_sous_groupe, appartient);

        END LOOP;

        close curs_groupe;

    END IF;
        

END$$
DELIMITER ;



DROP FUNCTION IF EXISTS est_un_sous_groupe ;

DELIMITER $$

CREATE FUNCTION est_un_sous_groupe( groupe_enfant integer,  groupe_parent integer) RETURNS INTEGER 

BEGIN

    DECLARE appartient integer default 0;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION RETURN 0;

    call test_est_un_sous_groupe(groupe_enfant, groupe_parent, appartient);

    return appartient;

END$$

DELIMITER ;