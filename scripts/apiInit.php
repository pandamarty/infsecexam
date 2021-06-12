<?php
	function respond(int $code, array $object) {
		http_response_code($code);
		echo json_encode($object);
		exit();
	}
	
	// Register autoloader
	spl_autoload_register(function ($class_name) {
		include_once("../model/$class_name.class.php");
	});
	
	if(isset($_POST["xsrf"])) {
		if(isset($_COOKIE["XSRFSESSION"])) {
			if(Token::validateToken($_COOKIE["XSRFSESSION"], $_POST["xsrf"]) === false) {
				respond(403, [
					"status" => "error",
					"message" => "Invalid XSRF token"
				]);
			}
		} else {
			respond(403, [
			"status" => "error",
			"message" => "Invalid session"
		]);
		}
	} else {
		respond(403, [
			"status" => "error",
			"message" => "XSRF token not present"
		]);
	}
