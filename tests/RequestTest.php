<?php

require_once('../Curl/Curl.php');
require_once('../Curl/CaseInsensitiveArray.php');
require_once('../Curl/MultiCurl.php');

use \Curl\Curl;

class RequestTest {

    function __construct() {
    }

    public function get($url, $headers, $expectedStatus, $expectedResponse, $similarityPercentage = 100){
        $curl = new Curl();
        foreach ($headers as $key => $value){
            $curl->setHeader($key, $value);
        }
        $curl->get($url);
        if($curl->httpStatusCode == $expectedStatus)
        {
            if($curl->response) {
                //var_dump($expectedResponse);
                $sim = 0;
                similar_text($expectedResponse, $curl->response, $sim);
                if($sim >= $similarityPercentage){
                    return true;
                }
                else{
                    echo 'Error: Expected:';
                    var_dump($expectedResponse);
                    echo'Got:';
                    var_dump($curl->response);
                    echo round($sim) . "% similar";
                }
            }
        }
        else {
            echo 'Error: Expected:';
            var_dump($expectedStatus);
            echo'Got:';
            var_dump($curl->httpStatusCode);
        }

        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
        return false;
    }


    public function post($url, $body, $headers, $expectedStatus, $expectedResponse, $similarityPercentage = 100){
        $curl = new Curl();
        foreach ($headers as $key => $value){
            $curl->setHeader($key, $value);
        }
        $curl->post($url, $body);
        if($curl->httpStatusCode == $expectedStatus)
        {
            if($curl->response) {
                //var_dump($expectedResponse);
                $sim = 0;
                similar_text($expectedResponse, $curl->response, $sim);
                if($sim >= $similarityPercentage){
                    return true;
                }
                else{
                    echo 'Error: Expected:';
                    var_dump($expectedResponse);
                    echo'Got:';
                    var_dump($curl->response);
                    echo round($sim) . "% similar";
                }
            }
        }
        else {
            echo 'Error: Expected:';
            var_dump($expectedStatus);
            echo'Got:';
            var_dump($curl->httpStatusCode);
        }

        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
        return false;
    }

    public function update(){
    }

    public function delete(){
    }
}
?>