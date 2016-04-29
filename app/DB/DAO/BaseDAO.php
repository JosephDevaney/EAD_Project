<?php
/**
 * Created by PhpStorm.
 * User: Journeyman
 * Date: 26/04/2016
 * Time: 13:38
 */

abstract class BaseDAO {
    protected $dbManager;

    function __construct($DBmgr)
    {
        $this->dbManager = $DBmgr;
    }

    protected function base_get($id = null, $table, $col, $orderCol) {
        $params = array();
        $sql = "SELECT * ";
        $sql .= "FROM " . $table . " ";
        if ($id != null) {
            $sql .= "WHERE " . $table . "." . $col . "=:". $col ." ";
            $params = array($col=>$id);
        }

        $sql .= "ORDER BY " . $table ."." . $orderCol;
        $sql .= ";";

//		$stmt = $this->dbManager->prepareQuery ( $sql );
//		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
        $values = $this->get_types($params);
        $stmt = $this->prepare_stmt($sql, $values);
        $this->dbManager->executeQuery ( $stmt );
        $rows = $this->dbManager->fetchResults ( $stmt );

        return ($rows);
    }
    protected function base_insert($sql, $values) {
        // insertion assumes that all the required parameters are defined and set
        $stmt = $this->prepare_stmt($sql, $values);

//		$stmt = $this->dbManager->prepareQuery ( $sql );
//		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["username"], $this->dbManager->STRING_TYPE );
//		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["name"], $this->dbManager->STRING_TYPE );
//		$this->dbManager->bindValue ( $stmt, 3, $parametersArray ["surname"], $this->dbManager->STRING_TYPE );
//		$this->dbManager->bindValue ( $stmt, 4, $parametersArray ["email"], $this->dbManager->STRING_TYPE );
//		$this->dbManager->bindValue ( $stmt, 5, $parametersArray ["password"], $this->dbManager->STRING_TYPE );
        $this->dbManager->executeQuery ( $stmt );

        return ($this->dbManager->getLastInsertedID ());
    }


    protected function base_update($sql, $values) {
        $stmt = $this->prepare_stmt($sql, $values);
//		$stmt = $this->dbManager->prepareQuery($sql);
//		$this->dbManager->bindValue($stmt, 1, $parametersArray ["username"], PDO::PARAM_STR);
//		$this->dbManager->bindValue($stmt, 2, $parametersArray["name"], PDO::PARAM_STR);
//		$this->dbManager->bindValue($stmt, 3, $parametersArray["surname"], PDO::PARAM_STR);
//		$this->dbManager->bindValue($stmt, 4, $parametersArray["email"], PDO::PARAM_STR);
//		$this->dbManager->bindValue($stmt, 5, $parametersArray["password"], PDO::PARAM_STR);
//		$this->dbManager->bindValue($stmt, 6, $userID, PDO::PARAM_INT);
        $res = $this->dbManager->executeQuery ( $stmt );

        return true;
    }
    
    protected function base_delete($table, $col, $params) {

        $values = $this->get_types($params);

        $sql = "DELETE FROM " . $table . " WHERE " . $col . "=:". $col;
        $sql .= ';';

//		$stmt = $this->dbManager->prepareQuery($sql);
//		$this->dbManager->bindValue($stmt, 1, $userID, PDO::PARAM_INT);
        $stmt = $this->prepare_stmt($sql, $values);
        $this->dbManager->executeQuery ( $stmt );

        return  $values[0]['value'];
    }

    protected function base_search($sql, $values) {
        $stmt = $this->prepare_stmt($sql, $values);
        $this->dbManager->executeQuery ( $stmt );

        $arrayOfResults = $this->dbManager->fetchResults ( $stmt );
        return $arrayOfResults;
    }

    protected function base_purge($table) {
        //TODO
        $sql = 'TRUNCATE ';
        $sql .= $table;
        $sql .= ';';

        $stmt = $this->dbManager->prepareQuery($sql);
        $this->dbManager->executeQuery ( $stmt );

        return true;
    }

    protected function prepare_stmt($sql, $values) {
        $stmt = $this->dbManager->prepareQuery($sql);
        foreach($values as $value)
            $this->dbManager->bindParam($stmt, ':'.$value['label'], $value['value'], $value['type']);

        return ($stmt);
    }

//    protected function prepare_stmt($sql, $values) {
//        $stmt = $this->dbManager->prepareQuery($sql);
//        $i = 1;
//        foreach($values as $value => $type)
//            $this->dbManager->bindValue($stmt, $i++, $value, $type);
//
//        return ($stmt);
//    }

    protected function get_types($parametersArray) {
        $values = array();
        foreach($parametersArray as $key=>$value){
            $constantString = strtoupper(substr(get_class($this),0,-3). '_' . $key . '_TYPE');
            if(defined($constantString))
                array_push($values, array('label'=>$key,"value"=>$value,"type"=>constant($constantString)));
        }
        //var_dump($values);
        return $values;
    }
}