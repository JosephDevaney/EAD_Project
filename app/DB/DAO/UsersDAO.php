<?php
/**
 * @author Luca
 * definition of the User DAO (database access object)
 */
require_once("DB/DAO/BaseDAO.php");
class UsersDAO extends BaseDAO{
    function __construct($DBmgr)
    {
        parent::__construct($DBmgr);
    }

    function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id = null) {
        return ($this->base_get($id, "users", "id", "name"));
	}
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
        $sql = "INSERT INTO users (username, name, surname, email, password) ";
        $sql .= "VALUES (?,?,?,?,?) ";
        $values = array($parametersArray["username"] => PDO::PARAM_STR, $parametersArray["name"] => PDO::PARAM_STR,
            $parametersArray ["surname"] => PDO::PARAM_STR, $parametersArray ["email"] => PDO::PARAM_STR, $parametersArray["password"] => PDO::PARAM_STR);
		
		return ($this->base_insert($sql, $values));
	}
	public function update($parametersArray, $userID) {
		$sql = 'UPDATE users SET username=?, name=?, surname=?,email=?,password=? WHERE id=?';
		$sql .= ';';

        $values = array($parametersArray["username"] => PDO::PARAM_STR, $parametersArray ["name"] => PDO::PARAM_STR,
            $parametersArray ["surname"] => PDO::PARAM_STR, $parametersArray ["email"] => PDO::PARAM_STR,
            $parametersArray ["password"] => PDO::PARAM_STR, $userID => PDO::PARAM_INT);

        $this->base_update($sql, $values);

		return $userID;
	}
	public function delete($userID) {
		return $this->base_delete("users", "id", $userID);
	}
	public function purge() {
		return $this->base_purge("users");
	}
	public function search($str) {
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE NAME LIKE %?% ";
		$sql .= "OR SURNAME LIKE %?% ";
		$sql .= "ORDER BY users.name ";
		$sql .= ";";

		return $this->base_search($sql, array($str => PDO::PARAM_STR, $str => PDO::PARAM_STR));
	}
	
	public function searchUsername($str) {
		//TODO
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE USERNAME = ? ";
		$sql .= "ORDER BY users.name ";
		$sql .= ";";

		return $this->base_search($sql, array($str => PDO::PARAM_STR));
	}

}
