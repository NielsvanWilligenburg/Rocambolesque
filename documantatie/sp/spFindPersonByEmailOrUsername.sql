
USE Rocambolesque;
DROP PROCEDURE IF EXISTS spFindPersonByEmailOrUsername;

DELIMITER //
    
CREATE PROCEDURE spFindPersonByEmailOrUsername
(
	userString				VARCHAR(50)
)

BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;
    	SELECT `user`.Password, per.Id FROM `person` per INNER JOIN `contact` con ON per.Id = con.PersonId INNER JOIN `user` ON per.Id = `user`.PersonId WHERE con.Email = userString OR `user`.Username = userString;
               
        COMMIT;	
END //