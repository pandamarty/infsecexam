<?php
include("../scripts/apiInit.php");
include("../scripts/loginCheck.php");

function run(string $content, int $questionID) {
	// Check if question already exists
	if(Question::findBySomething($content, "content") != null) {
		respond(400, [
			"status" => "error",
			"message" => "The answer already exists"
		]
		);
	}
	try {
		$answer = new Answer();
		$answer->setUserID($_SESSION["user"]->getID());
		$answer->setQuestionID($questionID);
		$answer->setContent($content);
		$answer->setTimestamp(date("Y-m-d H:i:s"));
		$answer->upsert();
		respond(200, [
			"status" => "ok",
			"message" => "Successfully submited answer"
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

run($_POST["answer"], (int) $_POST["questionID"]);
