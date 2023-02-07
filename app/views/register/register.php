<?php

require(APPROOT . '/views/includes/header.php');

?>


<?php

require(APPROOT . '/views/includes/header.php');
$data = $data ?? [];
?>

<body>
	<h1>Registreren</h1>
	<form action="<?= URLROOT; ?>/register/register" method="post" id="registerForm">
		<div>
			<label for="type">Name:</label>
			<input type="text" name="firstname" placeholder="First Name">
			<input type="text" name="lastname" placeholder="Last Name">
		</div>
		<div>
			<label for="type">Username:</label>
			<input type="text" name="username" placeholder="Username">
		</div>
		<div>
			<label for="type">Password:</label>
			<input type="password" name="password" placeholder="Password">
		</div>
		<div>
			<label for="type">Email:</label>
			<input type="text" name="email" placeholder="Email">
		</div>
		<div>
			<label for="type">Mobile:</label>
			<input type="text" name="mobile" placeholder="Mobiel">
		</div>

		<button type="submit" form="registerForm" value="submit">Wijzig</button>


	</form>

</body>

<?php

require(APPROOT . '/views/includes/footer.php');

?>