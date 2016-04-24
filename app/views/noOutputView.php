<?php
class noOutputView
{
    private $model, $controller, $slimApp;

    public function __construct($controller, $model, $slimApp) {
        $this->controller = $controller;
        $this->model = $model;
        $this->slimApp = $slimApp;
    }

    public function output(){
        return;
    }
}
?>