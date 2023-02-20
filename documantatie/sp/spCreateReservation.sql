-- All the stored procedures below V
USE Rocambolesque;
DROP PROCEDURE IF EXISTS spCreateReservation;

DELIMITER //
    
CREATE PROCEDURE spCreateReservation
(
	 personId				VARCHAR(50)
	,priceId				VARCHAR(50)
	,openingtimeId			VARCHAR(50)
	,tableId				VARCHAR(60)
	,guests					VARCHAR(50)
	,children				VARCHAR(15)
    ,date					date
    ,time 					time
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
			 PersonId			
			,PriceId
            ,OpeningtimeId
            ,TableId
            ,Guests
            ,Children
            ,Date
            ,Time
			,IsActief	
			,Opmerking    	
			,DatumAangemaakt  
			,DatumGewijzigd	
		)
		VALUES
		(
			personId				
			,priceId				
			,openingtimeId			
			,tableId				
			,guests					
			,children				
			,date					
			,time 	
			,1
			,NULL
			,SYSDATE(6)	
			,SYSDATE(6)	
		);
               
        COMMIT;	
END //

