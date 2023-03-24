USE Rocambolesque;
DROP PROCEDURE IF EXISTS spFindRoleByPersonId;

DELIMITER //
    
CREATE PROCEDURE spFindRoleByPersonId
(
	 _personId				INT
)

BEGIN

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;
    	SELECT `role`.`Name` AS "Role" FROM user INNER JOIN userrole uro ON user.Id = uro.UserId INNER JOIN `role` ON `role`.Id = uro.RoleId WHERE PersonId = _personId;
               
        COMMIT;	
END //