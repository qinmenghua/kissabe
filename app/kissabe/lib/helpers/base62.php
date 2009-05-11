<?php

class base62 
{
	const SCHEME = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";

	static function decode($code)
	{	
		$scheme_size = strlen(self::SCHEME);

		$number  = 0;
		$code_size = strlen($code);
		$code = strrev($code);
		for($i = 0; $i < $code_size; $i++)
		{
			$digit_value = strpos(self::SCHEME, $code[$i]);

			$number += ($digit_value * pow($scheme_size, $i));
		}

		return $number;
	}

	static function encode($number, $code="")
	{
		$scheme_size = strlen(self::SCHEME);
        $scheme = self::SCHEME;

		if ($number >= $scheme_size)
		{
			$c = $number % $scheme_size;
			$code .= $scheme[$c];
			$number = floor($number / $scheme_size);
		
			return self::encode($number, $code);
		}
		else 
		{
			$code .= $scheme[$number];
			$code = strrev($code);
		}

		return $code;
	}
}

?>
