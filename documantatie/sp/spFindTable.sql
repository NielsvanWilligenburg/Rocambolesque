USE Rocambolesque;

DROP PROCEDURE IF EXISTS spFindTable;

DELIMITER //

CREATE PROCEDURE spFindTable(
    guestCheck                    INT,
    childCheck                    INT,
    dateCheck                    VARCHAR(10),
    timeStartCheck                VARCHAR(8)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
    END;
    
    START TRANSACTION;
    SELECT tab.Id
    FROM `table` tab
    WHERE MaxGuests >= guestCheck 
        AND MaxChildren >= childCheck
        AND Id NOT IN (    SELECT tab.Id
                        FROM `table` tab 
                        LEFT JOIN reservation res 
                        ON res.TableId = tab.Id 
                        WHERE `Date` = dateCheck
                            AND timeStartCheck BETWEEN DATE_SUB(`Time`, INTERVAL 2 HOUR) AND DATE_ADD(`Time`, INTERVAL 2 HOUR))
    ORDER BY MaxGuests ASC, MaxChildren ASC LIMIT 1;
    COMMIT;
END //