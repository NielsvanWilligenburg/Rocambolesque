<?php

include_once(APPROOT . '/views/includes/header.php');
$data = $data ?? [];
?>

<body>
	<div class="head">
		<h1>Register</h1>
	</div>
	<form action="<?= URLROOT; ?>register/register" method="post" id="registerForm">
		<div class="form register">
			<div class="name">
				<div class="required firstname">
					<input type="text" name="firstname" placeholder="Firstname" maxlength="50" value="<?= $_POST['firstname'] ?? "" ?>">
				</div>
				<div class="infix">
					<input type="text" name="infix" placeholder="Infix" maxlength="20" value="<?= $_POST['infix'] ?? "" ?>">
				</div>
				<div class="required">
					<input type="text" name="lastname" placeholder="Lastname" maxlength="50" value="<?= $_POST['lastname'] ?? "" ?>">
				</div>
			</div>
			<div class="required">
				<input type="text" name="username" placeholder="Username" maxlength="50"  value="<?= $_POST['username'] ?? "" ?>">
			</div>
			<div class="required">
				<input type="text" name="email" placeholder="Email" maxlength="50" value="<?= $_POST['email'] ?? "" ?>">
			</div>
			<div class="required">
				<input type="text" name="mobile" placeholder="Phone number" maxlength="15" value="<?= $_POST['mobile'] ?? "" ?>">
			</div>
			<div class="required">
				<input type="password" name="password" placeholder="Password" maxlength="50" value="<?= $_POST['password'] ?? "" ?>">
			</div>
			<div class="required">
				<input type="password" name="repeat-password" placeholder="Repeat Password" maxlength="50" value="<?= $_POST['repeat-password'] ?? "" ?>">
			</div>
			<div>
				<input type="checkbox" name="terms" id="terms">
				<label for="terms">I agree to the <a target="_blank" href="">Terms of Use</a></label>
			</div>
			<div class="buttons">
				<div id="submit" class="button">
					<p class="notification"><?= $data['notification'] ?></p>
					<a class="link-empty submit" onclick="submitForm()">Register</a>
				</div>
				<div class="or">
					<p>or</p>
				</div>
				<div class="button to-login">
					<a class="link-empty submit" href="<?= URLROOT; ?>register/login">Login</a>
				</div>
			</div>
		</div>


	</form>

	<script>
		function submitForm() {
			document.querySelector("form#registerForm").submit();
		}
	</script>


<?php

include_once(APPROOT . '/views/includes/footer.php');

?>