<?php
/**
 * Created by PhpStorm.
 * User: Journeyman
 * Date: 23/04/2016
 * Time: 15:39
 */

class PokemonDAO {
    private $dbManager;
    function PokemonDAO($DBMngr) {
        $this->dbManager = $DBMngr;
    }

    public function get($id = null) {
        $sql = "SELECT * ";
        $sql .= "FROM pokemon ";
        if ($id != null)
            $sql .= "WHERE pokemon.id=? ";
        $sql .= "ORDER BY pokemon.id ";

        $stmt = $this->dbManager->prepareQuery ( $sql );
        $this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
        $this->dbManager->executeQuery ( $stmt );
        $rows = $this->dbManager->fetchResults ( $stmt );

        return ($rows);
    }
    public function insert($parametersArray) {
        // insertion assumes that all the required parameters are defined and set
        $sql = "INSERT INTO pokemon (id, name, height, weight, hp, move1_id, move2_id, move3_id, move4_id) ";
        $sql .= "VALUES (?,?,?,?,?,?,?,?,?) ";

        $stmt = $this->dbManager->prepareQuery ( $sql );
        $this->dbManager->bindValue ( $stmt, 1, $parametersArray ["id"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 2, $parametersArray ["name"], PDO::STRING_TYPE );
        $this->dbManager->bindValue ( $stmt, 3, $parametersArray ["height"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 4, $parametersArray ["weight"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 5, $parametersArray ["hp"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 6, $parametersArray ["move1_id"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 7, $parametersArray ["move2_id"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 8, $parametersArray ["move3_id"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 9, $parametersArray ["move4_id"], PDO::INT_TYPE );
        $this->dbManager->executeQuery ( $stmt );

        return ($this->dbManager->getLastInsertedID ());
    }
    public function update($parametersArray, $pokemon_ID) {
        $sql = 'UPDATE pokemon SET name=?, height=?,weight=?,hp=?,move1_id=?,move2_id=?,move3_id=?,move4_id=? WHERE id=?';
        $sql .= ';';

        $stmt = $this->dbManager->prepareQuery($sql);
        $this->dbManager->bindValue ( $stmt, 2, $parametersArray ["name"], PDO::STRING_TYPE );
        $this->dbManager->bindValue ( $stmt, 3, $parametersArray ["height"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 4, $parametersArray ["weight"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 5, $parametersArray ["hp"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 6, $parametersArray ["move1_id"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 7, $parametersArray ["move2_id"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 8, $parametersArray ["move3_id"], PDO::INT_TYPE );
        $this->dbManager->bindValue ( $stmt, 9, $parametersArray ["move4_id"], PDO::INT_TYPE );
        $this->dbManager->bindValue($stmt, 5, $pokemon_ID, PDO::PARAM_INT);
        $this->dbManager->executeQuery ( $stmt );

        return $this->dbManager->getLastInsertedID();
    }
    public function delete($pokemon_id) {
        $sql = 'DELETE FROM pokemon WHERE id=?';
        $sql .= ';';

        $stmt = $this->dbManager->prepareQuery($sql);
        $this->dbManager->bindValue($stmt, 1, $pokemon_id, PDO::PARAM_INT);
        $this->dbManager->executeQuery ( $stmt );

        return $pokemon_id;
    }
    public function search($str) {
        $sql = "SELECT * ";
        $sql .= "FROM pokemon ";
        $sql .= "WHERE NAME LIKE ? ";
        $sql .= "ORDER BY pokemon.id ";
        $sql .= ";";

        $stmt = $this->dbManager->prepareQuery( $sql );
        $this->dbManager->bindValue($stmt, 1, "%".$str."%", PDO::PARAM_STR);
        $this->dbManager->executeQuery ( $stmt );

        $arrayOfResults = $this->dbManager->fetchResults ( $stmt );
        return $arrayOfResults;
    }



}