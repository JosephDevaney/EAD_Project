<?php
class Validation {
	/**
	 * check whether the email string is a valid email address using a regular expression
	 * @param $emailStr - the input email string
	 * @return boolean indicating whether it is a valid email or not
	 */
	public function isEmailValid($emailStr){
		if(!is_string($emailStr)) return false;
		$regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i";
		if(!preg_match($regex, $emailStr)) return false;
		else return true;
	}
	/**
	 * @param $number - the input number
	 * @param $min - the minimum value for the input number
	 * @param $max - the maximum value for the input number
	 * @return boolean indicating whether it is a valid number in the input range
	 */
	public function isNumberInRangeValid ($number, $min =-2147483647 , $max =2147483647){
		if (is_numeric($number) && is_numeric($min) && is_numeric($max))
			if ($number>= $min && $number<= $max) return (true);
		return (false);
	}

	/**
	 * @param $string - the input string
	 * @param $maxchars - the maximum length of the input string
	 * @return boolean indicating whether it is a valid string of the right max length
	 */
	public function isLengthStringValid($string, $maxchars){
		if (is_string($string) && is_numeric($maxchars))
			if (strlen($string)<=$maxchars) return (true);	
		return (false);
	}
}
?>
