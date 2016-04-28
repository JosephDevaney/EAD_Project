<?php
abstract class BaseController {
    protected $slimApp;
    protected $model;
    protected $requestBody;

    protected function __construct($model, $slimApp) {
        $this->model = $model;
        $this->slimApp = $slimApp;
        $this->requestBody = json_decode ( $this->slimApp->request->getBody (), true ); // this must contain the representation of the new move
    }

    protected function getAll() {
        $response = $this->model->get();
        if ($response != null) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
            $this->model->apiResponse = $response;
        } else {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }

    protected function get($id) {
        $response = $this->model->get ( $id );
        if ($response != null) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
            $this->model->apiResponse = $response;
        } else {

            $this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE
            );
            $this->model->apiResponse = $Message;
        }
    }

    protected function create($new) {
        if ($newId = $this->model->create ( $new)) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_CREATED,
                "id" => "$newId"
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
    protected function delete($id) {
        //TODO
        if ($deletedId = $this->model->delete( $id )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK);
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_DELETED,
                "id" => "$deletedId"
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
    protected function purge() {
        //TODO
        if ($this->model->purge()) {
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
    protected function update($id, $parameters) {
        //TODO
        if ($newId = $this->model->update ( $id, $parameters )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_CREATED );
            $Message = array (
                GENERAL_MESSAGE_LABEL => GENERAL_RESOURCE_UPDATED,
                "id" => "$newId"
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
    protected function search($string) {
        //TODO
        if ($array = $this->model->search( $string )) {
            $this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );

            $this->model->apiResponse = $array;
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