<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_site_root($string)
{
	$path = site_root.$string;

    return strtolower($path);
}

?>
