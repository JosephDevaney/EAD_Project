<?php
require_once('../../Utility/XmlEncoder.php');

class xmlView
{
    private $model, $controller, $slimApp, $xmlEncoder;

    public function __construct($controller, $model, $slimApp) {
        $this->controller = $controller;
        $this->model = $model;
        $this->slimApp = $slimApp;
        $this->xmlEncoder = new XmlEncoder($this->model->apiResponse);
    }

    public function output(){
        //prepare xml response
        $this->xmlEncoder->encode();
        if($response = $this->xmlEncoder->getUnformattedString())
            $this->slimApp->response->write($response);
    }

}
?>