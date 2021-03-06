<?php
// DB Singleton

class DB {
	private static $db = null;

	// Make constructor private so it can't be accessed
	private function __construct() {
		;
	}

	public static function getDB() {
		if (self::$db == null) {
			try {
				$host     = getenv("DB_HOST")   ?: 'localhost';
				$database = getenv("DB_NAME")   ?: 'database';
				$user     = getenv("DB_USER")   ?: 'name';
				$passwd   = getenv("DB_PASSWD") ?: 'password';
				
				self::$db = new PDO("pgsql:host={$host};dbname={$database}", $user, $passwd);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->exec("SET datestyle TO European;");
			}
			catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		return self::$db;
	}

}
?>
