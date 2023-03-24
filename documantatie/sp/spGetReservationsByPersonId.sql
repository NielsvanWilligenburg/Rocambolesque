USE Rocambolesque;
DROP PROCEDURE IF EXISTS spGetReservationsByPersonId;

DELIMITER //
    
CREATE PROCEDURE spGetReservationsByPersonId
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
		SELECT 
			res.Id, 
			res.PersonId, 
			res.TableId, 
			res.Guests, 
			res.Children, 
			res.Date, 
			res.Time, 
			tab.MaxGuests, 
			tab.MaxChildren,
			ope.Opening,
			ope.Closing,
			pri.GuestsPrice,
			pri.ChildPrice
		FROM reservation res 
		INNER JOIN `table` tab 
			ON res.TableId = tab.Id 
		INNER JOIN openingtime ope 
			ON ope.Id = res.OpeningtimeId 
		INNER JOIN price pri 
			ON pri.Id = ope.PriceId
		WHERE res.PersonId = _personId;
               
END //
