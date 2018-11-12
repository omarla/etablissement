DROP TRIGGER IF EXISTS before_modif_sous_groupe;

DELIMITER $$
CREATE TRIGGER before_modif_sous_groupe 
    BEFORE INSERT OR UPDATE ON est_un_sous_groupe 
    FOR EACH ROW 
        BEGIN

            SELECT * FROM est_un_sous_groupe 
                where id_groupe_parent = NEW.id_groupe_enfant and
                id_groupe_parent = NEW.id_groupe_parent;
            
            IF(FOUND_ROWS() > 0) THEN
                SIGNAL SQLSTATE '3005' SET MESSAGE_TEXT = 'Le groupe parent est déjà enfant du groupe fils ';
            ELSIF(NEW.id_groupe_enfant = NEW.id_groupe_parent) THEN
                SIGNAL SQLSTATE '3004' SET MESSAGE_TEXT = 'Un groupe ne peut être un sous groupe de lui même';
            END IF;

        END $$
DELIMITER ;