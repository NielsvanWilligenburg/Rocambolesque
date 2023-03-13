-- All the stored procedures below V
USE Rocambolesque;
DROP PROCEDURE IF EXISTS spCreateReservation;

DELIMITER //
    
CREATE PROCEDURE spCreateReservation
(
	 personId				int
	,openingtimeId			int	
	,tableId				int
	,guests					VARCHAR(1)
	,children				VARCHAR(1)
    ,dateReservation		date
    ,timeReservation 		time
)

BEGIN
    
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
    	ROLLBACK;
    	SELECT 'An error has occurred, operation rollbacked and the stored procedure was terminated';
	END;
            
	START TRANSACTION;					
		INSERT INTO reservation
		(
			 PersonId			
            ,OpeningtimeId
            ,TableId
            ,Guests
            ,Children
            ,Date
            ,Time
		)
		VALUES
		(
			personId				
			,openingtimeId			
			,tableId				
			,guests					
			,children				
			,dateReservation		
			,timeReservation 		
		);	
END //