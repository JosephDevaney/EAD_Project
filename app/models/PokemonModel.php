<?php
/**
 * Created by PhpStorm.
 * User: Journeyman
 * Date: 23/04/2016
 * Time: 18:18
 */

require_once('models/BaseModel.php');

class PokemonModel extends BaseModel {
    
    public function getAllPokemon() {
        return ($this->getAll ());
    }
    public function getPokemon($PokemonID) {
        return $this->get($PokemonID);
    }

    /**
     *
     * @param array $newPokemon :
     *            an associative array containing the detail of the new user
     * @return bool
     */
    public function createNewPokemon($newPokemon) {
        // validation of the values of the new user
        $newPokemonValidation = array(array('label'=>'id','value'=>$newPokemon ["id"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'name','value'=>$newPokemon ["name"], 'type'=>'string'),
            array('label'=>'weight','value'=>$newPokemon ["weight"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'height','value'=>$newPokemon ["height"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'hp','value'=>$newPokemon ["hp"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move1_id','value'=>$newPokemon ["move1_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move2_id','value'=>$newPokemon ["move2_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move3_id','value'=>$newPokemon ["move3_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move4_id','value'=>$newPokemon ["move4_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000));

        return $this->create($newPokemonValidation);

    }
    public function updatePokemon($pokemonID, $newPokemonRepresentation) {
        $newPokemonValidation = array(array('label'=>'id','value'=>$newPokemonRepresentation ["id"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'name','value'=>$newPokemonRepresentation ["name"], 'type'=>'string'),
            array('label'=>'weight','value'=>$newPokemonRepresentation ["weight"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'height','value'=>$newPokemonRepresentation ["height"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'hp','value'=>$newPokemonRepresentation ["hp"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move1_id','value'=>$newPokemonRepresentation ["move1_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move2_id','value'=>$newPokemonRepresentation ["move2_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move3_id','value'=>$newPokemonRepresentation ["move3_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move4_id','value'=>$newPokemonRepresentation ["move4_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000));

        return $this->update($pokemonID, $newPokemonValidation);
    }
    public function searchPokemon($string) {
        return $this->search($string);
    }
    public function deletePokemon($pokemonID) {
        return $this->delete($pokemonID);
    }
    public function purgePokemon() {
        return $this->purge();
    }
}
