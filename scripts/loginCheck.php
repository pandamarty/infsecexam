<?php

// Check login status
if(isset($_COOKIE["PHPSESSID"])) {
	session_start();
} else {
	http_response_code(403);
	echo json_encode([
		"status" => "error",
		"message" => "You are not authorized to perform this action"
	]);
}
