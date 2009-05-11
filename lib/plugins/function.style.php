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

function smarty_function_style($params, &$smarty)
{
    $style_url = asset_url.style_folder."/".ltrim($params["name"], "/");
	printf("<link rel='stylesheet' href='%s' type='text/css' />", $style_url);
}

?>
