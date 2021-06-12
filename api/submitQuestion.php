<?php
include("../scripts/apiInit.php");
include("../scripts/loginCheck.php");

function run(string $content) {
	// Check if question already exists
	if(Question::findBySomething($content, "content") != null) {
		respond(400, [
			"status" => "error",
			"message" => "The question already exists"
		]
		);
	}
	try {
		$question = new Question();
		$question->setUserID($_SESSION["user"]->getID());
		$question->setContent($content);
		$question->setTimestamp(date("Y-m-d H:i:s"));
		$question->upsert();
		respond(200, [
			"status" => "ok",
			"message" => "Successfully submited question",
			"id" => $question->getID()
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

run($_POST["question"]);
