
USE Rocambolesque;
DROP PROCEDURE IF EXISTS spFindUsername;

DELIMITER //
    
CREATE PROCEDURE spFindUsername
(
	 usernameCheck				VARCHAR(50)
)

BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;
    	SELECT * FROM user WHERE Username = usernameCheck;
               
        COMMIT;	
END //