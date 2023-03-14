<?php
include_once(APPROOT . '/views/includes/header.php');


$data = $data ?? [];
// var_dump($data);
?>

<div class="row">

	<h1>Reservation</h1>
	<p><?= $data['notification']; ?></p>

	<form action="<?= URLROOT; ?>Reservation/createReservation" method="post" id="reservationForm">
		<div class="form">
			<div class="input-reservation">
				<label for="type">Guests:</label>
				<input type="number" name="guests" min="1" max="4" required>
			</div>
			<div class="input-reservation">
				<label for="type">Children:</label>
				<input type="number" name="children" min="0" max="2">
			</div>
			<div class="input-reservation">
				<label for="type">Date:</label>
				<input type="date" name="date" required>
			</div>
			<div class="input-reservation">
				<label for="type">Time:</label>
				<input type="time" name="time" required>
			</div>

		</div>
		<button type="submit" form="reservationForm" value="submit">Submit</button>
	</form>
</div>

<?php

include_once(APPROOT . '/views/includes/footer.php');

?>