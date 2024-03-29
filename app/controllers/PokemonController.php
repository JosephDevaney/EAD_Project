<?php
require_once ("controllers/BaseController.php");

class PokemonController extends BaseController{
    public function __construct($model, $action = null, $slimApp, $parameters) {
        parent::__construct($model, $slimApp);
        $id = null;
        if (! empty ( $parameters ["id"] ))
            $id = $parameters ["id"];

        switch ($action) {
            case ACTION_GET_POKEMON :
                $this->get ( $id );
                break;
            case ACTION_UPDATE_POKEMON :
                $this->update ( $id, $this->requestBody );
                break;
            case ACTION_CREATE_POKEMON :
                $this->create ( $this->requestBody );
                break;
            case ACTION_DELETE_POKEMON :
                $this->delete ( $id );
                break;
            case ACTION_PURGE_POKEMON :
                $this->purge();
                break;
            case ACTION_SEARCH_POKEMON :
                $string = $parameters ["SearchingString"];
                $this->search ( $string );
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