DROP TRIGGER IF EXISTS before_modif_sous_groupe;

DELIMITER $$
CREATE TRIGGER before_modif_sous_groupe 
    BEFORE INSERT ON sous_groupe 
    FOR EACH ROW 
        BEGIN            
            IF(est_un_sous_groupe(NEW.id_groupe_parent, NEW.id_groupe_enfant) = 1) THEN
                SIGNAL SQLSTATE '23000' SET MYSQL_ERRNO =  3005, MESSAGE_TEXT = 'Le groupe parent est déjà enfant du groupe fils ';
            ELSEIF(NEW.id_groupe_enfant = NEW.id_groupe_parent) THEN
                SIGNAL SQLSTATE '23000' SET MYSQL_ERRNO =  3004, MESSAGE_TEXT = 'Un groupe ne peut être un sous groupe de lui même';
            END IF;

        END $$
DELIMITER ;