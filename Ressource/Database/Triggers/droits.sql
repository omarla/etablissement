DROP TRIGGER IF EXISTS before_modif_droit_visualisation_heures_travail;

DELIMITER $$
CREATE TRIGGER before_modif_droit_visualisation_heures_travail 
    BEFORE INSERT OR UPDATE ON droits 
    FOR EACH ROW 
        BEGIN
        
            IF(NEW.droit_visualisation_heures_travail = 0 AND New.droit_modification_heures_travail = 1) THEN
                SIGNAL SQLSTATE '3001' SET MESSAGE_TEXT = 'Le droit de visualisation des heures de travail est obligatoire pour pouvoir les modifier';
            END IF;

        END $$
DELIMITER ;