<?php
require_once "DB/pdoDbManager.php";
require_once "Validation.php";
abstract class BaseModel {

    protected $DAO; // list of DAOs used by this model
    protected $dbmanager; // dbmanager
    protected $extendingClass;
    public $apiResponse; // api response
    protected $validationSuite; // contains functions for validating inputs

    public function __construct() {
        $this->extendingClass = substr(get_class($this),0,-5);
        $DaoName = $this->extendingClass . 'DAO';
        require_once "DB/DAO/". $DaoName .".php";
        $this->dbmanager = new pdoDbManager ();
        $this->DAO = new $DaoName ( $this->dbmanager );
        $this->dbmanager->openConnection ();
        $this->validationSuite = new Validation ();
    }
    public function get($id=null) {
        if (is_numeric ( $id ) || $id == null)
            return ($this->DAO->get ( $id ));

        return false;
    }

    private function validateParams($params){
        foreach($params as $value){
            $pass = false;
            if(!empty($value['value'])){
                if($value['type'] == 'numeric'){
                    if(array_key_exists('min',$value) && array_key_exists('max',$value))
                        $pass = $this->validationSuite->isNumberInRangeValid( $value ["value"], $value['min'], $value['max']);
                    else
                        $pass = $this->validationSuite->isNumberInRangeValid( $value ["value"]);
                }
                else if($value['type'] == 'string'){
                    $pass = $this->validationSuite->isLengthStringValid ( $value ["value"], constant('TABLE_'. strtoupper($this->extendingClass . '_' .$value['label']) .'_LENGTH' ));
                }
            }
        }
        return $pass;
    }

    private function unpackParams($params){
        $unpackedParams = array();
        foreach ($params as $value){
            if($value['label'] == 'password')
                $unpackedParams[$value['label']] = password_hash($value['value'], PASSWORD_DEFAULT);
            else
                $unpackedParams[$value['label']] = $value['value'];
        }
        return $unpackedParams;
    }

    public function create($params) {
        if($this->validateParams($params)){
            if($id = $this->DAO->insert($this->unpackParams($params)))
                return $id;
        }
        return false;
    }

    public function update($updateID, $newRepresentation) {
        if($this->validateParams($newRepresentation)){
            if($id = $this->DAO->update($this->unpackParams($newRepresentation), $updateID))
                return $id;
        }
        return false;
    }

    public function delete($id) {
        if ($id != null) {
            if ($id = $this->DAO->delete($id)) {
                return ($id);
            }
        }
        return false;
    }

    public function purge() {
        return $this->DAO->purge();
    }

    public function search($string) {
        if (is_string( $string ))
            return ($this->DAO->search( $string ));

        return false;
    }

    public function __destruct() {
        $this->DAO = null;
        $this->dbmanager->closeConnection ();
    }
}
