<?php
include_once "DBObject.class.php";

class Answer extends DBObject {

	/* Fields */
	protected $questionID;
	protected $userID;
	protected $content;
	protected $timestamp;

	/* Other configuration */
	const COLLECTION_NAME = "answers";

	/* *** Getter & Setter *** */

	public function getQuestionID() {
		return $this->questionID;
	}

	public function getUserID() {
		return $this->userID;
	}

	public function getContent() {
		return $this->content;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function setQuestionID($value) {
		$this->questionID = $value;
	}

	public function setUserID($value) {
		$this->userID = $value;
	}

	public function setContent($value) {
		$this->content = $value;
	}

	public function setTimestamp($value) {
		$this->timestamp = $value;
	}

	/* Virtual getters */

	public function getNickname(){
		return User::find($this->getUserID())->getNickname();
	}

	/* Other methods */


}
?>
