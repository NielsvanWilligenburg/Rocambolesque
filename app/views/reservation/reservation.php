<?php

include_once(APPROOT . '/views/includes/header.php');
$data = $data ?? [];
?>

<body>
	<h1>Registreren</h1>
	<p><?= $data['notification'] ?></p>

	<form action="<?= URLROOT; ?>Reservation/createReservation" method="post" id="reservationForm">
		<div>
			<label for="type">Guests:</label>
			<input type="number" name="guests" min="1" max="4" required>
		</div>
		<div>
			<label for="type">Children:</label>
			<input type="number" name="children" max="2">
		</div>
		<div>
			<label for="type">Date:</label>
			<input type="date" name="date" required>
		</div>
		<div>
			<label for="type">Time:</label>
			<input type="time" name="time" required>
		</div>

		<button type="submit" form="reservationForm" value="submit">Submit</button>


	</form>

</body>

<?php

include_once(APPROOT . '/views/includes/footer.php');

?>