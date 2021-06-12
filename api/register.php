<?php
include_once("../scripts/apiInit.php");

function run(string $nickname, string $password) {
	// Check minimum lenght requirement
	if(strlen($nickname)<5) {
		respond(400, [
			"status" => "error",
			"message" => "Nickname is too short (must be at least 5 characters)"
		]
		);
	}
	if(strlen($password)<10) {
		respond(400, [
			"status" => "error",
			"message" => "Password is too short (must be at least 10 characters)"
		]
		);
	}
	// Check if user already exists
	if(User::findBySomething($nickname, "nickname") != null) {
		respond(400, [
			"status" => "error",
			"message" => "The nickname already exists"
		]
		);
	}
	try {
		$user = new User();
		$user->setNickname($nickname);
		$user->setPassword(password_hash($password, PASSWORD_DEFAULT));
		$user->upsert();
		respond(200, [
			"status" => "ok",
			"message" => "Successfully registered"
		]
		);
	} catch (Exception $ex) {
		respond(500, [
			"status" => "error",
			"message" => $ex->getMessage()
		]
		);
	}
}

run($_POST["nickname"], $_POST["password"]);