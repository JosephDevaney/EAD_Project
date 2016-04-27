<?php
require_once('../app/conf/config.inc.php');
require_once('../simpletest/autorun.php');
require_once('../app/utility/XmlEncoder.php');
require_once('RequestTest.php');

class MoveRequestTests extends UnitTestCase{
    private $requestTest;
    private $xmlEncoder;
    private $sampleMove;
    private $authHeaders;
    private $defaultHeaders;
    private $userRoute;
    private $route;

    function setUp(){
        $this->requestTest = new RequestTest();
        $this->route = BASE_URL . 'moves';
        $this->sampleMove = array("move_name" => "Cut", "accuracy" => 95, "power" => 50, "pp" =>30);
        $this->authHeaders = array("Accept" => "application/json", "username" => "test", "password" => "testpwd");
        $this->defaultHeaders = array("Accept" => "application/json");
        $this->userRoute = BASE_URL . 'users';
        $accessUser = array("username" => "test", "name" => "testing", "surname" => "tester", "email" => "tester@test.com", "password" => "testpwd");
        $this->requestTest->purge($this->userRoute, $this->authHeaders);
        $this->requestTest->post($this->userRoute, json_encode($accessUser), $this->defaultHeaders);
        $this->requestTest->purge($this->route, $this->authHeaders);
        $this->requestTest->post($this->route, json_encode($this->sampleMove), $this->authHeaders);
    }

    function tearDown(){
        $this->requestTest->purge($this->route, $this->authHeaders);
        $this->requestTest->purge($this->userRoute, $this->authHeaders);
        $this->requestTest = NULL;
        $this->xmlEncoder = NULL;
        $this->sampleMove = NULL;
        $this->authHeaders = NULL;
        $this->defaultHeaders = NULL;
        $this->route = NULL;
    }

    public function  testCreateMoveJson(){
        $this->assertTrue($this->requestTest->post($this->route, json_encode($this->sampleMove),
            $this->authHeaders, HTTPSTATUS_CREATED, '{"message":"Resource has been created","id":"2"}'));
    }

    public function testDeleteMove(){
        $this->assertTrue($this->requestTest->delete($this->route . '/2',
            $this->authHeaders, HTTPSTATUS_OK, '{"message":"Resource has been deleted","id":"2"}'));
    }

    public function testGetMovesJson(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->requestTest->post($this->route, json_encode($this->sampleMove), $this->authHeaders);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array("move_id" => '1'),$this->sampleMove));
        array_push($expectedResults,array_merge(array("move_id" => '2'),$this->sampleMove));
        $this->assertTrue($this->requestTest->get($this->route, $this->defaultHeaders, HTTPSTATUS_OK, json_encode($expectedResults)));
    }

    public function testGetMovesXml(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->requestTest->post($this->route, json_encode($this->sampleMove), $this->defaultHeaders);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array("move_id" => '1'),$this->sampleMove));
        array_push($expectedResults,array_merge(array("move_id" => '2'),$this->sampleMove));
        $this->xmlEncoder = new XmlEncoder($expectedResults);
        $this->xmlEncoder->encode();
        $headers = $this->defaultHeaders;
        $headers['Accept'] = "application/xml";
        $this->assertTrue($this->requestTest->get($this->route, $headers, HTTPSTATUS_OK, $this->xmlEncoder->getUnformattedString()));
    }

    public function testUpdateUserJson(){
        foreach($this->sampleMove as &$value) {
            if (is_string($value))
                $value = $value . 'Mod';
        }
        $this->requestTest->put($this->route . "/1", json_encode($this->sampleMove), $this->authHeaders);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array("id" => '1'),$this->sampleMove));
        $this->assertTrue($this->requestTest->get($this->route . "/1", $this->authHeaders, HTTPSTATUS_OK, json_encode($expectedResults)));

    }
}
?>