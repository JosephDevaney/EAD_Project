<?php
/**
 * @author Luca
 * definition of the User DAO (database access object)
 */
class UsersDAO {
	private $dbManager;
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		if ($id != null)
			$sql .= "WHERE users.id=? ";
		$sql .= "ORDER BY users.name ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return ($rows);
	}
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
		$sql = "INSERT INTO users (username, name, surname, email, password) ";
		$sql .= "VALUES (?,?,?,?,?) ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["username"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["surname"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["email"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 5, $parametersArray ["password"], $this->dbManager->STRING_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($parametersArray, $userID) {
		//TODO
		$sql = 'UPDATE users SET name=?, surname=?,email=?,password=? WHERE id=?';
		$sql .= ';';
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->bindValue($stmt, 1, $parametersArray["name"], PDO::PARAM_STR);
		$this->dbManager->bindValue($stmt, 2, $parametersArray["surname"], PDO::PARAM_STR);
		$this->dbManager->bindValue($stmt, 3, $parametersArray["email"], PDO::PARAM_STR);
		$this->dbManager->bindValue($stmt, 4, $parametersArray["password"], PDO::PARAM_STR);
		$this->dbManager->bindValue($stmt, 5, $userID, PDO::PARAM_INT);
		$res = $this->dbManager->executeQuery ( $stmt );
		
		var_dump($this->dbManager->getLastInsertedID());
		return $this->dbManager->getLastInsertedID();
	}
	public function delete($userID) {
		//TODO
		$sql = 'DELETE FROM users WHERE id=?';
		$sql .= ';';
		
		$stmt = $this->dbManager->prepareQuery($sql);
		$this->dbManager->bindValue($stmt, 1, $userID, PDO::PARAM_INT);
		$res = $this->dbManager->executeQuery ( $stmt );
		
		return $userID;
	}
	public function search($str) {
		//TODO
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE NAME LIKE ? ";
		$sql .= "OR SURNAME LIKE ? ";
		$sql .= "ORDER BY users.name ";
		$sql .= ";";
		
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager->bindValue($stmt, 1, "%".$str."%", PDO::PARAM_STR);
		$this->dbManager->bindValue($stmt, 2, "%".$str."%", PDO::PARAM_STR);
		$this->dbManager->executeQuery ( $stmt );
		
		$arrayOfResults = $this->dbManager->fetchResults ( $stmt );
		return $arrayOfResults;
	}
	
	public function searchUsername($str) {
		//TODO
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE USERNAME = ? ";
		$sql .= "ORDER BY users.name ";
		$sql .= ";";
	
		$stmt = $this->dbManager->prepareQuery( $sql );
		$this->dbManager->bindValue($stmt, 1, $str, PDO::PARAM_STR);
		$this->dbManager->executeQuery ( $stmt );
	
		$arrayOfResults = $this->dbManager->fetchResults ( $stmt );
		return $arrayOfResults;
	}
}
?>
