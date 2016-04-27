<?php
require_once('../simpletest/autorun.php');

class ValidationTests extends UnitTestCase{
	private $validation;
	
	public function setUp(){
		require_once('../app/models/Validation.php');
		$this->validation = new Validation();
	}
	
	public function tearDown(){
		$this->validation = NULL;
	}
	
	public function testIsEmailValid(){
		$this->assertFalse($this->validation->isEmailValid(''));
		$this->assertFalse($this->validation->isEmailValid([],[]));
		$this->assertFalse($this->validation->isEmailValid(''));
		$this->assertFalse($this->validation->isEmailValid(111));
		$this->assertFalse($this->validation->isEmailValid('cat'));
		$this->assertFalse($this->validation->isEmailValid('darrenbritton@'));
		$this->assertFalse($this->validation->isEmailValid('darrenbritton@@hotmail.com'));
		$this->assertTrue($this->validation->isEmailValid('darrenbritton@hotmail.co.uk'));
		$this->assertTrue($this->validation->isEmailValid('darrenbritton@hotmail.com'));
	}

	public function testIsNumberInRange(){
		$this->assertFalse($this->validation->isNumberInRangeValid('cat', 'in', 'hat'));
		$this->assertFalse($this->validation->isNumberInRangeValid([5],[1],[10]));
		$this->assertFalse($this->validation->isNumberInRangeValid(10, 10, 'hat'));
		$this->assertFalse($this->validation->isNumberInRangeValid(10, 'in', 'hat'));
		$this->assertFalse($this->validation->isNumberInRangeValid(pow(20,99),pow(2,99),pow(9,99)));
		$this->assertFalse($this->validation->isNumberInRangeValid(-10, -20, -30));
		$this->assertTrue($this->validation->isNumberInRangeValid(99999999999999999999999999999999999999999999999,
			9999999999999999999999999999999999999999, 999999999999999999999999999999999999999999999999999));
		$this->assertTrue($this->validation->isNumberInRangeValid(pow(5,99999),pow(1,99999),pow(9,99999)));
		$this->assertTrue($this->validation->isNumberInRangeValid(10, 9, 11));
		$this->assertTrue($this->validation->isNumberInRangeValid(10, -15, 30));
		$this->assertTrue($this->validation->isNumberInRangeValid(10, 10, 10));
		$this->assertTrue($this->validation->isNumberInRangeValid(0, 0, 0));
		$this->assertTrue($this->validation->isNumberInRangeValid(10, 9, 10));
		$this->assertTrue($this->validation->isNumberInRangeValid(10, 10, 11));
	}

	public function testIsLengthStringValid(){
		$this->assertFalse($this->validation->isLengthStringValid('cat', 'cat'));
		$this->assertFalse($this->validation->isLengthStringValid(10, 'cat'));
		$this->assertFalse($this->validation->isLengthStringValid([3],['cat']));
		$this->assertFalse($this->validation->isLengthStringValid('cat', 2));
		$this->assertTrue($this->validation->isLengthStringValid('cat', 3));
		$this->assertTrue($this->validation->isLengthStringValid('cat', 4));
		$this->assertTrue($this->validation->isLengthStringValid('cat', pow(9,99999)));
	}
}
?>