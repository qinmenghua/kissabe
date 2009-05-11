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

function smarty_function_placeholder($params, &$smarty)
{
	if (!$smarty->placeholder_loaded)
	{
		$smarty->placeholder_loaded = true;
		$smarty->display($smarty->get_template_vars("__ACTION_VIEW_FILE_PATH__"));
	}
}

?>
