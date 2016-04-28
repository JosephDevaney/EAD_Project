<?php

require_once ("controllers/BaseController.php");
class UserController extends BaseController{
	public function __construct($model, $action = null, $slimApp, $parameters = null) {
        parent::__construct($model, $slimApp);
		
		if (! empty ( $parameters ["id"] ))
			$id = $parameters ["id"];
		
		switch ($action) {
			case ACTION_GET_USER :
				$this->get ( $id );
				break;
			case ACTION_GET_USERS :
				$this->getAll ();
				break;
			case ACTION_UPDATE_USER :
				$this->update ( $id, $this->requestBody );
				break;
			case ACTION_CREATE_USER :
				$this->create ( $this->requestBody );
				break;
			case ACTION_DELETE_USER :
				$this->delete ( $id );
				break;
			case ACTION_SEARCH_USERS :
				$string = $parameters ["SearchingString"];
				$this->search ( $string );
				break;
            case ACTION_PURGE_USERS :
                $this->purge();
                break;
			case ACTION_AUTHENTICATE_USER :
				$this->authenticateUser($parameters);
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

	private function authenticateUser($params) {
		if ($this->model->authenticateUser ( $params )) {
			$this->slimApp->response->headers->set('Authenticated', 'true');
            $this->model->apiResponse = array();
		} else {
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_UNAUTHORIZED );
			$Message = array (
					GENERAL_MESSAGE_LABEL => GENERAL_UNAUTHORISED_MESSAGE
			);
			$this->model->apiResponse = $Message;
		}
	}
}
