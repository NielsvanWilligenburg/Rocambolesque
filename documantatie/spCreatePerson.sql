
USE Rocambolesque;
DROP PROCEDURE IF EXISTS spCreatePerson;

DELIMITER //
    
CREATE PROCEDURE spCreatePerson
(
	 firstname				VARCHAR(50)
	,lastname				VARCHAR(50)
	,username				VARCHAR(50)
	,password				VARCHAR(50)
	,email					VARCHAR(50)
	,mobile					VARCHAR(12)
)

BEGIN

    DECLARE personId 	INT UNSIGNED DEFAULT 0;
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;					
		INSERT INTO person
		(
			 Firstname			
			,Lastname		
			,IsActief	
			,Opmerking    	
			,DatumAangemaakt  
			,DatumGewijzigd	
		)
		VALUES
		(
			 firstname
			,lastname
			,1
			,'NULL'
			,SYSDATE(6)	
			,SYSDATE(6)	
		);
		
        SET personId = LAST_INSERT_ID();

		INSERT INTO contact
		(
			 PersonId
			,Email
			,Mobile		
			,IsActief		
			,Opmerking   	
			,DatumAangemaakt
			,DatumGewijzigd		
		)
		VALUES
		(
			 personId
			,email
			,mobile
			,1
			,'NULL'
			,SYSDATE(6)	
			,SYSDATE(6)	
		);
			
		INSERT INTO user
		(
			 PersonId
			,Username		
			,Password		
			,DatumIngelogd		
			,DatumUitgelogd
			,IsActief
			,Opmerking
			,DatumAangemaakt  
			,DatumGewijzigd
		)
		VALUES
		(
			 personId
			,username
			,password	
			,NULL
			,NULL
			,isActief	
			,opmerking	
			,SYSDATE(6)		
			,SYSDATE(6)	
		);
               
        COMMIT;	
END //