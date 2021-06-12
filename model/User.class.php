<?php
include_once "DBObject.class.php";

class User extends DBObject {
	
	/* Fields */
	protected $nickname;
	protected $password;
	
	/* Other configuration */
	const COLLECTION_NAME = "users";

	/* *** Getter & Setter *** */

	public function getNickname() {
		return $this->nickname;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setNickname($value) {
		$this->nickname = $value;
	}
	
	public function setPassword($value) {
		$this->password = $value;
	}
	
	/* Virtual getters */
	
	
	/* Other methods */
	
	public function validatePassword($plainPassword): bool {
		return password_verify($plainPassword, $this->getPassword());
	}
}
?>
