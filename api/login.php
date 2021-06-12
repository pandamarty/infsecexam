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
	// Check if user exists
	if(User::findBySomething($nickname, "nickname") == null) {
		respond(400, [
			"status" => "error",
			"message" => "Wrong nickname or password"
		]
		);
	}
	try {
		$user = User::findBySomething($nickname, "nickname")[0];
		if($user->validatePassword($password)) {
			session_start();
			$_SESSION["user"] = $user;
			respond(200, [
				"status" => "ok",
				"message" => "Logged in successfully"
			]
			);
		} else {
			respond(400, [
				"status" => "error",
				"message" => "Wrong nickname or password"
			]
			);
		}
	} catch (Exception $ex) {
		respond(500, [
			"status" => "error",
			"message" => $ex->getMessage()
		]
		);
	}
}

run($_POST["nickname"], $_POST["password"]);