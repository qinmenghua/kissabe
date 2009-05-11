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


class crypto
{
	static $key = "you can't stop us all...";
 
 //Encrypt Function
	function encode($encrypt) 
	{
	    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
    	$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$key, trim($encrypt), MCRYPT_MODE_ECB, $iv);
	    $encode = base64_encode($passcrypt);

	 	return $encode;
 	}
 
 //Decrypt Function
	static function decode($decrypt) 
	{
    	$decoded = base64_decode($decrypt);
	    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
    	$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$key, $decoded, MCRYPT_MODE_ECB, $iv);

		return trim($decrypted);
 	} 
}

?>
