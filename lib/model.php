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


require_library("/vendor/adodb/adodb.inc.php");
require_library("/validation.php");

class model 
{
	public $db;
	public $error;
	public $is_valid;

	public function __construct($conn)
	{
		$this->error = array();
		$this->is_valid = new validation();

		if (is_object($conn) == false) 
		{
			$this->db = database::connection($conn);
		}
		else if (get_parent_class($conn) == "ADOConnection")
		{
			$this->db = $conn;
		}
		else
		{
			die("Database Object Not Found");
		}
	}

	
	/**
		SQL Injection & Cross Site Scripting Control
	*/
	public function inj($value)
	{
	    return ((!get_magic_quotes_gpc()) ? addslashes($value) : $value);
	}

	public function xss($value)
	{
		$value = str_replace("<script", "<noscript", $value);
		$value = str_replace("/script>", "/noscript>", $value);

		return $value;
	}

	public function iax($value)
	{
		return $this->inj($this->xss($value));	
	}

	public function add_error($msg)
	{
		$this->error[] = $msg;
	}

	public function reset_error_log()
	{
		$this->error = array();
	}

	public function has_error()
	{
		return (count($this->error) > 0);
	}
	
	public function to_object($res)
	{
		$package = array();

		if ($res) 
		{
			while ($rs = $res->FetchNextObject()) {
				$obj = null;
				foreach($rs as $key=>$val) {
					$obj->{strtolower($key)} = $val;
				}
				$package[] = $obj;
			}
		}
		
		return $package;
	}
}

class database 
{
	static function connection($dsn)
	{
		return NewADOConnection($dsn);
	}
}
?>
