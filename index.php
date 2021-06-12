<?php
	include_once("scripts/init.php");
	include_once("sites/{$GLOBALS["site"]}.incl.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--Browser and document meta-tags-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="UTF-8" />
		<meta name="xsrf-token" content="<?= $GLOBALS["xsrf_token"] ?>">

		<!--Informational meta-tags-->
		<meta name="description" content="Forum Demo" />

		<!--Mobile meta-tags-->
		<meta name="theme-color" content="#849824" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />

		<!--Style-->
		<link rel="stylesheet" type="text/css" href="/style/main.css" />
		<link rel="stylesheet" type="text/css" href="/style/colors.css" />

		<!--Fonts-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=ABeeZee" rel="stylesheet" type='text/css' />

		<title><?= $GLOBALS["site-name"] ?> | Forum Demo</title>
	</head>
	<body>
		<header>
			<div id="sandwitch"><img src="/media/sandwitch.svg" alt="MENU" /></div>
			<a href="./">
				<img src="/media/header_image.svg" alt="header image" />
			</a>
			<span id="login-status"><?= $GLOBALS["logged_in"]? 'Logged in' : 'Not logged in' ?></span>
		</header>
		<nav>
			<ul class="list-up">
				<a href="?site=questionList"><li><i class="material-icons">list</i>Browse Questions</li></a>
				<a href="?site=createQuestion"><li><i class="material-icons">post_add</i>New Question</li></a>
				<?php if($GLOBALS["logged_in"]): ?>
				<a href="?site=logout"><li><i class="material-icons">logout</i>Logout</li></a>
				<?php endif ?>
			</ul>
			<ul class="list-down">
				<li>UniBZ | BCS | InfSec</li>
				<li>Dorigatti Mattia</li>
				<li>Tonini Lukas</li>
			</ul>
		</nav>
		<div id="curtain" class="curtain-open"></div>
		<a href="#">
			<div class="back-to-the-top" ></div>
		</a>
		<main>
			<?php
				include_once("sites/{$GLOBALS["site"]}.temp.php");
			?>
		</main>
		<script type="text/javascript" src="js/sandwitch.js" async defer></script>
	</body>
</html>
