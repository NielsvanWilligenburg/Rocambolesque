<?php

require(APPROOT . '/views/includes/header.php');

?>


<?php

require(APPROOT . '/views/includes/header.php');
$data = $data ?? [];
?>

<body>
	<h1>Registreren</h1>
	<p><?= $data['notification'] ?></p>
	<form action="<?= URLROOT; ?>/register/register" method="post" id="registerForm">
		<div>
			<label for="type">Name:</label>
			<input type="text" name="firstname" placeholder="Jan" maxlength="50">
			<input type="text" name="lastname" placeholder="Kip" maxlength="50">
		</div>
		<div>
			<label for="type">Username:</label>
			<input type="text" name="username" placeholder="jankip1" maxlength="50">
		</div>
		<div>
			<label for="type">Password:</label>
			<input type="password" name="password" placeholder="******" maxlength="50">
		</div>
		<div>
			<label for="type">Email:</label>
			<input type="text" name="email" placeholder="currysaus@gmail.com" maxlength="50">
		</div>
		<div>
			<label for="type">Mobile:</label>
			<input type="text" name="mobile" placeholder="0646513232" maxlength="10">
		</div>

		<button type="submit" form="registerForm" value="submit">Wijzig</button>


	</form>

</body>

<?php

require(APPROOT . '/views/includes/footer.php');

?>