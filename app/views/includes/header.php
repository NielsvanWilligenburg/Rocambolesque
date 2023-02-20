<?php
include_once(APPROOT . '/views/includes/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= SITENAME ?></title>

	<!-- // «««««««««« Css links »»»»»»»»»» // -->
	<link rel="stylesheet" href="../../../css/style.css">


	<!-- // «««««««««« Google fonts »»»»»»»»»» // -->


</head>

<body>
	<nav class="topnav" id="myTopnav">
		<img id="logo" src="../../../images/Rocambolesque-logo-DEF.png" alt="">
		<div class="menus">
			<div class="menu">
				<ul>
					<li><a href="">Home</a></li>
					<li><a href="">Menu</a></li>
					<li><a href="">About</a></li>
					<li><a href="">Contact</a></li>
				</ul>
			</div>
			<div class="user-menu">
				<?php
				if (isset($_SESSION['id']))
					echo "<a class='link-empty' href='" . URLROOT . "register/logout'>Log out</a>";
				else
					echo "<a class='link-empty' href='" . URLROOT . "register/login'>Log in</a>
				<a class='link-fill' href='" . URLROOT . "register/register'>Register</a>'"; ?>
			</div>
		</div>
		<div class="nav-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
			</svg>
		</div>
	</nav>