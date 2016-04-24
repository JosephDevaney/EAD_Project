<?php
require_once('../app/conf/config.inc.php');
require_once('../simpletest/autorun.php');
require_once('../Utility/XmlEncoder.php');
require_once('RequestTest.php');

class UserRequestTests extends UnitTestCase{
    private $requestTest;
    private $xmlEncoder;
    private $sampleUser;
    private $route;

    function setUp(){
        $this->requestTest = new RequestTest();
        $this->route = BASE_URL . 'users';
        $this->sampleUser = array("username" => "test", "name" => "testing", "surname" => "tester", "email" => "tester@test.com", "password" => "testing");
        $this->requestTest->purge($this->route);
        $this->requestTest->post($this->route, json_encode($this->sampleUser), array("Accept" => "application/json"));
    }

    function tearDown(){
        $this->requestTest->purge($this->route);
        $this->requestTest = NULL;
        $this->xmlEncoder = NULL;
        $this->sampleUser = NULL;
        $this->route = NULL;
    }

    public function  testCreateUserJson(){
        $this->assertTrue($this->requestTest->post($this->route, json_encode($this->sampleUser),
            array("Accept" => "application/json"), HTTPSTATUS_CREATED, '{"message":"Resource has been created","id":"2"}'));
    }

    public function testDeleteUser(){
        $this->assertTrue($this->requestTest->delete($this->route . '/1',
            array("Accept" => "application/json", "username" => "test", "password" => "testing"), HTTPSTATUS_OK, '{"message":"Resource has been deleted","id":"1"}'));
    }

    public function testGetUsersJson(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->requestTest->post($this->route, json_encode($this->sampleUser), array("Accept" => "application/json"));
        $expectedResults = array();
        array_push($expectedResults,array_merge(array("id" => '1'),$this->sampleUser));
        array_push($expectedResults,array_merge(array("id" => '2'),$this->sampleUser));
        $this->assertTrue($this->requestTest->get($this->route, array("Accept" => "application/json"), HTTPSTATUS_OK, json_encode($expectedResults)));
    }

    public function testGetUsersXml(){
        //$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
        $this->requestTest->post($this->route, json_encode($this->sampleUser), array("Accept" => "application/xml"));
        $expectedResults = array();
        array_push($expectedResults,array_merge(array("id" => '1'),$this->sampleUser));
        array_push($expectedResults,array_merge(array("id" => '2'),$this->sampleUser));
        $this->xmlEncoder = new XmlEncoder($expectedResults);
        $this->xmlEncoder->encode();
        $this->assertTrue($this->requestTest->get($this->route, array("Accept" => "application/json"), HTTPSTATUS_OK, $this->xmlEncoder->getUnformattedString()));
    }

    public function testUpdateUserJson(){
        foreach($this->sampleUser as $value)
            $value = $value . 'Mod';
        $this->requestTest->put($this->route . "/1", json_encode($this->sampleUser), array("Accept" => "application/json", "username" => "test", "password" => "testing"));
        $expectedResults = array();
        array_push($expectedResults,array_merge(array("id" => '1'),$this->sampleUser));
        $this->assertTrue($this->requestTest->get($this->route . "/1", array("Accept" => "application/json"), HTTPSTATUS_OK, json_encode($expectedResults)));

    }
}
?>