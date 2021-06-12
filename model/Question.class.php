<?php
include_once "DBObject.class.php";

class Question extends DBObject {

	/* Fields */
	protected $userID;
	protected $content;
	protected $timestamp;

	/* Other configuration */
	const COLLECTION_NAME = "questions";

	/* *** Getter & Setter *** */

	public function getUserID() {
		return $this->userID;
	}

	public function getContent() {
		return $this->content;
	}

	public function getTimestamp() {
		return $this->timestamp;
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

	public function getAmountOfAnswers(){
		return Answer::findBySomethingAmount($this->getID(),"questionID");
	}

	public function getAllAnswers(){
		return Answer::findBySomething($this->getID(),"questionID");
	}

	/* Other methods */


}
?>
