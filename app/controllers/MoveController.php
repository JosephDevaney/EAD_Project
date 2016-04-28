<?php
class MoveController extends BaseController {

    public function __construct($model, $action = null, $slimApp, $parameters = null) {

        parent::__construct($model, $slimApp);

        if (! empty ( $parameters ["id"] ))
            $id = $parameters ["id"];

        switch ($action) {
            case ACTION_GET_MOVE :
                $this->get( $id );
                break;
            case ACTION_GET_MOVES :
                $this->getAll();
                break;
            case ACTION_UPDATE_MOVE :
                $this->update( $id, $this->requestBody );
                break;
            case ACTION_CREATE_MOVE :
                $this->create( $this->requestBody );
                break;
            case ACTION_DELETE_MOVE :
                $this->delete( $id );
                break;
            case ACTION_SEARCH_MOVES :
                $string = $parameters["SearchingString"];
                $this->search ( $string );
                break;
            case ACTION_PURGE_MOVES :
                $this->purge();
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
}
?>