<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_cut($url)
{
    $length = strlen($url);

    if ($length > 110) {
        return sprintf("%s...", substr($url, 0, 110));
    }

    return $url;
}

?>
