<?php
require_once('models/BaseModel.php');

class UserModel extends BaseModel{

	public function createNew($newUser) {
        $newUserValidation = $this->createValidationArray($newUser);
        return ($this->create($newUserValidation));
	}
	public function updateExisting($userID, $newUserRepresentation) {
        $newUserValidation = $this->createValidationArray($newUserRepresentation);
        return ($this->update($userID, $newUserValidation));
	}
	private function createValidationArray($params){
		return array(array('label'=>'username','value'=>$params ["username"], 'type'=>'string'),
            array('label'=>'name','value'=>$params ["name"], 'type'=>'string'),
            array('label'=>'surname','value'=>$params ["surname"], 'type'=>'string'),
            array('label'=>'email','value'=>$params ["email"], 'type'=>'string'),
            array('label'=>'password','value'=>$params ["password"], 'type'=>'string'));
	}
	public function authenticateUser($parameters) {
		$username = $parameters["username"];
		$pwd = $parameters["password"];
		if (is_string( $username ) && is_string($pwd)) {
			$users = $this->UsersDAO->searchUsername( $username );
			foreach ($users as $u) {
				//if (password_verify($pwd,$u["password"]))
				if ($pwd == $u["password"])
					return true;
			}
		}
	
		return false;
	}
}