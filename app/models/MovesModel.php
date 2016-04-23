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
    public function getUsers() {
        return ($this->MovesDAO->get ());
    }
    public function getUser($userID) {
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
    public function updateUsers($moveID, $newMoveRepresentation) {
        var_dump($newMoveRepresentation);
        if (! empty ( $newMoveRepresentation ["name"] ) && ! empty ( $newMoveRepresentation ["surname"] ) && ! empty ( $newMoveRepresentation ["email"] ) && ! empty ( $newMoveRepresentation ["password"] )) {
            /*
             * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
             */
            var_dump($newMoveRepresentation);

            if (($this->validationSuite->isLengthStringValid ( $newMoveRepresentation ["name"], TABLE_USER_NAME_LENGTH )) &&
                ($this->validationSuite->isLengthStringValid ( $newMoveRepresentation ["surname"], TABLE_USER_SURNAME_LENGTH )) &&
                ($this->validationSuite->isLengthStringValid ( $newMoveRepresentation ["email"], TABLE_USER_EMAIL_LENGTH )) &&
                ($this->validationSuite->isLengthStringValid ( $newMoveRepresentation ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
                if ($moveID = $this->UsersDAO->update( $newMoveRepresentation, $moveID ))
                    var_dump($moveID);
                return ($moveID);
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
    public function searchUsername($string) {
        //TODO
        if (is_string( $string ))
            return ($this->UsersDAO->searchUsername( $string ));

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
    public function __destruct() {
        $this->UsersDAO = null;
        $this->dbmanager->closeConnection ();
    }
}
?>