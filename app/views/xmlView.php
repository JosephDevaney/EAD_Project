<?php
require_once('./utility/XmlEncoder.php');

class xmlView
{
    private $model, $controller, $slimApp, $xmlEncoder;

    public function __construct($controller, $model, $slimApp) {
        $this->controller = $controller;
        $this->model = $model;
        $this->slimApp = $slimApp;
//        $this->xmlEncoder = new XmlEncoder($this->model->apiResponse);
    }

    public function output(){
        //prepare xml response
        $xml_str = "";
        $resp = $this->model->apiResponse;
        if (is_array($resp)) {
            foreach ($resp as $obj) {
                $xml_str .= "<Object>";
                $xml_str .= "\n";
                foreach ($obj as $key => $value) {
                    $xml_str .= "\t";
                    $xml_str .= "<" . $key . ">";
                    $xml_str .= $value;
                    $xml_str .= "</" . $key . ">";
                    $xml_str .= "\n";
                }
                $xml_str .= "</Object>";
                $xml_str .= "\n";
            }
        }
        else
            $xml_str .= $resp;

        $this->slimApp->response->write($xml_str);


//        var_dump($this->model->apiResponse);
//        $this->xmlEncoder->encode();
//        if($response = $this->xmlEncoder->getUnformattedString())
//            $this->slimApp->response->write($response);
    }

}
?>