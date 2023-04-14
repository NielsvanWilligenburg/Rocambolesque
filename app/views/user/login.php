<div class="head login">
	<h1>Inloggen</h1>
</div>
<div class="login-container">
	<div class="panels">
		<div class="panel left-side">
			<img src="../../../public/images/burger.jpg" alt="">
			<div class="text">
				<p>A contemporery menu of seasonal dishes from around the world</p>
			</div>
		</div>
		<div class="panel right-side">
			<form action="<?= URLROOT; ?>user/login" method="post" id="loginForm">
				<div class="form login">

					<div class="subtext" id="username">
						<input type="text" name="userString" placeholder="Username/Email" maxlength="50" required value="<?= $_POST['userString'] ?? "" ?>">
						<a href="#">Forgot username</a>
					</div>
					<div class="subtext" id="password">
						<input type="password" name="password" placeholder="Password" maxlength="50" required value="<?= $_POST['password'] ?? "" ?>">
						<a href="#">Forgot password</a>
					</div>
					<div class="buttons">
						<div id="submit" class="button">
							<p class="notification <?= $data['success'] ?>"><?= $data['notification'] ?></p>
							<a class="link-empty submit" type="submit" onclick="submitForm()">Inloggen</a>
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