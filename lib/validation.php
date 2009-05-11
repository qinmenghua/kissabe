<?php

/* (C) 2009 Netology Joy Web Framework v.0.2, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */

class validation
{
	public function email($email)
	{
		$rule = "^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$";

		return eregi($rule, strtolower($email));
	}

	public function phone($phone)
	{
		$rule = "^[0-9\+\-\ \(\)]+$";

		return eregi($rule, $phone);
	}
	
	public function password($password)
	{
		$rule = "^[a-zA-Z0-9@#$!%^&+=]{6}.*$";

		return eregi($rule, $password);
	}

	public function number($number)
	{
		$rule = "^[0-9]+$";

		return eregi($rule, $number);
	}

	public function is_zero($number) 
	{
		return ($number == 0);
	}

	public function is_set($string) 
	{
		return (isset($string) && strlen($string));
	}

}
?>
