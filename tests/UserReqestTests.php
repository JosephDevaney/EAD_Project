<?php
require_once('../app/conf/config.inc.php');
require_once('../simpletest/autorun.php');
require_once('RequestTest.php');

class UserRequestTests extends UnitTestCase{
    private $requestTest;
    private $route;

    public function setUp(){
        $this->requestTest = new RequestTest();
        $this->route = BASE_URL . 'users';
    }

    public function tearDown(){
        $this->requestTest = NULL;
    }

    public function  testPost(){
        $this->assertTrue($this->requestTest->post($this->route, '{"name":"Mister", "surname":"Mime", "email":"mister@mime.com", "password":"slave4jynx"} ', array("Accept" => "application/json"), HTTPSTATUS_CREATED, '{"message":"Resource has been created","id":"7"}', 80));
        $this->requestTest->delete($this->route, '{"name":"Mister", "surname":"Mime", "email":"mister@mime.com", "password":"slave4jynx"} ', array("Accept" => "application/json"), HTTPSTATUS_CREATED, '{"message":"Resource has been created","id":"7"}', 80);
    }

    public function testGetUsersJson(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->assertTrue($this->requestTest->get($this->route, array("Accept" => "application/json"), HTTPSTATUS_OK, '[{"id":"5","username":"","name":"Mister","surname":"Mime","email":"mister@mime.com","password":"slave4jinx"},{"id":"6","username":"","name":"Mister","surname":"Mime","email":"mister@mime.com","password":"slave4jinx"}]', 90));
    }

    public function testGetUsersXml(){
        $this->assertTrue($this->requestTest->get($this->route,array("Accept" => "application/xml"), HTTPSTATUS_OK, '<?xml version="1.0"?><element id="5"><username></username><name>Mister</name><surname>Mime</surname><email>mister@mime.com</email><password>slave4jinx</password></element><element id="6"><username></username><name>Mister</name><surname>Mime</surname><email>mister@mime.com</email><password>slave4jinx</password></element>', 90));
    }
}
?>