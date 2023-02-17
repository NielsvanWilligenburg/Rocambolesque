<?php

include_once(APPROOT . '/views/includes/header.php');
$data = $data ?? [];
?>

<body>
	<h1>Inloggen</h1>
	<p><?= $data['notification'] ?></p>
	<form action="<?= URLROOT; ?>/register/login" method="post" id="loginForm">
		<div>
			<label for="type">Email/Username:</label>
			<input type="text" name="userString" placeholder="jankip1" maxlength="50" required>
		</div>
		<div>
			<label for="type">Password:</label>
			<input type="password" name="password" placeholder="******" maxlength="50" required>
		</div>
		<button type="submit" form="loginForm" value="submit">Inloggen</button>


	</form>

</body>

<?php

include_once(APPROOT . '/views/includes/footer.php');

?>