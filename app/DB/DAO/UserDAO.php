<?php
/**
 * @author Luca
 * definition of the User DAO (database access object)
 */
require_once("DB/DAO/BaseDAO.php");
class UserDAO extends BaseDAO{
    function __construct($DBmgr)
    {
        parent::__construct($DBmgr);
    }

    function UserDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	public function get($id = null) {
        return ($this->base_get($id, "users", "id", "name"));
	}
	public function insert($parametersArray) {
		// insertion assumes that all the required parameters are defined and set
        $sql = "INSERT INTO users (username, name, surname, email, password) ";
        $sql .= "VALUES (:username,:name,:surname,:email,:password) ";
        
        $values = $this->get_types($parametersArray);
		
		return ($this->base_insert($sql, $values));
	}
	public function update($parametersArray, $userID) {
		$sql = 'UPDATE users SET username=:username, name=:name, surname=:surname,email=:email,password=:password WHERE id=:id';
		$sql .= ';';
        $parametersArray['id'] = $userID;
        $values = $this->get_types($parametersArray);

        $this->base_update($sql, $values);

		return $userID;
	}
	public function delete($userID) {
		return $this->base_delete("users", "id", array('id'=>$userID));
	}
	public function purge() {
		return $this->base_purge("users");
	}
	
	public function searchUsername($str) {
		//TODO
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "WHERE USERNAME LIKE :username ";
		$sql .= "ORDER BY username ";
		$sql .= ";";
        $str = '%' . $str . '%';
		$values = $this->get_types(array('username'=>$str));

		return $this->base_search($sql, $values);
	}

}
