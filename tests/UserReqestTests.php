<?php
require_once('../app/conf/config.inc.php');
require_once('../simpletest/autorun.php');
require_once('RequestTest.php');

class UserRequestTests extends UnitTestCase{
    private $requestTest;
    private $route;

    function setUp(){
        $this->requestTest = new RequestTest();
        $this->route = BASE_URL . 'users';
        $this->requestTest->purge($this->route);
        $this->requestTest->post($this->route, '{"username":"mm", "name":"Mister", "surname":"Mime", "email":"mister@mime.com", "password":"slave4jynx"} ', array("Accept" => "application/json"));
    }

    function tearDown(){
        $this->requestTest->purge($this->route);
        $this->requestTest = NULL;
    }

    public function  testCreateUserJson(){
        $this->assertTrue($this->requestTest->post($this->route, '{"username":"mm", "name":"Mister", "surname":"Mime", "email":"mister@mime.com", "password":"slave4jynx"} ', array("Accept" => "application/json"), HTTPSTATUS_CREATED, '{"message":"Resource has been created","id":"2"}'));
    }

    public function testDeleteUser(){
        $this->assertTrue($this->requestTest->delete($this->route . '/1', array("Accept" => "application/json", "username" => "mm", "password" => "slave4jynx"), HTTPSTATUS_OK, '{"message":"Resource has been deleted","id":"1"}'));
    }

    public function testGetUsersJson(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->requestTest->post($this->route, '{"username":"mm", "name":"Mister", "surname":"Mime", "email":"mister@mime.com", "password":"slave4jynx"} ', array("Accept" => "application/json"));
        $this->assertTrue($this->requestTest->get($this->route, array("Accept" => "application/json"), HTTPSTATUS_OK, '[{"id":"1","username":"mm","name":"Mister","surname":"Mime","email":"mister@mime.com","password":"slave4jynx"},{"id":"2","username":"mm","name":"Mister","surname":"Mime","email":"mister@mime.com","password":"slave4jynx"}]'));
    }

    public function testGetUsersXml(){
        $this->requestTest->post($this->route, '{"username":"mm", "name":"Mister", "surname":"Mime", "email":"mister@mime.com", "password":"slave4jynx"} ', array("Accept" => "application/json"));
        $this->assertTrue($this->requestTest->get($this->route,array("Accept" => "application/xml"), HTTPSTATUS_OK, '<?xml version="1.0"?><element id="1"><username>mm</username><name>Mister</name><surname>Mime</surname><email>mister@mime.com</email><password>slave4jynx</password></element><element id="2"><username>mm</username><name>Mister</name><surname>Mime</surname><email>mister@mime.com</email><password>slave4jynx</password></element>'));
    }

    public function testUpdateUserJson(){
        $this->requestTest->post($this->route, '{"username":"jdevTest", "name":"JoeT", "surname":"testT", 
        "email":"joeTest@gmail.com", "password":"1234"} ', array("Accept" => "application/json", "username" => "mm", "password" => "slave4jynx"));
        $this->requestTest->put($this->route . "/2", '{"username":"jdevTestMod", "name":"JoeTMod", "surname":"testTMod", 
        "email":"joeTestMod@gmail.com", "password":"1234Mod"} ', array("Accept" => "application/json", "username" => "mm", "password" => "slave4jynx"));

        $this->assertTrue($this->requestTest->get($this->route . "/2", array("Accept" => "application/json"), HTTPSTATUS_OK,
            '[{"id":"2","username":"jdevTestMod","name":"JoeTMod","surname":"testTMod","email":"joeTestMod@gmail.com","password":"1234Mod"}]'));

    }
}
?>