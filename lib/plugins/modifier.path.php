<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_path($string)
{
	preg_match('/http:\/\/.*/', $string, $matches);
	$path = $matches[0];
	if ($path == "") {
		$path = site_url.$string;
	}

    return strtolower($path);
}

?>
