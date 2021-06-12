<?php
	// Getting page info
	switch(isset($_GET["site"])?$_GET["site"]:null) {
		case null:
			$GLOBALS["site-name"] = "Home";
			$GLOBALS["site"] = "start";
			break;
		case "question":
			$GLOBALS["site-name"] = "Question";
			$GLOBALS["site"] = "question";
			break;
		case "questionList":
			$GLOBALS["site-name"] = "All Questions";
			$GLOBALS["site"] = "questionList";
			break;
		case "createQuestion":
			$GLOBALS["site-name"] = "Create Question";
			$GLOBALS["site"] = "createQuestion";
			break;
		case "login":
			$GLOBALS["site-name"] = "Log in";
			$GLOBALS["site"] = "login";
			break;
		case "logout":
			$GLOBALS["site-name"] = "Log out";
			$GLOBALS["site"] = "logout";
			break;
		case "register":
			$GLOBALS["site-name"] = "Register";
			$GLOBALS["site"] = "register";
			break;
		default:
			$GLOBALS["site-name"] = "Page not found";
			$GLOBALS["site"] = "404";
	}

	// Register autoloader
	spl_autoload_register(function ($class_name) {
		include_once("model/$class_name.class.php");
	});

	// Check login status
	if(isset($_COOKIE["PHPSESSID"])) {
		session_start();
	}
	if(isset($_SESSION["user"])) {
		$GLOBALS["logged_in"] = true;
	} else {
		$GLOBALS["logged_in"] = false;
		// If not logged in, make sure user is on the login site
		if($GLOBALS["site"] != "login" && $GLOBALS["site"] != "register") {
			header("Location: /?site=login");
			die();
		}
	}
	
	// Register escaping function
	function _e($string): string {
		return htmlentities($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	}
	
	// XSRF Token
	if(isset($_COOKIE["XSRFSESSION"])) {
		$token = Token::getTokenFromSession($_COOKIE["XSRFSESSION"]);
		if($token === false) {
			// Somehow the session does not exist anymore or is invalid, redirect to home
			setcookie("XSRFSESSION", "", time() - 3600);
			header("Location: /");
			die();
		} else {
			$GLOBALS["xsrf_token"] = Token::getTokenFromSession($_COOKIE["XSRFSESSION"]);
		}
	} else {
		$session = bin2hex(random_bytes(32));
		$token = Token::generateToken($session);
		setcookie("XSRFSESSION", $session);
		$GLOBALS["xsrf_token"] = $token;
	}

	// Other global init stuff here
?>
