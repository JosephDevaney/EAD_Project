<?php
require_once('models/BaseModel.php');

class PokemonModel extends BaseModel {
    
    public function createNew($newPokemon) {
        $newPokemonValidation = $this->createValidationArray($newPokemon);
        return $this->create($newPokemonValidation);
    }
    public function updateExisting($pokemonID, $newPokemonRepresentation) {
        $newPokemonValidation = $this->createValidationArray($newPokemonRepresentation);
        return $this->update($pokemonID, $newPokemonValidation);
    }
    private function createValidationArray($params){
        return array(array('label'=>'id','value'=>$params ["id"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'name','value'=>$params ["name"], 'type'=>'string'),
            array('label'=>'weight','value'=>$params ["weight"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'height','value'=>$params ["height"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'hp','value'=>$params ["hp"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move1_id','value'=>$params ["move1_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move2_id','value'=>$params ["move2_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move3_id','value'=>$params ["move3_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000),
            array('label'=>'move4_id','value'=>$params ["move4_id"], 'type'=>'numeric', 'min'=>0, 'max'=>10000));
    }

}
