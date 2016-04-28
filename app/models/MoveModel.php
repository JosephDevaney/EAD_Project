<?php

require_once('models/BaseModel.php');

class MoveModel extends BaseModel {

    public function getMoves() {
        return $this->getAll();
    }
    public function getMove($moveID) {
        return $this->get($moveID);
    }
    public function createNewMove($newMove) {
        $newMoveValidation = array(array('label'=>'move_name','value'=>$newMove ["move_name"], 'type'=>'string'),
            array('label'=>'accuracy','value'=>$newMove ["accuracy"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'pp','value'=>$newMove ["pp"], 'type'=>'numeric', 'min'=>0, 'max'=>100),
            array('label'=>'power','value'=>$newMove ["power"], 'type'=>'numeric', 'min'=>0, 'max'=>1000));

        return $this->create($newMoveValidation);
    }
    public function updateMove($moveID, $newMoveRepresentation) {
        $newMoveValidation = array(array('label'=>'move_name','value'=>$newMoveRepresentation ["move_name"], 'type'=>'string'),
            array('label'=>'accuracy','value'=>$newMoveRepresentation ["accuracy"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'pp','value'=>$newMoveRepresentation ["pp"], 'type'=>'numeric', 'min'=>0, 'max'=>100),
            array('label'=>'power','value'=>$newMoveRepresentation ["power"], 'type'=>'numeric', 'min'=>0, 'max'=>1000));

        return $this->update($moveID, $newMoveValidation);
    }
    public function deleteMove($moveID) {
        return $this->delete($moveID);
    }
    public function purgeMoves() {
        return $this->purge();
    }
    public function searchMoves($string) {
        return $this->search($string);
    }
}
?>