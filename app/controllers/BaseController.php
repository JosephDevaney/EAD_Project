<?php
abstract class BaseController {
    public $slimApp;
    public $model;
    public $requestBody;

    public function __construct($model, $slimApp) {
        $this->model = $model;
        $this->slimApp = $slimApp;
        $this->requestBody = json_decode ( $this->slimApp->request->getBody (), true );
    }

    protected function get($id=null) {
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
        if ($newId = $this->model->createNew ( $new)) {
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
        if ($newId = $this->model->updateExisting ( $id, $parameters )) {
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
