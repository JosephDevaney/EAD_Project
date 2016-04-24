<?php
/**
 * @author Joe Devaney & Darren Britton
 * definition of the Moves DAO (database access object)
 */
class MovesDAO {
    private $dbManager;
    function MovesDAO($DBMngr) {
        $this->dbManager = $DBMngr;
    }
    public function get($id = null) {
        $sql = "SELECT * ";
        $sql .= "FROM moves ";
        if ($id != null)
            $sql .= "WHERE moves.id=? ";
        $sql .= "ORDER BY moves.id ";

        $stmt = $this->dbManager->prepareQuery ( $sql );
        $this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
        $this->dbManager->executeQuery ( $stmt );
        $rows = $this->dbManager->fetchResults ( $stmt );

        return ($rows);
    }
    public function insert($parametersArray) {
        // insertion assumes that all the required parameters are defined and set
        $sql = "INSERT INTO moves (move_name, accuracy, pp, power) ";
        $sql .= "VALUES (?,?,?,?) ";

        $stmt = $this->dbManager->prepareQuery ( $sql );
        $this->dbManager->bindValue ( $stmt, 1, $parametersArray ["move_name"], PDO::PARAM_STR );
        $this->dbManager->bindValue ( $stmt, 2, $parametersArray ["accuracy"], PDO::PARAM_INT );
        $this->dbManager->bindValue ( $stmt, 3, $parametersArray ["pp"], PDO::PARAM_INT );
        $this->dbManager->bindValue ( $stmt, 4, $parametersArray ["power"], PDO::PARAM_INT );
        $this->dbManager->executeQuery ( $stmt );

        return ($this->dbManager->getLastInsertedID ());
    }
    public function update($parametersArray, $moveID) {
        $sql = 'UPDATE moves SET move_name=?, accuracy=?,pp=?,power=? WHERE move_id=?';
        $sql .= ';';

        $stmt = $this->dbManager->prepareQuery($sql);
        $this->dbManager->bindValue ( $stmt, 1, $parametersArray ["move_name"], PDO::PARAM_STR );
        $this->dbManager->bindValue ( $stmt, 2, $parametersArray ["accuracy"], PDO::PARAM_INT );
        $this->dbManager->bindValue ( $stmt, 3, $parametersArray ["pp"], PDO::PARAM_INT );
        $this->dbManager->bindValue ( $stmt, 4, $parametersArray ["power"], PDO::PARAM_INT );
        $this->dbManager->bindValue($stmt, 5, $moveID, PDO::PARAM_INT);
        $res = $this->dbManager->executeQuery ( $stmt );

        return $this->dbManager->getLastInsertedID();
    }
    public function delete($moveID) {
        $sql = 'DELETE FROM users WHERE id=?';
        $sql .= ';';

        $stmt = $this->dbManager->prepareQuery($sql);
        $this->dbManager->bindValue($stmt, 1, $moveID, PDO::PARAM_INT);
        $res = $this->dbManager->executeQuery ( $stmt );

        return $moveID;
    }
    public function purge() {
        //TODO
        $sql = 'TRUNCATE moves';
        $sql .= ';';

        $stmt = $this->dbManager->prepareQuery($sql);
        $this->dbManager->executeQuery ( $stmt );

        return true;
    }
    public function search($str) {
        $sql = "SELECT * ";
        $sql .= "FROM moves ";
        $sql .= "WHERE move_name LIKE ? ";
        $sql .= "ORDER BY move_name ";
        $sql .= ";";

        $stmt = $this->dbManager->prepareQuery( $sql );
        $this->dbManager->bindValue($stmt, 1, "%".$str."%", PDO::PARAM_STR);
        $this->dbManager->executeQuery ( $stmt );

        $arrayOfResults = $this->dbManager->fetchResults ( $stmt );
        return $arrayOfResults;
    }
}
?>
