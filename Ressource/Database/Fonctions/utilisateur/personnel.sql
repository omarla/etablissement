DROP PROCEDURE IF EXISTS setWorkHours;

DELIMITER $$
CREATE PROCEDURE setWorkHours(id_personnel_param integer, heures_travail_param integer, annee_param int)
    BEGIN
    IF(heures_travail_param > 0) THEN
        
        SELECT id_personnel INTO @trash from heures_travail where id_personnel = id_personnel_param and annee = annee_param;
    
        IF(FOUND_ROWS() = 0) THEN
            INSERT INTO heures_travail values (heures_travail_param, annee_param, id_personnel_param);
        ELSE
            UPDATE heures_travail set heures_travail = heures_travail_param where annee = annee_param and id_personnel = id_personnel_param;
        END IF;

    ELSE
        SIGNAL SQLSTATE '23000' SET MYSQL_ERRNO =  3006,MESSAGE_TEXT = 'Les heures de travail ne peuvent pas être négatives';
    END IF;

    END$$
DELIMITER ;





