<?php

require_once('../Curl/Curl.php');
require_once('../Curl/CaseInsensitiveArray.php');
require_once('../Curl/MultiCurl.php');

use \Curl\Curl;

class RequestTest {

    function __construct() {
    }

    public function getDecoded($url, $headers, $expectedStatus = false){
        $curl = new Curl();
        foreach ($headers as $key => $value){
            $curl->setHeader($key, $value);
        }
        $curl->get($url);
        if($curl->httpStatusCode == $expectedStatus)
        {
            if($curl->response) {
                $responseFormat  = $curl->responseHeaders['Custom-Content-Type'];
                if($responseFormat == 'application/json'){
                    return json_decode($curl->response, true);
                }
                else if($responseFormat == 'application/xml'){
                    $xml = simplexml_load_string($curl->response, "SimpleXMLElement", LIBXML_NOCDATA);
                    $json = json_encode($xml);
                    return json_decode($json, true);
                }
                else
                    die('response content-type not supported, json and xml only');
            }
        }
        else {
            echo 'Error: Expected:';
            var_dump($expectedStatus);
            echo'Got:';
            var_dump($curl->httpStatusCode);
        }

        var_dump($curl->errorMessage);
        return false;
    }

    public function get($url, $headers, $expectedStatus = false, $expectedResponse = false, $similarityPercentage = 100){
        $curl = new Curl();
        foreach ($headers as $key => $value){
            $curl->setHeader($key, $value);
        }
        $curl->get($url);
        if($expectedResponse){
            if($curl->httpStatusCode == $expectedStatus)
            {
                if($curl->response) {
                    var_dump($expectedResponse);
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

            var_dump($curl->errorMessage);
            return false;
        }
    }


    public function post($url, $body, $headers, $expectedStatus = false, $expectedResponse = false, $similarityPercentage = 100){
        $curl = new Curl();
        foreach ($headers as $key => $value){
            $curl->setHeader($key, $value);
        }
        $curl->post($url, $body);
        if($expectedResponse){
            if($curl->httpStatusCode == $expectedStatus)
            {
                if($curl->response) {
                    var_dump($expectedResponse);
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

            var_dump($curl->errorMessage);
            return false;
        }
    }

    public function put($url, $body, $headers, $expectedStatus = false, $expectedResponse = false, $similarityPercentage = 100){
        $curl = new Curl();
        foreach ($headers as $key => $value){
            $curl->setHeader($key, $value);
        }
        $curl->put($url, $body);
        if($expectedResponse){
            if($curl->httpStatusCode == $expectedStatus)
            {
                if($curl->response) {
                    var_dump($expectedResponse);
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

            var_dump($curl->errorMessage);
            return false;
        }
    }

    public function delete($url, $headers, $expectedStatus = false, $expectedResponse = false, $similarityPercentage = 100){
        $curl = new Curl();
        foreach ($headers as $key => $value){
            $curl->setHeader($key, $value);
        }
        $curl->delete($url);
        if($expectedResponse){
            if($curl->httpStatusCode == $expectedStatus)
            {
                if($curl->response) {
                    var_dump($expectedResponse);
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

            var_dump($curl->errorMessage);
            return false;
        }
    }

    public function purge($url, $headers){

        $ch = curl_init();

        $formattedHeaders = array();

        foreach ($headers as $key => $value){
            array_push($formattedHeaders, join(':', array($key, $value)));
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PURGE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);
        $resp = curl_exec($ch);
        curl_close($ch);

        return $resp;
    }
}

?>