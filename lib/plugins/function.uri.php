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

function smarty_function_uri($params, &$smarty)
{
    return rtrim(site_root, "/")."/".ltrim($params["path"], "/");
}

