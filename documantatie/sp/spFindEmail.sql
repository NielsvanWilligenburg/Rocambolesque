
USE Rocambolesque;
DROP PROCEDURE IF EXISTS spFindEmail;

DELIMITER //
    
CREATE PROCEDURE spFindEmail
(
	 emailCheck				VARCHAR(50)
)

BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;
    	SELECT * FROM contact WHERE Email = emailCheck;
               
        COMMIT;	
END //