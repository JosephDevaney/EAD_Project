<?php
require_once('../app/conf/config.inc.php');
require_once('../simpletest/autorun.php');
require_once('../app/utility/XmlEncoder.php');
require_once('RequestTest.php');

class UserRequestTests extends UnitTestCase{
    private $requestTest;
    private $xmlEncoder;
    private $sampleUser;
    private $defaultHeaders;
    private $primaryKey;
    private $authHeaders;
    private $route;

    function setUp(){
        $this->requestTest = new RequestTest();
        $this->route = BASE_URL . 'users';
        $this->primaryKey = 'id';
        $this->sampleUser = array("username" => "test", "name" => "testing", "surname" => "tester", "email" => "tester@test.com", "password" => "testpwd");
        $this->defaultHeaders = array("Accept" => "application/json");
        $this->authHeaders = array("Accept" => "application/json", "username" => "test", "password" => "testpwd");
        $this->requestTest->post($this->route, json_encode($this->sampleUser), $this->defaultHeaders);
        $this->requestTest->purge($this->route, $this->authHeaders);
        $this->requestTest->post($this->route, json_encode($this->sampleUser), $this->defaultHeaders);
    }

    function tearDown(){
        $this->requestTest->purge($this->route, $this->authHeaders);
        $this->requestTest = NULL;
        $this->xmlEncoder = NULL;
        $this->sampleUser = NULL;
        $this->route = NULL;
    }

    public function  testCreateUserJson(){
        $this->assertTrue($this->requestTest->post($this->route, json_encode($this->sampleUser),
            $this->defaultHeaders, HTTPSTATUS_CREATED, '{"message":"Resource has been created","id":"2"}'));
    }

    public function testDeleteUser(){
        $this->assertTrue($this->requestTest->delete($this->route . '/1',
            $this->authHeaders, HTTPSTATUS_OK, '{"message":"Resource has been deleted","id":"1"}'));
    }

    public function testGetUsersJson(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->requestTest->post($this->route, json_encode($this->sampleUser), $this->defaultHeaders);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array($this->primaryKey => '1'),$this->sampleUser));
        array_push($expectedResults,array_merge(array($this->primaryKey => '2'),$this->sampleUser));
        $this->assertTrue($this->requestTest->get($this->route, $this->authHeaders, HTTPSTATUS_OK, json_encode($expectedResults)));
    }

    public function testGetUsersXml(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->requestTest->post($this->route, json_encode($this->sampleUser), $this->defaultHeaders);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array($this->primaryKey => '1'),$this->sampleUser));
        array_push($expectedResults,array_merge(array($this->primaryKey => '2'),$this->sampleUser));
        $this->xmlEncoder = new XmlEncoder($expectedResults);
        $this->xmlEncoder->encode();
        $headers = $this->authHeaders;
        $headers['Accept'] = "application/xml";
        $this->assertTrue($this->requestTest->get($this->route, $headers, HTTPSTATUS_OK, $this->xmlEncoder->getUnformattedString()));
    }

    public function testUpdateUserJson(){
        foreach($this->sampleUser as &$value) {
            if (is_string($value))
                $value = $value . 'Mod';
        }
        $this->requestTest->put($this->route . "/1", json_encode($this->sampleUser), $this->authHeaders);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array($this->primaryKey => '1'),$this->sampleUser));
        $headers = $this->authHeaders;
        $headers['username'] .= "Mod";
        $headers['password'] .= "Mod";
        $this->assertTrue($this->requestTest->get($this->route . "/1", $headers, HTTPSTATUS_OK, json_encode($expectedResults)));

    }
}
?>