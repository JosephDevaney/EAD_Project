<?php

require_once("DB/DAO/BaseDAO.php");
class PokemonDAO extends BaseDAO{
    function __construct($DBmgr)
    {
        parent::__construct($DBmgr);
    }

    function PokemonDAO($DBMngr) {
        $this->dbManager = $DBMngr;
    }

    public function get($id = null) {
        return ($this->base_get($id, "pokemon", "id", "id"));
    }
    public function insert($parametersArray) {
        $sql = "INSERT INTO pokemon (id, name, height, weight, hp, move1_id, move2_id, move3_id, move4_id) ";
        $sql .= "VALUES (:id,:name,:height,:weight,:hp,:move1_id,:move2_id,:move3_id,:move4_id) ";

        $values = $this->get_types($parametersArray);

        $this->base_insert($sql, $values);
        return $parametersArray['id'];
    }
    public function update($parametersArray, $pokemon_ID) {
        $sql = 'UPDATE pokemon SET id=:id, name=:name, height=:height,weight=:weight,hp=:hp,move1_id=:move1_id,move2_id=:move2_id,move3_id=:move3_id,move4_id=:move4_id WHERE id=:id';
        $sql .= ';';

        $parametersArray['id'] = $pokemon_ID;
        $values = $this->get_types($parametersArray);

        $this->base_update($sql, $values);

        return $pokemon_ID;
    }
    public function delete($pokemon_id) {
        return $this->base_delete("pokemon", "id", array('id'=>$pokemon_id));
    }
    public function search($str) {
        $sql = "SELECT * ";
        $sql .= "FROM pokemon ";
        $sql .= "WHERE NAME LIKE :name ";
        $sql .= "ORDER BY pokemon.id ";
        $sql .= ";";

        $values = $this->get_types(array('name'=>'%'.$str.'%'));
        return $this->base_search($sql, $values);
    }

    public function purge() {
        return $this->base_purge("pokemon");
    }
    
}

