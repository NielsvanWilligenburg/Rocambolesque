<?php

include_once(APPROOT . '/views/includes/header.php');
$data = $data ?? [];
if (isset($_SESSION['id']))
	header("Location: " . URLROOT);
?>

<body>
	<div class="head login">
		<h1>Inloggen</h1>
	</div>
	<div class="container login">
		<div class="row">
			<div class="col left-side">
				<img src="../../../public/images/burger.jpg" alt="">
				<div class="text">
					<p>A contemporery menu of seasonal dishes from around the world</p>
				</div>
			</div>
			<div class="col right-side">
				<form action="<?= URLROOT; ?>register/login" method="post" id="loginForm">
					<div class="form login">

						<div class="subtext" id="username">
							<input type="text" name="userString" placeholder="Username/Email" maxlength="50" required>
							<a href="#">Forgot username</a>
						</div>
						<div class="subtext" id="password">
							<input type="password" name="password" placeholder="Password" maxlength="50" required>
							<a href="#">Forgot password</a>
						</div>
						<div class="buttons">
							<div id="submit" class="button">
								<p class="notification"><?= $data['notification'] ?></p>
								<a class="link-empty submit" onclick="submitForm()">Inloggen</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		function submitForm() {
			document.querySelector("form#loginForm").submit();
		}
	</script>

</body>

<?php

include_once(APPROOT . '/views/includes/footer.php');

?>