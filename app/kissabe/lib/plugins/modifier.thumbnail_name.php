<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_thumbnail_name($image)
{	$items = split("\.", $image);
	return $items[0]."-thumbnail.".$items[1];
}

?>
