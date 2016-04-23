<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/UsersDAO.php";
require_once "Validation.php";
class MovesModel {
    private $MovesDAO; // list of DAOs used by this model
    private $dbmanager; // dbmanager
    public $apiResponse; // api response
    private $validationSuite; // contains functions for validating inputs
    public function __construct() {
        $this->dbmanager = new pdoDbManager ();
        $this->MovesDAO = new MovesDAO ( $this->dbmanager );
        $this->dbmanager->openConnection ();
        $this->validationSuite = new Validation ();
    }
    public function getMoves() {
        return ($this->MovesDAO->get ());
    }
    public function getMove($userID) {
        if (is_numeric ( $userID ))
            return ($this->MovesDAO->get ( $userID ));

        return false;
    }
    /**
     *
     * @param array $MoveRepresentation:
     *        	an associative array containing the detail of the new move
     */
    public function createNewMove($newMove) {
        // validation of the values of the new move

        // compulsory values
        if (! empty ( $newMove ["move_name"] ) && ! empty ( $newMove ["accuracy"] ) && ! empty ( $newMove ["pp"] ) && ! empty ( $newMove ["power"] )) {
            /*
             * the model knows the representation of a move in the database: move_name: varchar(30) accuracy: int(11) pp: int(11) power: int(11)
             */

            if (($this->validationSuite->isLengthStringValid ( $newMove ["move_name"], TABLE_MOVE_NAME_LENGTH )) &&
            ($this->validationSuite->isNumberInRangeValid( $newMove ["accuracy"])) &&
            ($this->validationSuite->isNumberInRangeValid( $newMove ["pp"])) &&
            ($this->validationSuite->isNumberInRangeValid( $newMove ["power"]))) {
                if ($newId = $this->MovesDAODAO->insert ( $newMove ))
                    return ($newId);
            }
        }

        // if validation fails or insertion fails
        return (false);
    }
    public function updateMove($moveID, $newMoveRepresentation) {
        // compulsory values
        if (! empty ( $newMove ["move_name"] ) && ! empty ( $newMove ["accuracy"] ) && ! empty ( $newMove ["pp"] ) && ! empty ( $newMove ["power"] )) {
            /*
             * the model knows the representation of a move in the database: move_name: varchar(30) accuracy: int(11) pp: int(11) power: int(11)
             */

            if (($this->validationSuite->isLengthStringValid ( $newMove ["move_name"], TABLE_MOVE_NAME_LENGTH )) &&
            ($this->validationSuite->isNumberInRangeValid( $newMove ["accuracy"])) &&
            ($this->validationSuite->isNumberInRangeValid( $newMove ["pp"])) &&
            ($this->validationSuite->isNumberInRangeValid( $newMove ["power"]))) {
                if ($moveID = $this->MovesDAO->update( $newMoveRepresentation, $moveID ))
                    return ($moveID);
            }
        }

        return (false);
    }
    public function deleteMove($moveID) {
        //TODO
        if ($moveID != null) {
            if ($id = $this->MovesDAO->delete($moveID)) {
                return ($id);
            }
        }
        return (false);
    }
    public function searchMoves($string) {
        //TODO
        if (is_string( $string ))
            return ($this->MovesDAO->search( $string ));

        return false;
    }
    public function __destruct() {
        $this->MovesDAO = null;
        $this->dbmanager->closeConnection ();
    }
}
?>