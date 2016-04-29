<?php
require_once('../app/conf/config.inc.php');
require_once('../simpletest/autorun.php');
require_once('../app/utility/XmlEncoder.php');
require_once('RequestTest.php');

class PokemonRequestTests extends UnitTestCase{
    private $requestTest;
    private $xmlEncoder;
    private $samplePokemon;
    private $sampleMove;
    private $authHeaders;
    private $defaultHeaders;
    private $primaryKey;
    private $userRoute;
    private $moveRoute;
    private $route;

    function setUp(){
        $this->requestTest = new RequestTest();
        $this->route = BASE_URL . 'pokemon';
        $this->primaryKey = 'id';
        $this->samplePokemon = array(array("id" => 25, "name" => "Pikachu", "height" =>4, "weight" => 60, "hp" => 35, "move1_id" => 1, "move2_id" => 1, "move3_id" => 1, "move4_id" => 1),
            array("id" => 26, "name" => "Raichu", "height" =>8, "weight" => 300, "hp" => 60, "move1_id" => 1, "move2_id" => 1, "move3_id" => 1, "move4_id" => 1));
        $this->sampleMove = array("move_name" => "Cut", "accuracy" => 95, "pp" =>30, "power" => 50);
        $this->authHeaders = array("Accept" => "application/json", "username" => "test", "password" => "testpwd");
        $this->defaultHeaders = array("Accept" => "application/json");
        $this->userRoute = BASE_URL . 'users';
        $this->moveRoute = BASE_URL . 'moves';

        $accessUser = array("username" => "test", "name" => "testing", "surname" => "tester", "email" => "tester@test.com", "password" => "testpwd");
        $this->requestTest->purge($this->userRoute, $this->authHeaders);
        $this->requestTest->post($this->userRoute, json_encode($accessUser), $this->defaultHeaders);
        $this->requestTest->purge($this->moveRoute, $this->authHeaders);
        $this->requestTest->post($this->moveRoute, json_encode($this->sampleMove), $this->authHeaders);
        $this->requestTest->purge($this->route, $this->authHeaders);
        $this->requestTest->post($this->route, json_encode($this->samplePokemon[0]), $this->authHeaders);
    }

    function tearDown(){
        $this->requestTest->purge($this->route, $this->authHeaders);
        $this->requestTest->purge($this->moveRoute, $this->authHeaders);
        $this->requestTest->purge($this->userRoute, $this->authHeaders);
        $this->requestTest = NULL;
        $this->xmlEncoder = NULL;
        $this->sampleMove = NULL;
        $this->authHeaders = NULL;
        $this->defaultHeaders = NULL;
        $this->route = NULL;
    }

//    public function  testCreatePokemonJson(){
//        $this->assertTrue($this->requestTest->post($this->route, json_encode($this->samplePokemon[1]),
//            $this->authHeaders, HTTPSTATUS_CREATED, '{"message":"Resource has been created","id":"26"}'));
//    }
//
//    public function testDeletePokemon(){
//        $this->assertTrue($this->requestTest->delete($this->route . '/26',
//            $this->authHeaders, HTTPSTATUS_OK, '{"message":"Resource has been deleted","id":"26"}'));
//    }

    public function testGetPokemonJson(){
        $this->requestTest->post($this->route, json_encode($this->samplePokemon[1]), $this->authHeaders);
        $expectedResults = array();
        foreach ($this->samplePokemon as &$pokemon){
            foreach($pokemon as &$value)
                $value = (string)$value;
        }
        $array = $this->requestTest->getDecoded($this->route, $this->defaultHeaders, HTTPSTATUS_OK);
//        var_dump($array);
        $this->assertTrue(!array_diff($this->samplePokemon, $array));
    }
//
//    public function testGetPokemonXml(){
//        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
//        $this->requestTest->post($this->route, json_encode($this->samplePokemon[1]), $this->authHeaders);
//        $this->xmlEncoder = new XmlEncoder($this->samplePokemon);
//        $this->xmlEncoder->encode();
//        $headers = $this->defaultHeaders;
//        $headers['Accept'] = "application/xml";
//        $xml_array = $this->requestTest->getDecoded($this->route, $headers, HTTPSTATUS_OK);
//
//        $sameObj = !array_diff($this->samplePokemon, $xml_array);
//        $this->assertTrue($sameObj);
//    }
//
//    public function testUpdatePokemonJson(){
//        foreach($this->samplePokemon[0] as &$value) {
//            if (is_string($value))
//                $value = $value . 'Mod';
//            else
//                $value = (string)$value;
//        }
//        $this->requestTest->put($this->route . "/25", json_encode($this->samplePokemon[0]), $this->authHeaders);
//
//        $array = $this->requestTest->getDecoded($this->route, $this->defaultHeaders, HTTPSTATUS_OK, json_encode($this->samplePokemon));
//        $this->assertTrue(!array_diff($this->samplePokemon, $array));
//    }
}
