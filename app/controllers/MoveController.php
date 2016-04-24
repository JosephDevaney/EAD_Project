<?php
class MoveController {
    private $slimApp;
    private $model;
    private $requestBody;
    public function __construct($model, $action = null, $slimApp, $parameters = null) {
        $this->model = $model;
        $this->slimApp = $slimApp;
        $this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new move

        if (! empty ( $parameters ["id"] ))
            $id = $parameters ["id"];

        switch ($action) {
            case ACTION_GET_MOVE :
                $this->getMove( $id );
                break;
            case ACTION_GET_MOVES :
                $this->getMoves();
                break;
            case ACTION_UPDATE_MOVE :
                $this->updateMove( $id, $this->requestBody );
                break;
            case ACTION_CREATE_MOVE :
                $this->createNewMove( $this->requestBody );
                break;
            case ACTION_DELETE_MOVE :
                $this->deleteMove( $id );
                break;
            case ACTION_SEARCH_MOVES :
                $string = $parameters["SearchingString"];
                $this->searchMoves ( $string );
                break;
            case ACTION_PURGE_MOVES :
                $this->purgeMoves();
                break;
            case null :
                $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
                $Message = array (
                    GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR
                );
                $this->model->apiResponse = $Message;
                break;
        }
    }
    private function getMoves() {
        $answer = $this->model->getMoves ();
        if ($answer != null) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
            $this->model->apiResponse = $answer;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }

    private function getMove($moveID) {
        $answer = $this->model->getMove ( $moveID );
        if ($answer != null) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
            $this->model->apiResponse = $answer;
        } else {

            $this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }

    private function createNewMove($newMove) {
        if ($newID = $this->model->createNewMove ( $newMove )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
                "id" => "$newID"
            );
            $this->model->apiResponse = $Message;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY
            );
            $this->model->apiResponse = $Message;
        }
    }
    private function deleteMove($moveID) {
        //TODO
        if ($newID = $this->model->deleteMove ( $moveID )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK);
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_DELETED,
                "id" => "$moveID"
            );
            $this->model->apiResponse = $Message;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_INVALIDBODY
            );
            $this->model->apiResponse = $Message;
        }
    }
    private function purgeMoves() {
        //TODO
        if ($this->model->purgeMoves()) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_PURGE_MESSAGE
            );
            $this->model->apiResponse = $Message;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }
    private function updateMove($moveID, $parameters) {
        //TODO
        if ($moveID = $this->model->updateMove ( $moveID, $parameters )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
                "id" => "$moveID"
            );
            $this->model->apiResponse = $Message;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOTMODIFIED_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }
    private function searchMoves($string) {
        //TODO
        if ($moves = $this->model->searchMoves ( $string )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );

            $this->model->apiResponse = $moves;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }
}
?>