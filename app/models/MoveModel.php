<?php

require_once('models/BaseModel.php');

class MoveModel extends BaseModel {

    public function createNew($newMove) {
        $newMoveValidation = $this->createValidationArray($newMove);
        return $this->create($newMoveValidation);
    }
    public function updateExisting($moveID, $newMoveRepresentation) {
        $newMoveValidation = $this->createValidationArray($newMoveRepresentation);
        return $this->update($moveID, $newMoveValidation);
    }
    private function createValidationArray($params){
        return array(array('label'=>'move_name','value'=>$params ["move_name"], 'type'=>'string'),
            array('label'=>'accuracy','value'=>$params ["accuracy"], 'type'=>'numeric', 'min'=>0, 'max'=>1000),
            array('label'=>'pp','value'=>$params ["pp"], 'type'=>'numeric', 'min'=>0, 'max'=>100),
            array('label'=>'power','value'=>$params ["power"], 'type'=>'numeric', 'min'=>0, 'max'=>1000));
    }
}
?>