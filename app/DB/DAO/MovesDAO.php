<?php
/**
 * @author Joe Devaney & Darren Britton
 * definition of the Moves DAO (database access object)
 */
require_once("DB/DAO/BaseDAO.php");
class MovesDAO extends BaseDAO {
    function __construct($DBmgr)
    {
        parent::__construct($DBmgr);
    }

    function MovesDAO($DBMngr) {
        $this->dbManager = $DBMngr;
    }
    public function get($id = null) {
        return ($this->base_get($id, "moves", "move_id", "move_id"));
    }
    public function insert($parametersArray) {
        // insertion assumes that all the required parameters are defined and set
        $sql = "INSERT INTO moves (move_name, accuracy, pp, power) ";
        $sql .= "VALUES (?,?,?,?) ";

        $values = array($parametersArray["move_name"]=>PDO::PARAM_STR, $parametersArray["accuracy"]=>PDO::PARAM_INT,
            $parametersArray["pp"]=>PDO::PARAM_INT, $parametersArray["power"]=>PDO::PARAM_INT);
        
        return ($this->base_insert($sql, $values));
    }
    public function update($parametersArray, $moveID) {
        $sql = 'UPDATE moves SET move_name=?, accuracy=?,pp=?,power=? WHERE move_id=?';
        $sql .= ';';

        $values = array($parametersArray["move_name"]=>PDO::PARAM_STR, $parametersArray["accuracy"]=>PDO::PARAM_INT,
            $parametersArray["pp"]=>PDO::PARAM_INT, $parametersArray["power"]=>PDO::PARAM_INT, $moveID=>PARAM_INT);

        $this->base_update($sql, $values);
        return $moveID;
    }
    public function delete($moveID) {
        return $this->base_delete("moves", "move_id", $moveID);
    }
    public function purge() {
        return $this->base_purge("moves");
    }
    public function search($str) {
        $sql = "SELECT * ";
        $sql .= "FROM moves ";
        $sql .= "WHERE move_name LIKE %?% ";
        $sql .= "ORDER BY move_name ";
        $sql .= ";";
        
        return $this->base_search($sql, array($str => PDO::PARAM_STR));
    }
}

