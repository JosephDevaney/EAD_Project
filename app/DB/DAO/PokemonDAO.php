<?php
/**
 * Created by PhpStorm.
 * User: Journeyman
 * Date: 23/04/2016
 * Time: 15:39
 */
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
        // insertion assumes that all the required parameters are defined and set
        $sql = "INSERT INTO pokemon (id, name, height, weight, hp, move1_id, move2_id, move3_id, move4_id) ";
        $sql .= "VALUES (:id,:name,:height,:weight,:hp,:move1_id,:move2_id,:move3_id,:move4_id) ";

        $values = $this->get_types($parametersArray);

        $this->base_insert($sql, $values);
        return $parametersArray['id'];
    }
    public function update($parametersArray, $pokemon_ID) {
        $sql = 'UPDATE pokemon SET name=?, height=?,weight=?,hp=?,move1_id=?,move2_id=?,move3_id=?,move4_id=? WHERE id=?';
        $sql .= ';';

        $values = array($parametersArray["name"]=>PDO::PARAM_STR, $parametersArray["height"]=>PDO::PARAM_INT, $parametersArray["weight"]=>PDO::PARAM_INT,
            $parametersArray["hp"]=>PDO::PARAM_INT, $parametersArray["move1_id"]=>PDO::PARAM_INT, $parametersArray["move2_id"]=>PDO::PARAM_INT,
            $parametersArray["move3_id"]=>PDO::PARAM_INT, $parametersArray["move4_id"]=>PDO::PARAM_INT, $pokemon_ID=>PDO::PARAM_INT);

        $this->base_update($sql, $values);

        return $pokemon_ID;
    }
    public function delete($pokemon_id) {
        return $this->base_delete("pokemon", "id", $pokemon_id);
    }
    public function search($str) {
        $sql = "SELECT * ";
        $sql .= "FROM pokemon ";
        $sql .= "WHERE NAME LIKE %?% ";
        $sql .= "ORDER BY pokemon.id ";
        $sql .= ";";

        return $this->base_search($sql, array($str => PDO::PARAM_STR));
    }

    public function purge() {
        return $this->base_purge("pokemon");
    }
    
}

