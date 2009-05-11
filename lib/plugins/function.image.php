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


function smarty_function_image($params, &$smarty)
{
	$alt = $params["alt"];
	$class = $params["class"];
	$style = $params["style"];
	$id = $params["id"];
	$href = $params["href"];
	$folder = $params["folder"];

    if ($folder == "") {
        $folder = asset_url.image_folder;
    } else {
        $folder = site_url.$folder;
    }

    $url = rtrim($folder,"/")."/".ltrim($params["src"], "/");

	if ($class) {
		$class = "class='$class' ";
	}

	if ($id) {
		$id = "id='$id' ";
	}

    if ($style) {
		$style = "style='$style' ";
	}
	$img_obj = sprintf("<img src='%s' alt='%s' title='%s' %s%s%s/>", $url, $alt, $alt, $id, $class, $style);
	
	if ($href != "") {
		preg_match('/http:\/\/.*/', $href, $matches);
		$host = $matches[0];
		if ($host == "") {
			$host = site_url.$href;
		}
		$img_obj = sprintf("<a href='%s'>%s</a>", $host, $img_obj);
	}

	echo $img_obj;
}

?>
