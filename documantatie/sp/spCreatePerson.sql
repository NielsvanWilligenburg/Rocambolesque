
USE Rocambolesque;
DROP PROCEDURE IF EXISTS spCreatePerson;

DELIMITER //
    
CREATE PROCEDURE spCreatePerson
(
	 firstname				VARCHAR(50)
	,infix					VARCHAR(20)
	,lastname				VARCHAR(50)
	,username				VARCHAR(50)
	,password				VARCHAR(60)
	,email					VARCHAR(50)
	,mobile					VARCHAR(15)
)

BEGIN

    DECLARE personId 	INT UNSIGNED DEFAULT 0;
    DECLARE userId 		INT UNSIGNED DEFAULT 0;
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;					
		INSERT INTO person
		(
			 Firstname
			,Infix
			,Lastname		
		)
		VALUES
		(
			 firstname
			,infix
			,lastname
		);
		
        SET personId = LAST_INSERT_ID();

		INSERT INTO contact
		(
			 PersonId
			,Email
			,Mobile		
		)
		VALUES
		(
			 personId
			,email
			,mobile
		);
		INSERT INTO user
		(
			 PersonId
			,Username		
			,Password
			,DatumIngelogd		
			,DatumUitgelogd
		)
		VALUES
		(
			 personId
			,username
			,password	
			,NULL
			,NULL
		);
        SET userId = LAST_INSERT_ID();
        INSERT INTO userrole
		(
			 UserId
			,RoleId
		) 
		VALUES
		(
			 userId
			,(SELECT Id FROM `role` WHERE `name` = 'guest')
		);
        COMMIT;	
END //