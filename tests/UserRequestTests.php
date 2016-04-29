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
        $password = $this->sampleUser['password'];
        unset($this->sampleUser['password']);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array($this->primaryKey => '1'),$this->sampleUser));
        array_push($expectedResults,array_merge(array($this->primaryKey => '2'),$this->sampleUser));
        $array = $this->requestTest->getDecoded($this->route, $this->authHeaders, HTTPSTATUS_OK);
        if(password_verify($password,$array[0]['password']) && password_verify($password,$array[1]['password'])){
            unset($array[0]['password']);
            unset($array[1]['password']);
            $this->assertTrue($expectedResults == $array);
        }
        else
            var_dump('passwords did not satisfy the hash');
    }

    public function testGetUsersXml(){
        $headers = $this->authHeaders;
        $headers['Accept'] = "application/xml";
        $this->requestTest->post($this->route, json_encode($this->sampleUser), $this->defaultHeaders);
        $password = $this->sampleUser['password'];
        unset($this->sampleUser['password']);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array($this->primaryKey => '1'),$this->sampleUser));
        array_push($expectedResults,array_merge(array($this->primaryKey => '2'),$this->sampleUser));
        $array = $this->requestTest->getDecoded($this->route, $headers, HTTPSTATUS_OK)['element'];
        if(password_verify($password,$array[0]['password']) && password_verify($password,$array[1]['password'])){
            unset($array[0]['password']);
            unset($array[1]['password']);
            $this->assertTrue($expectedResults == $array);
        }
        else
            var_dump('passwords did not satisfy the hash');
    }

    public function testUpdateUserJson(){
        foreach($this->sampleUser as &$value) {
            if (is_string($value))
                $value = $value . 'Mod';
        }
        $this->requestTest->put($this->route . "/1", json_encode($this->sampleUser), $this->authHeaders);
        unset($this->sampleUser['password']);
        $expectedResults = array();
        array_push($expectedResults,array_merge(array($this->primaryKey => '1'),$this->sampleUser));
        $headers = $this->authHeaders;
        $headers['username'] .= "Mod";
        $headers['password'] .= "Mod";
        $array = $this->requestTest->getDecoded($this->route, $headers, HTTPSTATUS_OK);
        if(password_verify($headers['password'],$array[0]['password'])){
            unset($array[0]['password']);
            $this->assertTrue($expectedResults == $array);
        }
        else
            var_dump('passwords did not satisfy the hash');

    }
}
?>