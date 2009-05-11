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

function smarty_function_link($params, &$smarty)
{
	preg_match('/http:\/\/.*/', $params["href"], $matches);
	$host = $matches[0];
	if ($host == "") {
		$host = site_url."/".ltrim($params["href"],"/");
	}
	if($params["title"]) {
		$title = " title='".$params["title"]."'";
	}

    if($params["id"]) {
		$id = " id='".$params["id"]."'";
	}

    if($params["class"]) {
		$class = " class='".$params["class"]."'";
	}

	if($params["onclick"]) {
		$onclick = " onclick='".$params["onclick"]."'";
	}
	echo "<a href='$host'$title$class$id$onclick>{$params["text"]}</a>";
}

?>
