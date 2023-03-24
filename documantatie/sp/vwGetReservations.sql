USE Rocambolesque;
DROP VIEW IF EXISTS vwGetReservations;

CREATE VIEW vwGetReservations AS
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
	ON pri.Id = ope.PriceId;