USE Rocambolesque;
DROP PROCEDURE IF EXISTS spCreateReservation;

DELIMITER //
    
CREATE PROCEDURE spCreateReservation
(
	 personId				int
	,openingtimeId			int	
	,tableId				int
	,guests					int
	,children				int
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