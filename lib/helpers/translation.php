<?php

/* (C) 2009 Netology Joy Web Framework v.0.2, All rights reserved.
 *
 * Author(s):
 *   Onur Yalazi (onur@yalazi.org)
 * 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */


class translation 
{
	public $name;
	public $author;

	private $strings;

	function __construct($name)
	{
		$this->name = $name;
		$this->strings = array();
		$this->loadLanguageFile($this->name);
	}

	private function loadLanguageFile($name) 
	{
		$langfile = text_root.'/'.$name.'.php';
		if (!file_exists($langfile)) 
		{
			die("Language file '$langfile' not found");
		}
		include_once($langfile);
	}

	private function addString($string, $translation) 
	{
		$this->strings[$string] = $translation;
	}

	public function &getAll()
	{
		return $this->strings;
	}
	public function getString($string) 
	{
		if (array_key_exists($string, $this->strings))
		{
			return $this->strings[$string];
		} 
		else
		{
			return str_replace(array('_', '/'), '', $string);
		}
	}
}

?>
