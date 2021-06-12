<?php
include_once "DBObject.class.php";

class Token extends DBObject {

	/* Fields */
	protected $session;
	protected $token;
	protected $timestamp;

	/* Other configuration */
	const COLLECTION_NAME = "tokens";

	/* *** Getter & Setter *** */

	public function getSession() {
		return $this->session;
	}

	public function getToken() {
		return $this->token;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function setSession($value) {
		$this->session = $value;
	}

	public function setToken($value) {
		$this->token = $value;
	}

	public function setTimestamp($value) {
		$this->timestamp = $value;
	}

	/* Virtual getters */
	
	/* Static functions */

	public static function validateToken($session, $token): bool {
		$tk = Token::findBySomething($session, "session");
		return (count($tk)>0) ? ($tk[0]->getToken() === $token) : false;
	}

	public static function generateToken($session): string {
		$tk = new Token();
		$tk->setSession($session);
		$tk->setToken(bin2hex(random_bytes(32)));
		$tk->setTimestamp(date("Y-m-d H:i:s"));
		$tk->upsert();
		return $tk->getToken();
	}
	
	public static function getTokenFromSession($session): string {
		$tk = Token::findBySomething($session, "session");
		return (count($tk)>0) ? $tk[0]->getToken() : false;
	}

	/* Other methods */


}
?>
