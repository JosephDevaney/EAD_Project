<?php
require_once('models/BaseModel.php');

class UserModel extends BaseModel{
    
	public function getUsers() {
		return ($this->getAll ());
	}
	public function getUser($userID) {
        return ($this->get($userID));
	}

	/**
	 *
	 * @param array $UserRepresentation :
	 *            an associative array containing the detail of the new user
	 * @return bool
	 */
	public function createNewUser($newUser) {
		// validation of the values of the new user

        $newUserValidation = array(array('label'=>'username','value'=>$newUser ["username"], 'type'=>'string'),
            array('label'=>'name','value'=>$newUser ["name"], 'type'=>'string'),
            array('label'=>'surname','value'=>$newUser ["surname"], 'type'=>'string'),
            array('label'=>'email','value'=>$newUser ["email"], 'type'=>'string'),
            array('label'=>'password','value'=>$newUser ["password"], 'type'=>'string'));
		
        return ($this->create($newUserValidation));
	}
	public function updateUsers($userID, $newUserRepresentation) {
        $newUserValidation = array(array('label'=>'username','value'=>$newUserRepresentation ["username"], 'type'=>'string'),
            array('label'=>'name','value'=>$newUserRepresentation ["name"], 'type'=>'string'),
            array('label'=>'surname','value'=>$newUserRepresentation ["surname"], 'type'=>'string'),
            array('label'=>'email','value'=>$newUserRepresentation ["email"], 'type'=>'string'),
            array('label'=>'password','value'=>$newUserRepresentation ["password"], 'type'=>'string'));

        return ($this->update($userID, $newUserValidation));
	}
	public function searchUsers($string) {
        return $this->search($string);
	}
	public function authenticateUser($parameters) {
		$username = $parameters["username"];
		$pwd = $parameters["password"];
		if (is_string( $username ) && is_string($pwd)) {
			$users = $this->UserDAO->searchUsername( $username );
			foreach ($users as $u) {
				//if (password_verify($pwd,$u["password"]))
				if ($pwd == $u["password"])
					return true;
			}
		}
	
		return false;
	}
	public function deleteUser($userID) {
        return $this->delete($userID);
	}
	public function purgeUsers() {
        return $this->purge();
	}
}