<?php
if(isset($_POST["xsrf"])) {
	
} else {
	http_response_code(403);
	echo json_encode([
		"status" => "error",
		"message" => "XSRF token not present"
	]);
}