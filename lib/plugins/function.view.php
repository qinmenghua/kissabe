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

function smarty_function_view($params, &$smarty)
{
	$src = $params["file"];
	if ($src != "") {
		$smarty->display(view_path."/".ltrim($src, "/"));
		return;
	} 

    //FIXME: Burası tek bir merkezden kontrol edilmeli.
    global $rule;

    foreach ($rule as $r) {
        if (eregi($r["class"], $params["class"])) {
            $class_path = controller_root."/".$r["file"];
            $class_name = $r["class"];
            break;
        }
    }

	$method = $params["method"];	
	$method_arguments = get_arguments($params);
	
    if (!file_exists($class_path)) {
		echo("Module ($class_name) Not Found<br/>");
	}
	else {
		require_once($class_path);
	}

	if(!method_exists($class_name, $method)) {
		echo("Method ($method) Not Found<br/>");
	} 
	else {
		eval("\$class = new $class_name();");
		$class->arguments = $smarty->get_template_vars();
		call_user_method_array($method, $class, $method_arguments);
	}
}


function get_arguments($params)
{
	$result = array();

	foreach($params as $key=>$val)
	{
		if (!in_array($key, array("module", "method")))
		{
			$result[$key] = $val;
		}
	}

	return @$result;
}

?>
