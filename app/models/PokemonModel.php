<?php
/**
 * Created by PhpStorm.
 * User: Journeyman
 * Date: 23/04/2016
 * Time: 18:18
 */

require_once "DB/pdoDbManager.php";
require_once "DB/DAO/PokemonDAO.php";
require_once "Validation.php";
class PokemonModel {
    private $PokemonDAO; // list of DAOs used by this model
    private $dbmanager; // dbmanager
    public $apiResponse; // api response
    private $validationSuite; // contains functions for validating inputs
    public function __construct() {
        $this->dbmanager = new pdoDbManager ();
        $this->PokemonDAO= new PokemonDAO ( $this->dbmanager );
        $this->dbmanager->openConnection ();
        $this->validationSuite = new Validation ();
    }
    public function getAllPokemon() {
        return ($this->PokemonDAO->get ());
    }
    public function getPokemon($PokemonID) {
        if (is_numeric ( $PokemonID ))
            return ($this->PokemonDAO->get ( $PokemonID ));

        return false;
    }

    /**
     *
     * @param array $newPokemon :
     *            an associative array containing the detail of the new user
     * @return bool
     */
    public function createNewPokemon($newPokemon) {
        // validation of the values of the new user

        // compulsory values
        if (! empty ( $newPokemon ["id"] ) && ! empty ( $newPokemon ["name"] ) && ! empty ( $newPokemon ["weight"] ) &&
            ! empty ( $newPokemon ["height"] ) && ! empty ( $newPokemon ["hp"] && ! empty ( $newPokemon ["move1_id"] ) )&&
            ! empty ( $newPokemon ["move2_id"] ) && ! empty ( $newPokemon ["move3_id"] && ! empty ( $newPokemon ["move4_id"] ) )) {
            /*
             * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
             */

            if (($this->validationSuite->isLengthStringValid ( $newPokemon ["name"], TABLE_USER_NAME_LENGTH )) &&
                $this->validationSuite->isNumberInRangeValid($newPokemon["id"]) &&
                $this->validationSuite->isNumberInRangeValid($newPokemon["height"]) &&
                $this->validationSuite->isNumberInRangeValid($newPokemon["weight"]) &&
                $this->validationSuite->isNumberInRangeValid($newPokemon["hp"]) &&
                $this->validationSuite->isNumberInRangeValid($newPokemon["move1_id"]) &&
                ($newPokemon["move2_id"] == null || $this->validationSuite->isNumberInRangeValid($newPokemon["move2_id"])) &&
                ($newPokemon["move3_id"] == null || $this->validationSuite->isNumberInRangeValid($newPokemon["move3_id"])) &&
                ($newPokemon["move4_id"] == null || $this->validationSuite->isNumberInRangeValid($newPokemon["move4_id"])) ){
                if ($newId = $this->UsersDAO->insert ( $newPokemon ))
                    return ($newId);
            }
        }

        // if validation fails or insertion fails
        return (false);
    }
    public function updatePokemon($pokemonID, $newPokemonRepresentation) {
        if (! empty ( $newPokemon ["id"] ) && ! empty ( $newPokemon ["name"] ) && ! empty ( $newPokemon ["weight"] ) &&
        ! empty ( $newPokemon ["height"] ) && ! empty ( $newPokemon ["hp"] && ! empty ( $newPokemon ["move1_id"] ) )&&
        ! empty ( $newPokemon ["move2_id"] ) && ! empty ( $newPokemon ["move3_id"] && ! empty ( $newPokemon ["move4_id"] ) )) {
            /*
             * the model knows the representation of a user in the database and this is: name: varchar(25) surname: varchar(25) email: varchar(50) password: varchar(40)
             */

            if (($this->validationSuite->isLengthStringValid ( $newPokemon ["name"], TABLE_USER_NAME_LENGTH )) &&
            $this->validationSuite->isNumberInRangeValid($pokemonID) &&
            $this->validationSuite->isNumberInRangeValid($newPokemon["height"]) &&
            $this->validationSuite->isNumberInRangeValid($newPokemon["weight"]) &&
            $this->validationSuite->isNumberInRangeValid($newPokemon["hp"]) &&
            $this->validationSuite->isNumberInRangeValid($newPokemon["move1_id"]) &&
            ($newPokemon["move2_id"] == null || $this->validationSuite->isNumberInRangeValid($newPokemon["move2_id"])) &&
            ($newPokemon["move3_id"] == null || $this->validationSuite->isNumberInRangeValid($newPokemon["move3_id"])) &&
            ($newPokemon["move4_id"] == null || $this->validationSuite->isNumberInRangeValid($newPokemon["move4_id"])) ){

                if ($pokemonID = $this->UsersDAO->update( $newPokemonRepresentation, $pokemonID ))
                    return ($pokemonID);
            }
        }

        return (false);
    }
    public function searchPokemon($string) {
        //TODO
        if (is_string( $string ))
            return ($this->PokemonDAO->search( $string ));

        return false;
    }
    public function deletePokemon($pokemonID) {
        if ($pokemonID != null) {
            if ($id = $this->PokemonDAO->delete($pokemonID)) {
                return ($id);
            }
        }
        return (false);
    }
    public function __destruct() {
        $this->PokemonDAO = null;
        $this->dbmanager->closeConnection ();
    }
}
