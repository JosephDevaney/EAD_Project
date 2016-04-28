<?php
require_once "DB/pdoDbManager.php";
require_once "Validation.php";
class BaseModel {
    private $DAO; // list of DAOs used by this model
    private $dbmanager; // dbmanager
    private $extendingClass;
    public $apiResponse; // api response
    private $validationSuite; // contains functions for validating inputs
    public function __construct() {
        $this->extendingClass = substr(get_class($this),0,-5);
        $DaoName = $this->extendingClass . 'DAO';
        require_once "DB/DAO/". $DaoName .".php";
        $this->dbmanager = new pdoDbManager ();
        $this->DAO = new $$DaoName ( $this->dbmanager );
        $this->dbmanager->openConnection ();
        $this->validationSuite = new Validation ();
    }
    public function getAll() {
        return ($this->DAO->get ());
    }
    public function get($id) {
        if (is_numeric ( $id ))
            return ($this->DAO->get ( $id ));

        return false;
    }
    /**
     *
     * @param array $MoveRepresentation:
     *        	an associative array containing the detail of the new move
     */

    private function validateParams($params){
        // validation of the values of the new move
        foreach($params as $value){
            $pass = false;
            if(!empty($value['value'])){
                if($value['expectedType'] == 'numeric'){
                    if(array_key_exists($value,'min') && array_key_exists($value,'max'))
                        $pass = $this->validationSuite->isNumberInRangeValid( $value ["value"], $value['min'], $value[max]);
                    else
                        $pass = $this->validationSuite->isNumberInRangeValid( $value ["value"]);
                }
                else if($value['expectedType'] == 'string'){
                    $pass = $this->validationSuite->isLengthStringValid ( $value ["value"], constant('TABLE_'. strtoupper($this->extendingClass) .'_LENGTH' ));
                }

            }
            if(!pass) return false;
        }

        return true;
    }

    private function unpackParams($params){
        $unpackedParams = array();
        foreach ($params as $value){
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

    public function update($moveID, $newMoveRepresentation) {
        if($this->validateParams($newMoveRepresentation)){
            if($id = $this->DAO->update($this->unpackParams($newMoveRepresentation, $moveID)))
                return $id;
        }

        return false;
    }


    public function delete($id) {
        //TODO
        if ($id != null) {
            if ($id = $this->DAO->delete($id)) {
                return ($id);
            }
        }
        return (false);
    }
    public function purge() {
        return $this->DAO->purge();
    }
    public function search($string) {
        //TODO
        if (is_string( $string ))
            return ($this->DAO->search( $string ));

        return false;
    }
    public function __destruct() {
        $this->DAO = null;
        $this->dbmanager->closeConnection ();
    }
}
?>