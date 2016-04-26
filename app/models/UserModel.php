<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/UsersDAO.php";
require_once "Validation.php";
class UserModel {
	private $UsersDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->UsersDAO = new UsersDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getUsers() {
		return ($this->UsersDAO->get ());
	}
	public function getUser($userID) {
		if (is_numeric ( $userID ))
			return ($this->UsersDAO->get ( $userID ));
		
		return false;
	}

	/**
	 *
	 * @param array $UserRepresentation :
	 *            an associative array containing the detail of the new user
	 * @return bool
	 */
	public function createNewUser($newUser) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newUser ["name"] ) && ! empty ( $newUser ["surname"] ) && ! empty ( $newUser ["email"] ) && ! empty ( $newUser ["password"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
			
			if (($this->validationSuite->isLengthStringValid ( $newUser ["name"], TABLE_USER_NAME_LENGTH )) && 
					($this->validationSuite->isLengthStringValid ( $newUser ["surname"], TABLE_USER_SURNAME_LENGTH )) && 
					($this->validationSuite->isLengthStringValid ( $newUser ["email"], TABLE_USER_EMAIL_LENGTH )) && 
					($this->validationSuite->isLengthStringValid ( $newUser ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
				if ($newId = $this->UsersDAO->insert ( $newUser ))
					return ($newId);
			}
		}
		
		// if validation fails or insertion fails
		return (false);
	}
	public function updateUsers($userID, $newUserRepresentation) {
		//TODO
//		var_dump($newUserRepresentation);
		if (! empty ( $newUserRepresentation ["name"] ) && ! empty ( $newUserRepresentation ["surname"] ) && ! empty ( $newUserRepresentation ["email"] ) && ! empty ( $newUserRepresentation ["password"] )) {
			/*
			 * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
			 */
//					var_dump($newUserRepresentation);
				
			if (($this->validationSuite->isLengthStringValid ( $newUserRepresentation ["name"], TABLE_USER_NAME_LENGTH )) &&
					($this->validationSuite->isLengthStringValid ( $newUserRepresentation ["surname"], TABLE_USER_SURNAME_LENGTH )) &&
					($this->validationSuite->isLengthStringValid ( $newUserRepresentation ["email"], TABLE_USER_EMAIL_LENGTH )) &&
					($this->validationSuite->isLengthStringValid ( $newUserRepresentation ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
						if ($userID = $this->UsersDAO->update( $newUserRepresentation, $userID ))
//							var_dump($userID);
							return ($userID);
					}
		}
		
		return (false);
	}
	public function searchUsers($string) {
		//TODO
		if (is_string( $string ))
			return ($this->UsersDAO->search( $string ));
		
		return false;
	}
	public function authenticateUser($parameters) {
		$username = $parameters["username"];
		$pwd = $parameters["password"];
		if (is_string( $username ) && is_string($pwd)) {
			$users = $this->UsersDAO->searchUsername( $username );
			foreach ($users as $u) {
				if ($u["password"] == $pwd)
					return true;
			}
		}
	
		return false;
	}
	public function deleteUser($userID) {
		//TODO
		if ($userID != null) {
			if ($id = $this->UsersDAO->delete($userID)) {
				return ($id);
			}
		}
		return (false);
	}
	public function purgeUsers() {
        return $this->UsersDAO->purge();
	}
	public function __destruct() {
		$this->UsersDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>