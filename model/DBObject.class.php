<?php
	include_once "DB.class.php";
	
abstract class DBObject {
	
	/* === Fields === */
	protected $id = 0;
	
	/* === Collection (a.k.a. table) name === */
	const COLLECTION_NAME = "generic";

	public function __construct($data = array()) {
		// if $data is not empty, call the respective setter
		if ($data) {
			foreach ($data as $key => $value) {
				$setterName = 'set' . ucfirst($key);
				// if Argument is invalid, ignore it
				if (method_exists($this, $setterName)) {
					$this->$setterName($value);
				}
			}
		}
	}

	public function  __toString() {
		return "Not implemented yet.";
	}

	/* === Getter & Setter === */

	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		$this->id = intval($value);
	}

	/* === Virtual getters === */
        
	public function toArray($withID = true) {
		$attribute = get_object_vars($this);
		if ($withID === false) {
			// if $withID is false, remove primary key
			unset($attribute['id']);
		}
		return $attribute;
	}
	
	/* === Persistence-Methods === */

	public function upsert() {
		$fields = "";
		$fieldsPDO = "";
		$farray = $this->toArray(false);
		foreach($farray as $key => $val) {
			$fields .= ", ";
			$fields .= "\"".$key."\"";
		}
		foreach($farray as $key => $val) {
			$fieldsPDO .= ", :";
			$fieldsPDO .= $key;
		}
		$fields = substr($fields, 1);
		$fieldsPDO = substr($fieldsPDO, 2);
		
		if($this->getId() == 0) {
			$sql = "INSERT INTO ".static::COLLECTION_NAME
					."($fields) VALUES ($fieldsPDO)";
		} else {
			$sql = "";
			throw new Exception('Not implemented yet.');
		}
		
		$query = DB::getDB()->prepare($sql);
		$query->execute($this->toArray(false));
		
		// get ID from DB and set it
		$this->setId(DB::getDB()->lastInsertId(static::COLLECTION_NAME."_id_seq"));
	}

	public function delete() {
		throw new Exception('Not implemented yet.');
	}

	/* === Static Methods === */

	public static function clearTable() {
		$sql = "TRUNCATE ".static::COLLECTION_NAME." RESTART IDENTITY";
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
 		return $query->fetch();
	}

	public static function find($id) {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." WHERE id=?";
		$query = DB::getDB()->prepare($sql);
		$query->execute(array($id));
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetch();
	}

	public static function findAll() {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." ORDER BY id";
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
	
	public static function getAmount() {
		$sql = "SELECT count(*) FROM ".static::COLLECTION_NAME;
		$query = DB::getDB()->query($sql);
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
 		return $query->fetch();
	}

	public static function findBySomething($something, $fieldName) {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME." WHERE \"$fieldName\" = :something";
		$options["something"] = $something;
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
	
	public static function findBySomethingAmount($something, $fieldName) {
		$sql = "SELECT count(*) FROM ".static::COLLECTION_NAME." WHERE \"$fieldName\" = :something";
		$options["something"] = $something;
		$query = DB::getDB()->prepare($sql);
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
		return $query->fetch();
	}
	
	public static function getListByColumn($column) {
		$sql = "SELECT DISTINCT $column AS values FROM ".static::COLLECTION_NAME." ORDER BY values";
		$query = DB::getDB()->prepare($sql);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_COLUMN, 0);
		return $query->fetchAll();
	}
	
	/* === Pagination === */
	public static function findByPage($recordsPerPage, $page) {
		$sql = "SELECT * FROM ".static::COLLECTION_NAME
				." ORDER BY id limit :limit offset :offset";
		$query = DB::getDB()->prepare($sql);
		$options['limit'] = $recordsPerPage;		
		$options['offset'] = $recordsPerPage*($page-1);	
		$query->execute($options);
		$query->setFetchMode(PDO::FETCH_CLASS, get_class(new static()));
		return $query->fetchAll();
	}
}
?>